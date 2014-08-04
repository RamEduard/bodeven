<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/users', function () use ($app) {
    
	$table_columns = array(
		'id',
		'perfil',
		'estatus',
		'name', 
		'username', 
		'email',
    );

    $primary_key = "id";
	$rows = array();

    $find_sql = "SELECT `users`.*, `perfils`.name as perfil, `estatus`.name as estatus FROM `users` ";
    $find_sql .= "INNER JOIN `estatus` ON estatus_id = `estatus`.id ";
    $find_sql .= "INNER JOIN `perfils` ON perfil_id = `perfils`.id ";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
    	for($i = 0; $i < count($table_columns); $i++){

			if($table_columns[$i] == 'estatus_id'){
			    $findexternal_sql = 'SELECT `name` FROM `estatus` WHERE `id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['name'];
			}
			else{
			    $rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];
			}


    	}
    }

    return $app['twig']->render('backend/users/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows
    ));
        
})
->bind('users_list');

$app->match('/admin/users/create', function () use ($app) {

    // Se adquiere el encoder
    $encoder = $app['security.encoder.digest'];
    // Se adquiere el token
    $token = $app['security']->getToken();
    // Se adquiere el usuario
    if (is_object($token)) {
        $user = $token->getUser();
    }

    $initial_data = array(
		'perfil_id' => '', 
		'estatus_id' => '', 
		'name' => '', 
		'username' => '', 
		'password' => '',
		'email' => '',
		'created' => '', 
		'updated' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$options = array();
	$findexternal_sql = 'SELECT `id`, `name` FROM `estatus`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['id']] = $findexternal_row['name'];
	}
	if(count($options) > 0){
	    $form = $form->add('estatus_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('estatus_id', 'text', array('required' => true));
	}

    $options = array();
    $findexternal_sql = 'SELECT `id`, `name` FROM `perfils` WHERE name != "ROLE_Programador"';
    $findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
    foreach($findexternal_rows as $findexternal_row){
        $options[$findexternal_row['id']] = $findexternal_row['name'];
    }
    if(count($options) > 0){
        $form = $form->add('perfil_id', 'choice', array(
            'required' => true,
            'choices' => $options,
            'expanded' => false,
            'constraints' => new Assert\Choice(array_keys($options))
        ));
    }
    else{
        $form = $form->add('perfil_id', 'text', array('required' => true));
    }

	$form = $form->add('name', 'text', array('required' => true));
	$form = $form->add('username', 'text', array('required' => true));
	$form = $form->add('password', 'password', array('required' => true));
	$form = $form->add('email', 'email', array('required' => true));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            // codificar la clave
            $password = $encoder->encodePassword($data['password'], $user->getSalt());

            $update_query = "INSERT INTO `users` (`perfil_id`, `estatus_id`, `name`, `username`, `password`, `email`, `created`) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $app['db']->executeUpdate($update_query, array($data['perfil_id'], $data['estatus_id'], $data['name'], $data['username'], $password, $data['email']));


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Usuario creado!',
                )
            );
            return $app->redirect($app['url_generator']->generate('users_list'));

        }
    }

    return $app['twig']->render('backend/users/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('users_create');



$app->match('/admin/users/edit/{id}', function ($id) use ($app) {

    // Se adquiere el encoder
    $encoder = $app['security.encoder.digest'];
    // Se adquiere el token
    $token = $app['security']->getToken();
    // Se adquiere el usuario
    if (is_object($token)) {
        $user = $token->getUser();
    }

    $find_sql = "SELECT * FROM `users` WHERE `id` = ? ";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => '¡Usuario no encontrado!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('users_list'));
    }

    
    $initial_data = array(
		'perfil_id' => $row_sql['perfil_id'], 
		'estatus_id' => $row_sql['estatus_id'], 
		'name' => $row_sql['name'], 
		'username' => $row_sql['username'], 
		'email' => $row_sql['email'],
    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);

    $options = array();
    $findexternal_sql = 'SELECT `id`, `name` FROM `estatus`';
    $findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
    foreach($findexternal_rows as $findexternal_row){
        $options[$findexternal_row['id']] = $findexternal_row['name'];
    }
    if(count($options) > 0){
        $form = $form->add('estatus_id', 'choice', array(
            'required' => true,
            'choices' => $options,
            'expanded' => false,
            'constraints' => new Assert\Choice(array_keys($options))
        ));
    }
    else{
        $form = $form->add('estatus_id', 'text', array('required' => true));
    }

    $options = array();
    $findexternal_sql = 'SELECT `id`, `name` FROM `perfils` WHERE name != "ROLE_Programador"';
    $findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
    foreach($findexternal_rows as $findexternal_row){
        $options[$findexternal_row['id']] = $findexternal_row['name'];
    }
    if(count($options) > 0){
        $form = $form->add('perfil_id', 'choice', array(
            'required' => true,
            'choices' => $options,
            'expanded' => false,
            'constraints' => new Assert\Choice(array_keys($options))
        ));
    }
    else{
        $form = $form->add('perfil_id', 'text', array('required' => true));
    }

	$form = $form->add('name', 'textarea', array('required' => true));
	$form = $form->add('username', 'text', array('required' => true));
	$form = $form->add('password', 'password', array('required' => false));
	$form = $form->add('email', 'text', array('required' => true));

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            if (!empty($data['password'])) {
                // codificar la clave
                $password = $encoder->encodePassword($data['password'], $user->getSalt());

                $update_query = "UPDATE `users` SET `perfil_id` = ?, `estatus_id` = ?, `name` = ?, `username` = ?, `password` = ?, `email` = ? WHERE `id` = ?";
                $app['db']->executeUpdate($update_query, array($data['perfil_id'], $data['estatus_id'], $data['name'], $data['username'], $password, $data['email'], $id));
            } else {
                $update_query = "UPDATE `users` SET `perfil_id` = ?, `estatus_id` = ?, `name` = ?, `username` = ?, `email` = ? WHERE `id` = ?";
                $app['db']->executeUpdate($update_query, array($data['perfil_id'], $data['estatus_id'], $data['name'], $data['username'], $data['email'], $id));
            }


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '¡Usuario editado!',
                )
            );
            return $app->redirect($app['url_generator']->generate('users_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/users/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('users_edit');



$app->match('/admin/users/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `users` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `users` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'users deleted!',
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

    return $app->redirect($app['url_generator']->generate('users_list'));

})
->bind('users_delete');






