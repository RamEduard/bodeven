<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/categories', function () use ($app) {
    
	$table_columns = array(
		'id', 
		'name',
    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT * FROM `categories`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
    	for($i = 0; $i < count($table_columns); $i++){

		$rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];


    	}
    }

    return $app['twig']->render('backend/categories/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows
    ));
        
})
->bind('categories_list');



$app->match('/admin/categories/create', function () use ($app) {
    
    $initial_data = array(
		'name' => '', 
    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$form = $form->add('name', 'text', array('required' => true));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `categories` (`name`, `created`) VALUES (?, NOW())";
            $app['db']->executeUpdate($update_query, array($data['name']));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Categoría creada!',
                )
            );
            return $app->redirect($app['url_generator']->generate('categories_list'));
        }
    }

    return $app['twig']->render('backend/categories/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('categories_create');

$app->match('/admin/categories/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `categories` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Categoría no encontrada!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('categories_list'));
    }

    
    $initial_data = array(
		'name' => $row_sql['name'],		
    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$form = $form->add('name', 'text', array('required' => true));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `categories` SET `name` = ? WHERE `id` = ?";
            $app['db']->executeUpdate($update_query, array($data['name'], $id));

            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Categoría editada con éxito!',
                )
            );
            return $app->redirect($app['url_generator']->generate('categories_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/categories/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('categories_edit');

$app->match('/admin/categories/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `categories` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `categories` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => '¡Categoría eliminada con éxito!',
            )
        );
    }
    else{
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Categoría no encontrada!',
            )
        );  
    }

    return $app->redirect($app['url_generator']->generate('categories_list'));

})
->bind('categories_delete');