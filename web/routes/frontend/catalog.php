<?php
/**
 * Description of base.php.
 *
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 */

$app->match('/catalog', function() use($app) {

    $category_columns = array(
        'id',
        'name'
    );

    $categories = array();

    $category_sql = "SELECT id, name FROM `categories`";
    $rows_sql = $app['db']->fetchAll($category_sql, array());

    foreach ($rows_sql as $row_key => $row_sql) {
        for($i = 0; $i < count($category_columns); $i++) {
            $categories[$row_key][$category_columns[$i]] = $row_sql[$category_columns[$i]];
        }
    }

    $provider_columns = array(
        'id',
        'name'
    );

    $providers = array();

    $provider_sql = "SELECT id, name FROM `providers`";
    $rows_sql = $app['db']->fetchAll($provider_sql, array());

    foreach ($rows_sql as $row_key => $row_sql) {
        for($i = 0; $i < count($provider_columns); $i++) {
            $providers[$row_key][$provider_columns[$i]] = $row_sql[$provider_columns[$i]];
        }
    }

    $product_columns = array(
        'id',
        'provider_id',
        'category_id',
        'category',
        'provider',
        'name',
        'price',
        'sizes',
        'image',
    );

    $primary_key = "id";
    $products = array();

    $category_id = $app['request']->get('category');
    $provider_id = $app['request']->get('provider');

    if ($category_id) {
        $find_sql = "SELECT * FROM `products` WHERE category_id = $category_id";
    } elseif ($provider_id) {
        $find_sql = "SELECT * FROM `products` WHERE provider_id = $provider_id";
    } else {
        $find_sql = "SELECT * FROM `products`";
    }

    $rows_sql = $app['db']->fetchAll($find_sql, array());

    /**
     * Paginacion
     */

    $numProd = count($rows_sql);
    $pages = array();

    $lastPage = null;

    if ($numProd > 9) {
        $numPages = (int) ($numProd/9);

        if ($numPages > 9) {
            for ($i = 1; $i <= $numPages; $i++) {
                $pages[] = $i;
            }
        }

        for ($i = 1; $i <= $numPages; $i++) {
            $pages[] = $i;
        }
        $lastPage = $i;
    }

    $numPage = $app['request']->get('page');

    if ($numPage) {
        $numPageActual = ($numPage - 1) * 9;
    } else {
        $numPage = 1;
        $numPageActual = 0;
    }

    /**
     * Fin de paginacion
     */

    $find_sql = "SELECT `products`.*, categories.name as category, providers.name as provider FROM `products` ";
    $find_sql .= "INNER JOIN categories ON category_id = categories.id ";
    $find_sql .= "INNER JOIN providers ON provider_id = providers.id ";
    if ($category_id) {
        $find_sql .= " WHERE category_id = $category_id ";
    } elseif ($provider_id) {
        $find_sql .= " WHERE provider_id = $provider_id ";
    }
    $find_sql .= "ORDER BY `products`.`created` DESC ";
    $find_sql .= "LIMIT $numPageActual, 9";
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
        for($i = 0; $i < count($product_columns); $i++){
            $products[$row_key][$product_columns[$i]] = $row_sql[$product_columns[$i]];
        }
    }

    return $app['twig']->render('frontend/catalog.html.twig', array(
        "primary_key" => $primary_key,
        "categories"  => $categories,
        "products"    => $products,
        "providers"   => $providers,
        "pages"       => $pages,
        "numPage"     => $numPage,
        "lastPage"    => $lastPage,
        "category_id" => $category_id,
        "provider_id" => $provider_id
    ));

})
->method('GET')
->bind('catalog');

$app->match('/catalog/{id}', function($id) use($app) {

    $find_sql = "SELECT * FROM `products` WHERE `id` = ?";
    $product_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$product_sql) {
        return $app->redirect($app['url_generator']->generate('catalog'));
    }

    $colors_columns = array(
        'id',
        'name',
        'product_id',
        'color_hex'
    );

    $colors = array();
    $find_sql = "SELECT * FROM `colors` WHERE product_id = ?";
    $colors_sql = $app['db']->fetchAll($find_sql, array($id));

    foreach ($colors_sql as $row_key => $row_sql) {
        for ($i = 0; $i < count($colors_columns); $i++) {
            $colors[$row_key][$colors_columns[$i]] = $row_sql[$colors_columns[$i]];
        }
    }

    $product_sql['colors'] = $colors;

    $product_columns = array(
        'id',
        'provider_id',
        'category_id',
        'category',
        'provider',
        'name',
        'price',
        'image',
    );

    $related_products = array();

    $find_sql = "SELECT `products`.*, categories.name as category, providers.name as provider FROM `products` ";
    $find_sql .= "INNER JOIN categories ON category_id = categories.id ";
    $find_sql .= "INNER JOIN providers ON provider_id = providers.id ";
    $find_sql .= "WHERE products.id != ? AND (products.provider_id = $product_sql[provider_id] OR products.category_id = $product_sql[category_id]) LIMIT 0,5";
    $rows_sql = $app['db']->fetchAll($find_sql, array($id));

    foreach($rows_sql as $row_key => $row_sql){
        for($i = 0; $i < count($product_columns); $i++){
            $related_products[$row_key][$product_columns[$i]] = $row_sql[$product_columns[$i]];
        }
    }

    return $app['twig']->render('frontend/catalog_item.html.twig', array(
        'product' => $product_sql,
        'related_products' => $related_products
    ));
})
->method('GET')
->bind('catalog_item');
