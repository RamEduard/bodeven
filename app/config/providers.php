<?php

$app = $this->application;

/**
 * Array Providers
 * 
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 */
return array(
    'twig' => array(
        new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__ . '/../views',
        )
    ),
    'form' => array(
        new Silex\Provider\FormServiceProvider()
    ),
    'translations' => array(
        new Silex\Provider\TranslationServiceProvider(), array(
            'translator.messages' => array(),
        )
    ),
    'validator' => array(
        new Silex\Provider\ValidatorServiceProvider()
    ),
    'url_generator' => array(
        new Silex\Provider\UrlGeneratorServiceProvider()
    ),
    'session' => array(
        new Silex\Provider\SessionServiceProvider()
    ),
    'security' => array(
        new Silex\Provider\SecurityServiceProvider(), array(
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
                        return new Bodeven\UserProvider($app['db']);
                    }),
                )
            ),
            'security.access_rules' => array(
                array('^/login$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
                array('^/admin/perfils', 'ROLE_Programador'),
                array('^/admin/users', array('ROLE_Programador', 'ROLE_Administrador')),
                array('^/admin', array('ROLE_Programador', 'ROLE_Administrador')),
                array('^/admin', 'ROLE_Usuario')
            )
        )
    ),
    'doctrine_dev' => array(new Silex\Provider\DoctrineServiceProvider(), array(
        'dbs.options' => array(
            'db' => array(
                'driver'   => 'pdo_mysql',
                'dbname'   => 'silex_horizonte',
                'host'     => 'localhost',
                'user'     => 'root',
                'password' => '',
                'charset'  => 'utf8'
            )
        )
    )),
//    'doctrine_prod' => array(new Silex\Provider\DoctrineServiceProvider(), array(
//        'dbs.options' => array(
//            'db' => array(
//                'driver'   => 'pdo_mysql',
//                'dbname'   => 'u591717197_bd',
//                'host'     => 'mysql.hostinger.es',
//                'user'     => 'u591717197_bd',
//                'password' => 'bodeven1#',
//                'charset'  => 'utf8'
//            )
//        )
//    )),
    'swiftmailer' => array(
        new Silex\Provider\SwiftmailerServiceProvider()
    ),
    'cart' => array(
        new Bodeven\SilexProvider\CartServiceProvider()
    )
);