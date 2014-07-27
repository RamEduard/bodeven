<?php
/**
 * Class Cart
 *
 * Esta clase permite manejar funciones basicas de un carrito de
 * compras, esta desarrollada usando el patron de dise�o iterator
 * para orfecer mayor encapsulamiento y orden en los datos
 * para utilizarla deben tener una clase producto que contenga
 * el atributo "codigo" representando la identificacion del producto
 *
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 * @package Bodeven\Cart
 */

namespace Bodeven\Cart;

use Bodeven\Cart\Collection,
    Bodeven\Cart\Product;

class Cart {

    /**
     * @var Collection
     */
    var $products;

    public function __construct() {
        $this->products = new Collection("Bodeven\\Cart\\Product");
    }

    /**
     * @return float
     */
    public function getTotalMount() {
        $total = 0.0;

        $iterator = $this->products->getIterator();
        while ($iterator->valid()) {
            $product = $iterator->current();

            $total_product = $product->count * $product->price;

            $total = $total + $total_product;

            $iterator->next();
        }

        return $total;
    }

    /**
     * @param \Bodeven\Cart\Product $product
     * @return void
     */
    public function addProduct($product) {
        $productColection = $this->getProduct($product->id);
        if ($productColection) {
            $productColection->count++;
        } else {
            $this->products->add($product);
        }
    }

    /**
     * @param int $id
     * @return bool|Product
     */
    public function getProduct($id = 0) {
        $iterator = $this->products->getIterator();
        while ($iterator->valid()) {
            $product = $iterator->current();

            if ($product->id == $id) {
                return $product;
            }

            $iterator->next();
        }
        return false;
    }

    /**
     * @return Collection|bool
     */
    public function getProducts() {
        if ($this->products->count() > 0) {
            $products = array();
            $iterator = $this->products->getIterator();
            while ($iterator->valid()) {
                $products[] = $iterator->current();
                $iterator->next();
            }
            return $products;
        } else {
            return false;
        }
    }

    /**
     * @param \int $id
     * @return bool
     */
    public function removeProduct($id = 0) {
        $iterator = $this->products->getIterator();
        while ($iterator->valid()) {
            $product = $iterator->current();

            if ($product->id == $id) {
                if ($product->count > 1)
                    $product->count--;
                else {
                    $this->products->remove($iterator->key());
                }
            }

            $iterator->next();
        }
    }

    /**
     * @return int
     */
    public function getProductsNumber() {
        $iterator = $this->products->getIterator();
        $count = 0;
        while ($iterator->valid()) {
            $product = $iterator->current();

            if ($product->count > 1) {
                $count += $product->count;
            } else {
                $count++;
            }

            $iterator->next();
        }
        return $count;
    }
}