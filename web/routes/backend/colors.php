<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/colors/{productId}', function ($productId) use ($app) {
    
	$table_columns = array(
		'id', 
		'product_id', 
		'name', 
		'color_hex',
    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT * FROM `colors` WHERE product_id = ?";
    $rows_sql = $app['db']->fetchAll($find_sql, array($productId));

    foreach($rows_sql as $row_key => $row_sql) {
    	for($i = 0; $i < count($table_columns); $i++) {
		    $rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];
    	}
    }

    return $app['twig']->render('backend/colors/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows,
        "productId" => $productId
    ));
        
})
->bind('colors_list');

$app->match('/admin/colors/{productId}/create', function ($productId) use ($app) {
    
    $initial_data = array(
		'product_id' => $productId,
		'name' => '', 
		'color_hex' => '',
    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$form = $form->add('product_id', 'hidden', array('required' => true));
	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('color_hex', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `colors` (`product_id`, `name`, `color_hex`) VALUES (?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['product_id'], $data['name'], $data['color_hex']));

            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Color agregado!',
                )
            );
            return $app->redirect($app['url_generator']->generate('colors_list', array('productId' => $productId)));

        }
    }

    return $app['twig']->render('backend/colors/create.html.twig', array(
        "form" => $form->createView(),
        "productId" => $productId
    ));
        
})
->bind('colors_create');



$app->match('/admin/colors/{productId}/edit/{id}', function ($productId, $id) use ($app) {

    $find_sql = "SELECT * FROM `colors` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Color del producto no encontrado!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('colors_list'));
    }

    
    $initial_data = array(
		'name' => $row_sql['name'],
		'color_hex' => $row_sql['color_hex'],
    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('color_hex', 'text', array('required' => true));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `colors` SET `name` = ?, `color_hex` = ? WHERE `id` = ? AND `product_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['name'], $data['color_hex'], $id, $productId));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Color del producto editado!',
                )
            );
            return $app->redirect($app['url_generator']->generate('colors_edit', array( "productId" => $productId, "id" => $id)));

        }
    }

    return $app['twig']->render('backend/colors/edit.html.twig', array(
        "form"      => $form->createView(),
        "id"        => $id,
        "productId" => $productId
    ));
        
})
->bind('colors_edit');



$app->match('/admin/colors/{productId}/delete/{id}', function ($productId, $id) use ($app) {

    $find_sql = "SELECT * FROM `colors` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `colors` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => '¡Color del producto eliminado!',
            )
        );
    }
    else{
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Color del producto no encontrado!',
            )
        );  
    }

    return $app->redirect($app['url_generator']->generate('colors_list', array("productId" => $productId)));

})
->bind('colors_delete');
