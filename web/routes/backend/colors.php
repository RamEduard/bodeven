<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/colors', function () use ($app) {
    
	$table_columns = array(
		'id', 
		'product_id', 
		'name', 
		'color', 

    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT * FROM `colors`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
    	for($i = 0; $i < count($table_columns); $i++){

		$rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];


    	}
    }

    return $app['twig']->render('backend/colors/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows
    ));
        
})
->bind('colors_list');



$app->match('/admin/colors/create', function () use ($app) {
    
    $initial_data = array(
		'product_id' => '', 
		'name' => '', 
		'color' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('product_id', 'text', array('required' => true));
	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('color', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `colors` (`product_id`, `name`, `color`) VALUES (?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['product_id'], $data['name'], $data['color']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'colors created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('colors_list'));

        }
    }

    return $app['twig']->render('backend/colors/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('colors_create');



$app->match('/admin/colors/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `colors` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('colors_list'));
    }

    
    $initial_data = array(
		'product_id' => $row_sql['product_id'], 
		'name' => $row_sql['name'], 
		'color' => $row_sql['color'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('product_id', 'text', array('required' => true));
	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('color', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `colors` SET `product_id` = ?, `name` = ?, `color` = ? WHERE `id` = ?";
            $app['db']->executeUpdate($update_query, array($data['product_id'], $data['name'], $data['color'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'colors edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('colors_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/colors/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('colors_edit');



$app->match('/admin/colors/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `colors` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `colors` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'colors deleted!',
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

    return $app->redirect($app['url_generator']->generate('colors_list'));

})
->bind('colors_delete');
