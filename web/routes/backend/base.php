<?php

require_once __DIR__.'/auth.php';
require_once __DIR__.'/categories.php';
require_once __DIR__.'/colors.php';
require_once __DIR__.'/estatus.php';
require_once __DIR__ . '/image.php';
require_once __DIR__.'/perfils.php';
require_once __DIR__.'/products.php';
require_once __DIR__.'/providers.php';
require_once __DIR__.'/users.php';

$app->match('/admin', function () use ($app) {

    return $app['twig']->render('ag_dashboard.html.twig', array());
        
})
->bind('dashboard');