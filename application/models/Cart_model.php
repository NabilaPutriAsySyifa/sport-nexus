<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function get_cart() {
        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) {
            $cart = array();
        }

        $items = array();
        $subtotal = 0;
        $total_discount = 0;
        $total_amount = 0;

        $selected_items = array();
        $selected_count = 0;
        $selected_subtotal = 0;
        $selected_total = 0;
        $selected_discount = 0;

        foreach ($cart as $key => $item) {
            $product = $this->Product_model->get_by_id($item['product_id']);
            if ($product) {
                $orig_price = (float)$product->original_price;
                $sale_price = (float)$product->sale_price;
                $qty = (int)$item['qty'];
                $is_selected = isset($item['selected']) ? (bool)$item['selected'] : true;
                
                $item_subtotal = $orig_price * $qty;
                $item_total = $sale_price * $qty;
                $item_discount = ($orig_price - $sale_price) * $qty;

                $item_data = array(
                    'key'            => $key,
                    'product_id'     => $product->id,
                    'sku'            => $product->sku,
                    'name'           => $product->name,
                    'brand_name'     => $product->brand_name,
                    'thumbnail'      => $product->thumbnail,
                    'size_eu'        => $item['size_eu'],
                    'color'          => $item['color'],
                    'original_price' => $orig_price,
                    'sale_price'     => $sale_price,
                    'price'          => $sale_price,
                    'discount'       => $product->discount_percent,
                    'qty'            => $qty,
                    'subtotal'       => $item_subtotal,
                    'total'          => $item_total,
                    'selected'       => $is_selected
                );

                $items[$key] = $item_data;

                $subtotal += $item_subtotal;
                $total_discount += $item_discount;
                $total_amount += $item_total;

                if ($is_selected) {
                    $selected_items[$key] = $item_data;
                    $selected_count += $qty;
                    $selected_subtotal += $item_subtotal;
                    $selected_total += $item_total;
                    $selected_discount += $item_discount;
                }
            }
        }

        $count = array_reduce($items, function($sum, $it) { return $sum + $it['qty']; }, 0);
        $this->session->set_userdata('cart_count', $count);

        return array(
            'items'             => array_values($items),
            'count'             => $count,
            'subtotal'          => $subtotal,
            'total_discount'    => $total_discount,
            'total'             => $total_amount,
            'selected_items'    => array_values($selected_items),
            'selected_count'    => $selected_count,
            'selected_subtotal' => $selected_subtotal,
            'selected_discount' => $selected_discount,
            'selected_total'    => $selected_total
        );
    }

    public function get_selected_cart() {
        $cart = $this->get_cart();
        return array(
            'items'          => $cart['selected_items'],
            'count'          => $cart['selected_count'],
            'subtotal'       => $cart['selected_subtotal'],
            'total_discount' => $cart['selected_discount'],
            'total'          => $cart['selected_total']
        );
    }

    public function toggle_select($key, $selected = true) {
        $cart = $this->session->userdata('cart') ?: array();
        if (isset($cart[$key])) {
            $cart[$key]['selected'] = (bool)$selected;
            $this->session->set_userdata('cart', $cart);
        }
        return $this->get_cart();
    }

    public function select_all($selected = true) {
        $cart = $this->session->userdata('cart') ?: array();
        foreach ($cart as $key => $val) {
            $cart[$key]['selected'] = (bool)$selected;
        }
        $this->session->set_userdata('cart', $cart);
        return $this->get_cart();
    }

    public function remove_selected_items() {
        $cart = $this->session->userdata('cart') ?: array();
        foreach ($cart as $key => $item) {
            $is_selected = isset($item['selected']) ? (bool)$item['selected'] : true;
            if ($is_selected) {
                unset($cart[$key]);
            }
        }
        $this->session->set_userdata('cart', $cart);
        return $this->get_cart();
    }

    public function add_item($product_id, $size_eu, $color, $qty = 1) {
        $cart = $this->session->userdata('cart') ?: array();
        $key = $product_id . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $size_eu) . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $color);

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += (int)$qty;
            $cart[$key]['selected'] = true;
        } else {
            $cart[$key] = array(
                'product_id' => (int)$product_id,
                'size_eu'    => $size_eu,
                'color'      => $color,
                'qty'        => max(1, (int)$qty),
                'selected'   => true
            );
        }

        $this->session->set_userdata('cart', $cart);
        return $this->get_cart();
    }

    public function update_qty($key, $qty) {
        $cart = $this->session->userdata('cart') ?: array();
        if (isset($cart[$key])) {
            $qty = max(1, (int)$qty);
            $cart[$key]['qty'] = $qty;
            $this->session->set_userdata('cart', $cart);
        }
        return $this->get_cart();
    }

    public function remove_item($key) {
        $cart = $this->session->userdata('cart') ?: array();
        if (isset($cart[$key])) {
            unset($cart[$key]);
            $this->session->set_userdata('cart', $cart);
        }
        return $this->get_cart();
    }

    public function clear_cart() {
        $this->session->unset_userdata('cart');
        $this->session->set_userdata('cart_count', 0);
    }

    public function merge_guest_cart($guest_items) {
        if (!empty($guest_items) && is_array($guest_items)) {
            foreach ($guest_items as $item) {
                if (!empty($item['product_id']) && !empty($item['size_eu'])) {
                    $this->add_item(
                        $item['product_id'],
                        $item['size_eu'],
                        isset($item['color']) ? $item['color'] : 'Default',
                        isset($item['qty']) ? (int)$item['qty'] : 1
                    );
                }
            }
        }
        return $this->get_cart();
    }
}
