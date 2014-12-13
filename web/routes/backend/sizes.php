<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/sizes/{productId}', function ($productId) use ($app) {
    
	$table_columns = array(
		'id', 
		'product_id', 
		'size', 
    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT * FROM `sizes` WHERE product_id = ?";
    $rows_sql = $app['db']->fetchAll($find_sql, array($productId));

    foreach($rows_sql as $row_key => $row_sql){
    	for($i = 0; $i < count($table_columns); $i++){
		    $rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];
    	}
    }

    return $app['twig']->render('backend/sizes/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows,
        "productId" => $productId
    ));
        
})
->bind('sizes_list');



$app->match('/admin/sizes/{productId}/create', function ($productId) use ($app) {
    
    $initial_data = array(
        'product_id' => $productId,
		'size' => "",
    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('product_id', 'hidden', array('required' => true));
	$form = $form->add('size', 'text', array('required' => true));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `sizes` (`product_id`, `size`, `created`) VALUES (?, ?, NOW())";
            $app['db']->executeUpdate($update_query, array($data['product_id'], $data['size']));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Talla agregada!',
                )
            );
            return $app->redirect($app['url_generator']->generate('sizes_list', array('productId' => $productId)));

        }
    }

    return $app['twig']->render('backend/sizes/create.html.twig', array(
        "form" => $form->createView(),
        "productId" => $productId
    ));
        
})
->bind('sizes_create');



$app->match('/admin/sizes/{productId}/edit/{id}', function ($productId, $id) use ($app) {

    $find_sql = "SELECT * FROM `sizes` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Talla del producto no encontrado!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('sizes_list'));
    }

    
    $initial_data = array(
		'size' => $row_sql['size'],
    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('size', 'text', array('required' => true));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `sizes` SET `size` = ? WHERE `id` = ? AND `product_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['size'], $id, $productId));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Talla del producto editada!',
                )
            );
            return $app->redirect($app['url_generator']->generate('sizes_edit', array( "productId" => $productId, "id" => $id)));

        }
    }

    return $app['twig']->render('backend/sizes/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id,
        "productId" => $productId
    ));
        
})
->bind('sizes_edit');



$app->match('/admin/sizes/{productId}/delete/{id}', function ($productId, $id) use ($app) {

    $find_sql = "SELECT * FROM `sizes` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `sizes` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => '¡Talla del producto eliminada!',
            )
        );
    }
    else{
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Talla del producto no encontrada!',
            )
        );  
    }

    return $app->redirect($app['url_generator']->generate('sizes_list', array("productId" => $productId)));

})
->bind('sizes_delete');






