<?php

require_once __DIR__.'/auth.php';
require_once __DIR__.'/categories.php';
require_once __DIR__.'/colors.php';
require_once __DIR__.'/estatus.php';
require_once __DIR__.'/image.php';
require_once __DIR__.'/perfils.php';
require_once __DIR__.'/products.php';
require_once __DIR__.'/providers.php';
require_once __DIR__.'/sizes.php';
require_once __DIR__.'/users.php';

$app->match('/admin', function () use ($app) {

    $find_sql   = "SELECT id FROM `categories`";
    $numCat = $app['db']->fetchAll($find_sql, array());

    $find_sql   = "SELECT id FROM `imagen`";
    $numImag = $app['db']->fetchAll($find_sql, array());

    $find_sql = "SELECT id FROM `products`";
    $numProd = $app['db']->fetchAll($find_sql, array());

    $find_sql = "SELECT id FROM `providers`";
    $numProv = $app['db']->fetchAll($find_sql, array());

    $find_sql = "SELECT id FROM `users`";
    $numUsers = $app['db']->fetchAll($find_sql, array());

    return $app['twig']->render('ag_dashboard.html.twig', array(
        "numCat"  => count($numCat),
        "numProd" => count($numProd),
        "numProv" => count($numProv),
        "numUsers" => count($numUsers),
        "numImag" => count($numImag),
    ));

})
->bind('dashboard');
