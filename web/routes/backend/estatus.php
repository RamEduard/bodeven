<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/estatus', function () use ($app) {
    
	$table_columns = array(
		'id', 
		'name', 
    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT * FROM `estatus`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
    	for($i = 0; $i < count($table_columns); $i++){

		$rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];


    	}
    }

    return $app['twig']->render('backend/estatus/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows
    ));
        
})
->bind('estatus_list');



$app->match('/admin/estatus/create', function () use ($app) {
    
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

            $update_query = "INSERT INTO `estatus` (`name`) VALUES (?)";
            $app['db']->executeUpdate($update_query, array($data['name']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'estatus created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('estatus_list'));

        }
    }

    return $app['twig']->render('backend/estatus/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('estatus_create');



$app->match('/admin/estatus/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `estatus` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('estatus_list'));
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

            $update_query = "UPDATE `estatus` SET `name` = ? WHERE `id` = ?";
            $app['db']->executeUpdate($update_query, array($data['name'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'estatus edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('estatus_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/estatus/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('estatus_edit');



$app->match('/admin/estatus/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `estatus` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `estatus` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'estatus deleted!',
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

    return $app->redirect($app['url_generator']->generate('estatus_list'));

})
->bind('estatus_delete');






