<?php
/**
 * Description of Order.php.
 * 
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 * @package Bodeven\Cart
 */

namespace Bodeven\Cart;

use Bodeven\Cart\Cart,
    Bodeven\Cart\Collection;

class Order {

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var array
     */
    protected $products;

    public function __construct(Cart $cart) {
        $this->cart     = $cart;
        $this->products = $this->cart->getProducts();
    }

    /**
     * @return string
     */
    public function getTableProducts() {
        $styles = array();

        $styles['table'] = 'max-width: 100%;
                            background-color: transparent;
                            border-collapse: collapse;
                            border-spacing: 0px;
                            box-sizing: border-box;
                            margin-bottom: 0px;';

        $styles['td'] = 'padding: 8px;
                         line-height: 1.42857;
                         vertical-align: top;
                         border-top: 1px solid #DDD;';

        $table_html  = "<table style=\"$styles[table]\">";

        $table_html .= '<thead>
                            <tr>
                                <th>#</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Cant.</th>
                                <th>Monto</th>
                            </tr>
                        </thead>';

        $table_html .= '<tbody>';

        foreach ($this->products as $product) {
            $table_html .= '<tr>';
            $table_html .= "<td style=\"$styles[td] width:30px\">$product->id</td>";
            $table_html .= "<td style=\"$styles[td] width:50px\">
                                <img src=\"$product->image\" class=\"img-responsive\" style=\"width: 50px\">
                            </td>";
            $table_html .= "<td style=\"$styles[td]\">$product->name</td>";
            $table_html .= "<td style=\"$styles[td] width:30px\">{$product->count}x{$product->price}</td>";
            $table_html .= "<td style=\"$styles[td] width:0px\">" . ($product->count * $product->price) . "</td>";
            $table_html .= '</tr>';
        }

        $table_html .= '</tbody>';

        $table_html .= '<tfoot>';
        $table_html .= "<tr>
                            <th colspan=\"3\"></th>
                            <th>Total</th>
                            <th>{$this->cart->getTotalMount()}</th>
                            <th></th>
                        </tr>";
        $table_html .= '</tfoot>';

        $table_html .= "</table>";

        return $table_html;
    }

}