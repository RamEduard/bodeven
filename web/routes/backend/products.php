<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/products', function () use ($app) {
    
	$table_columns = array(
		'id', 
		'provider',
		'category',
		'name', 
		'price', 
		'image',		
    );

    $primary_key = "id";
	$rows = array();

    $find_sql  = "SELECT `products`.*, `categories`.`name` as category, `providers`.`name` as provider FROM `products` ";
    $find_sql .= "INNER JOIN categories ON category_id = categories.id ";
    $find_sql .= "INNER JOIN providers ON provider_id = providers.id ";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql) {
    	for($i = 0; $i < count($table_columns); $i++) {
		    $rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];
    	}
    }

    return $app['twig']->render('backend/products/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows
    ));
        
})
->bind('products_list');



$app->match('/admin/products/create', function () use ($app) {

    // Categorías
    $find_sql = "SELECT * FROM `categories`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());
    $options_cat = array();

    foreach($rows_sql as $row_key => $row_sql) {
        $options_cat[$row_sql['id']] = $row_sql['name'];
    }

    // Etiquetas
    $find_sql = "SELECT * FROM `providers`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());
    $options_prov = array();

    foreach($rows_sql as $row_key => $row_sql) {
        $options_prov[$row_sql['id']] = $row_sql['name'];
    }
    
    $initial_data = array(
		'provider_id' => '', 
		'category_id' => '', 
		'name'        => '',
		'price'       => '',
        'sizes'       => '',
		'image'       => '',
    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);

    $form = $form->add('provider_id', 'choice', array(
        'choices' => $options_prov,
        'required' => true
    ));
    $form = $form->add('category_id', 'choice', array(
        'choices' => $options_cat,
        'required' => true
    ));
	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('price', 'text', array('required' => true));
    $form = $form->add('sizes', 'text', array('required' => true));
	$form = $form->add('image', 'hidden', array('required' => false));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `products` (`provider_id`, `category_id`, `name`, `price`, `sizes`, `image`, `created`, `updated`) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
            $app['db']->executeUpdate($update_query, array($data['provider_id'], $data['category_id'], $data['name'], $data['price'], $data['sizes'], $data['image']));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Producto creado con éxito!',
                )
            );
            return $app->redirect($app['url_generator']->generate('products_list'));

        }
    }

    return $app['twig']->render('backend/products/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('products_create');



$app->match('/admin/products/edit/{id}', function ($id) use ($app) {

    // Categorías
    $find_sql = "SELECT * FROM `categories`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());
    $options_cat = array();

    foreach($rows_sql as $row_key => $row_sql) {
        $options_cat[$row_sql['id']] = $row_sql['name'];
    }

    // Etiquetas
    $find_sql = "SELECT * FROM `providers`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());
    $options_prov = array();

    foreach($rows_sql as $row_key => $row_sql) {
        $options_prov[$row_sql['id']] = $row_sql['name'];
    }

    $find_sql = "SELECT * FROM `products` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Producto no encontrado!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('products_list'));
    }

    $initial_data = array(
		'provider_id' => $row_sql['provider_id'], 
		'category_id' => $row_sql['category_id'], 
		'name' => $row_sql['name'], 
		'price' => $row_sql['price'],
        'sizes' => $row_sql['sizes'],
        'image' => $row_sql['image'],
    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


    $form = $form->add('provider_id', 'choice', array(
        'choices' => $options_prov,
        'required' => true
    ));
    $form = $form->add('category_id', 'choice', array(
        'choices' => $options_cat,
        'required' => true
    ));
	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('price', 'text', array('required' => true));
    $form = $form->add('sizes', 'text', array('required' => true));
	$form = $form->add('image', 'hidden', array('required' => false));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `products` SET `provider_id` = ?, `category_id` = ?, `name` = ?, `price` = ?, `sizes` = ?, `image` = ?, `created` = ?, `updated` = ? WHERE `id` = ?";
            $app['db']->executeUpdate($update_query, array($data['provider_id'], $data['category_id'], $data['name'], $data['price'], $data['sizes'], $data['image'], $data['created'], $data['updated'], $id));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Producto editado con éxito!',
                )
            );
            return $app->redirect($app['url_generator']->generate('products_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/products/edit.html.twig', array(
        "form"       => $form->createView(),
        "id"         => $id,
        "image_link" => $row_sql['image']
    ));
        
})
->bind('products_edit');



$app->match('/admin/products/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `products` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `products` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => '¡Producto eliminado con éxito!',
            )
        );
    }
    else{
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Producto no encontrado!',
            )
        );  
    }

    return $app->redirect($app['url_generator']->generate('products_list'));

})
->bind('products_delete');






