<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/providers', function () use ($app) {
    
	$table_columns = array(
		'id', 
		'name', 
    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT * FROM `providers`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql) {
    	for($i = 0; $i < count($table_columns); $i++) {
		    $rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];
    	}
    }

    return $app['twig']->render('backend/providers/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows
    ));
        
})
->bind('providers_list');

$app->match('/admin/providers/create', function () use ($app) {
    
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

            $update_query = "INSERT INTO `providers` (`name`, `created`) VALUES (?, NOW())";
            $app['db']->executeUpdate($update_query, array($data['name']));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Proveedor creado!',
                )
            );
            return $app->redirect($app['url_generator']->generate('providers_list'));

        }
    }

    return $app['twig']->render('backend/providers/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('providers_create');

$app->match('/admin/providers/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `providers` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Proveedor no encontrado!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('providers_list'));
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

            $update_query = "UPDATE `providers` SET `name` = ? WHERE `id` = ?";
            $app['db']->executeUpdate($update_query, array($data['name'], $id));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Proveedor editado con éxito!',
                )
            );
            return $app->redirect($app['url_generator']->generate('providers_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/providers/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('providers_edit');



$app->match('/admin/providers/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `providers` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `providers` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'providers deleted!',
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

    return $app->redirect($app['url_generator']->generate('providers_list'));

})
->bind('providers_delete');






