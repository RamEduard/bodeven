<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/perfils', function () use ($app) {
    
	$table_columns = array(
		'id', 
		'name',
    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT * FROM `perfils`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
    	for($i = 0; $i < count($table_columns); $i++){
		    $rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];
    	}
    }

    return $app['twig']->render('backend/perfils/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows
    ));
        
})
->bind('perfils_list');



$app->match('/admin/perfils/create', function () use ($app) {
    
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

            $update_query = "INSERT INTO `perfils` (`name`) VALUES (?)";
            $app['db']->executeUpdate($update_query, array($data['name']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Perfil creado!',
                )
            );
            return $app->redirect($app['url_generator']->generate('perfils_list'));

        }
    }

    return $app['twig']->render('backend/perfils/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('perfils_create');

$app->match('/admin/perfils/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `perfils` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Perfil no encontrado!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('perfils_list'));
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

            $update_query = "UPDATE `perfils` SET `name` = ? WHERE `id` = ?";
            $app['db']->executeUpdate($update_query, array($data['name'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Perfil editado!',
                )
            );
            return $app->redirect($app['url_generator']->generate('perfils_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/perfils/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('perfils_edit');

$app->match('/admin/perfils/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `perfils` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `perfils` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => '¡Perfil eliminado!',
            )
        );
    }
    else{
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Perfil no encontrado!',
            )
        );  
    }

    return $app->redirect($app['url_generator']->generate('perfils_list'));

})
->bind('perfils_delete');