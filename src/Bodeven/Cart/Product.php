<?php

namespace Bodeven\Cart;

/**
 * Class Product
 * @author Ramon Serrano <ramon.calle.88@gmail.com
 * @package Bodeven\Cart
 */
class Product {

    /**
     * @var int $id
     */
    var $id;

    /**
     * @var int $providerId
     */
    var $providerId;

    /**
     * @var int $categoryId
     */
    var $categoryId;

    /**
     * @var string $name
     */
    var $name;

    /**
     * @var float $price
     */
    var $price;

    /**
     * @var string $image
     */
    var $image;

    /**
     * @var string $size
     */
    var $size;

    /**
     * @var int $count
     */
    var $count;

    /**
     * @var string $color
     */
    var $color;

    /**
     * @param int $id
     * @param \Silex\Application $app
     * @param string $color
     * @param string $size
     * @param int $count
     * @param int $providerId
     * @param int $categoryId
     * @param string $name
     * @param float $price
     * @param string $image
     */
    public function __construct($id = 0, \Silex\Application $app = null, $color = "", $size = "", $count = 1, $providerId = 0, $categoryId = 0, $name = "", $price = 0.00, $image = "") {
        $args = func_get_args();

        if (count($args) == 8 && is_object($app)) {
            $this->id         = $id;
            $this->categoryId = $categoryId;
            $this->providerId = $providerId;
            $this->name       = $name;
            $this->price      = $price;
            $this->image      = $image;
            $this->size      = $size;
        } elseif ((count($args) == 2 || count($args) == 3 || count($args) == 4 || count($args) == 5) && is_object($app)) {
            $find_sql = "SELECT * FROM `products` WHERE `id` = ?";
            $product_sql = $app['db']->fetchAssoc($find_sql, array($args[0]));
            if (is_array($product_sql)) {
                $this->id         = $id;
                $this->categoryId = $product_sql['category_id'];
                $this->providerId = $product_sql['provider_id'];
                $this->name       = $product_sql['name'];
                $this->price      = $product_sql['price'];
                $this->image      = $product_sql['image'];
            }
        }

        $this->color = $color;
        $this->count = $count;
        $this->size = $size;
    }

} 