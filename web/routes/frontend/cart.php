<?php
/**
 * Description of base.php.
 *
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 */

$app->match('/addToCart', function() use($app) {

    $productId = (int) $app['request']->get('product_id');
    $count     = $app['request']->get('count');
    $color     = $app['request']->get('color');

    $product = new Bodeven\Cart\Product($productId, $app, $color, $count);

    $app['cart']->addProduct($product);

    return $app->redirect($app['url_generator']->generate('catalog_item', array("id" => $productId)));

})
->method('POST')
->bind('addToCart');

$app->match('/pedido', function() use($app) {

    $products = $app['cart']->getProducts();

    return $app['twig']->render('frontend/cart/cart.html.twig', array(
        'products' => $products
    ));

})
->method('GET')
->bind('cart');

$app->match('/hacerPedido', function() use($app) {

    return "Hacer Pedido";

})
->bind('checkout');

$app->match('/product_plus', function() use($app){

    $productId = $app['request']->get('product_id');
    $color      = $app['request']->get('color');

    $product = new Bodeven\Cart\Product($productId, $app, $color);

    $app['cart']->addProduct($product);

    return $app->redirect($app['url_generator']->generate('cart'));

})
->method('POST')
->bind('product_plus');

$app->match('/product_minus', function() use($app){

    $productId = $app['request']->get('product_id');

    $app['cart']->removeProduct($productId);

    return $app->redirect($app['url_generator']->generate('cart'));

})
->method('POST')
->bind('product_minus');

$app->match('/product_remove/{productId}', function ($productId) use ($app) {

    $product = $app['cart']->getProduct($productId);

    if (is_object($product)) {
        for ($i = $product->count; $i >= 0; $i--) {
            $app['cart']->removeProduct($productId);
        }
    }

    return $app->redirect($app['url_generator']->generate('cart'));

})
->bind('product_remove');
