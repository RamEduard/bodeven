<?php
/**
 * Class CartServiceProvider
 * 
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 * @package Bodeven\SilexProvider
 */

namespace Bodeven\SilexProvider;

use Silex\Application,
    Silex\ServiceProviderInterface,
    Bodeven\Cart\Cart;

class CartServiceProvider implements ServiceProviderInterface{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app['cart'] = $app->share(function($app) {
            $cart = $app['session']->get('cart');
            if (is_object($cart)) {
                return $cart;
            } else {
                $app['session']->set('cart', new Cart());
                return new Cart();
            }
        });
    }

    /**
     * Bootstraps the Cart.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
    }
}