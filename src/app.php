<?php

/*
 * This file is part of the CRUD Admin Generator project.
 *
 * Author: Jon Segador <jonseg@gmail.com>
 * Web: http://crud-admin-generator.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

# Proveedor de usuario
require_once __DIR__ . '/../src/UserProvider.php';

use Silex\Application;

$app = new Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../web/views',
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login_path' => array(
            'pattern' => '^/login$',
            'anonymous' => true
        ),
        'default' => array(
            'pattern' => '^/.*$',
            'anonymous' => true,
            'form' => array(
                'login_path' => '/login',
                'check_path' => '/login_check',
            ),
            'logout' => array(
                'logout_path' => '/logout',
                'invalidate_session' => false
            ),
            'users' => $app->share(function($app) {
                return new UserProvider($app['db']);
            }),
        )
    ),
    'security.access_rules' => array(
        array('^/login$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/admin/perfil', 'ROLE_SUPER_ADMIN'),
        array('^/admin/usuario', 'ROLE_SUPER_ADMIN'),
        array('^/admin', array('ROLE_SUPER_ADMIN', 'ROLE_ADMIN')),
        array('^/admin', 'ROLE_USER')
    )
));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(

        'dbs.options' => array(
            'db' => array(
                'driver'   => 'pdo_mysql',
                'dbname'   => 'tania_serrano',
                'host'     => '127.0.0.1',
                'user'     => 'root',
                'password' => '',
                'charset'  => 'utf8',
            ),
        )
));

$app['asset_path'] = 'http://localhost/bodeven2/web/resources';
$app['debug'] = true;

return $app;
