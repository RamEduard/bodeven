<?php

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/admin/__TABLENAME__', function () use ($app) {
    
	$table_columns = array(
__TABLECOLUMNS_ARRAY__
    );

    $primary_key = "__TABLE_PRIMARYKEY__";
	$rows = array();

    $find_sql = "SELECT * FROM `__TABLENAME__`";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
    	for($i = 0; $i < count($table_columns); $i++){

__EXTERNALS_FOR_LIST__

    	}
    }

    return $app['twig']->render('backend/__TABLENAME__/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key,
    	"rows" => $rows
    ));
        
})
->bind('__TABLENAME___list');



$app->match('/admin/__TABLENAME__/create', function () use ($app) {
    
    $initial_data = array(
__TABLECOLUMNS_INITIALDATA_EMPTY_ARRAY__
    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);

__EXTERNALSFIELDS_FOR_FORM__

__FIELDS_FOR_FORM__

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `__TABLENAME__` (__INSERT_QUERY_FIELDS__) VALUES (__INSERT_QUERY_VALUES__)";
            $app['db']->executeUpdate($update_query, array(__INSERT_EXECUTE_FIELDS__));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '__TABLENAME__ created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('__TABLENAME___list'));

        }
    }

    return $app['twig']->render('backend/__TABLENAME__/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('__TABLENAME___create');



$app->match('/admin/__TABLENAME__/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `__TABLENAME__` WHERE `__TABLE_PRIMARYKEY__` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('__TABLENAME___list'));
    }

    
    $initial_data = array(
__TABLECOLUMNS_INITIALDATA_ARRAY__
    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);

__EXTERNALSFIELDS_FOR_FORM__
__FIELDS_FOR_FORM__

    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `__TABLENAME__` SET __UPDATE_QUERY_FIELDS__ WHERE `__TABLE_PRIMARYKEY__` = ?";
            $app['db']->executeUpdate($update_query, array(__UPDATE_EXECUTE_FIELDS__, $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => '__TABLENAME__ edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('__TABLENAME___edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('backend/__TABLENAME__/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('__TABLENAME___edit');



$app->match('/admin/__TABLENAME__/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `__TABLENAME__` WHERE `__TABLE_PRIMARYKEY__` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `__TABLENAME__` WHERE `__TABLE_PRIMARYKEY__` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => '__TABLENAME__ deleted!',
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

    return $app->redirect($app['url_generator']->generate('__TABLENAME___list'));

})
->bind('__TABLENAME___delete');






