<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/products', function () use ($app) {
    
	$table_columns = array(
		'id', 
		'provider_id', 
		'category_id', 
		'name', 
		'price', 
		'image',		
    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT * FROM `products`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
    	for($i = 0; $i < count($table_columns); $i++){

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



$app->match('/products/create', function () use ($app) {
    
    $initial_data = array(
		'provider_id' => '', 
		'category_id' => '', 
		'name' => '', 
		'price' => '', 
		'image' => '', 
		'created' => '', 
		'updated' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('provider_id', 'text', array('required' => true));
	$form = $form->add('category_id', 'text', array('required' => true));
	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('price', 'text', array('required' => true));
	$form = $form->add('image', 'textarea', array('required' => true));
	$form = $form->add('created', 'text', array('required' => true));
	$form = $form->add('updated', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `products` (`provider_id`, `category_id`, `name`, `price`, `image`, `created`, `updated`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['provider_id'], $data['category_id'], $data['name'], $data['price'], $data['image'], $data['created'], $data['updated']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'products created!',
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



$app->match('/products/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `products` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('products_list'));
    }

    
    $initial_data = array(
		'provider_id' => $row_sql['provider_id'], 
		'category_id' => $row_sql['category_id'], 
		'name' => $row_sql['name'], 
		'price' => $row_sql['price'], 
		'image' => $row_sql['image'], 
		'created' => $row_sql['created'], 
		'updated' => $row_sql['updated'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('provider_id', 'text', array('required' => true));
	$form = $form->add('category_id', 'text', array('required' => true));
	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('price', 'text', array('required' => true));
	$form = $form->add('image', 'textarea', array('required' => true));
	$form = $form->add('created', 'text', array('required' => true));
	$form = $form->add('updated', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `products` SET `provider_id` = ?, `category_id` = ?, `name` = ?, `price` = ?, `image` = ?, `created` = ?, `updated` = ? WHERE `id` = ?";
            $app['db']->executeUpdate($update_query, array($data['provider_id'], $data['category_id'], $data['name'], $data['price'], $data['image'], $data['created'], $data['updated'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'products edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('products_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/products/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('products_edit');



$app->match('/products/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `products` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `products` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'products deleted!',
            )
        );
    }
    else{
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );  
    }

    return $app->redirect($app['url_generator']->generate('products_list'));

})
->bind('products_delete');






