<?php

require_once __DIR__ . "/cart.php";
require_once __DIR__ . "/catalog.php";
require_once __DIR__ . "/contact.php";

$app->match('/', function () use ($app) {

    return $app['twig']->render('frontend/index.html.twig', array());
        
})
->method('GET')
->bind('home');

$app->match('/about', function() use($app) {

    return $app['twig']->render('frontend/about.html.twig', array());

})
->method('GET')
->bind('about');