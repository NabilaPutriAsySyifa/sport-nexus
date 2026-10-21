<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cart_model');
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = 'Shopping Cart';
        $data['cart'] = $this->Cart_model->get_cart();
        $this->render_user_view('cart_view', $data);
    }

    public function get_items() {
        $cart = $this->Cart_model->get_cart();
        $this->json_response(array('status' => 'success', 'data' => $cart));
    }

    public function add() {
        $product_id = $this->input->post('product_id');
        $size_eu    = $this->input->post('size_eu');
        $color      = $this->input->post('color');
        $qty        = max(1, (int)$this->input->post('qty'));

        if (empty($product_id)) {
            $this->json_response(array('status' => 'error', 'message' => 'Product ID is required'), 400);
        }

        if (empty($size_eu)) {
            $this->json_response(array('status' => 'error', 'message' => 'Silakan pilih ukuran sepatu terlebih dahulu.'), 400);
        }

        if (empty($color)) {
            $this->json_response(array('status' => 'error', 'message' => 'Silakan pilih varian warna sepatu.'), 400);
        }

        $cart = $this->Cart_model->add_item($product_id, $size_eu, $color, $qty);
        $this->json_response(array(
            'status'     => 'success',
            'message'    => '✔ Success Add to Cart',
            'cart_count' => $cart['count'],
            'cart'       => $cart
        ));
    }

    public function update() {
        $key = $this->input->post('key');
        $qty = (int)$this->input->post('qty');

        if (empty($key)) {
            $this->json_response(array('status' => 'error', 'message' => 'Item key is required'), 400);
        }

        $cart = $this->Cart_model->update_qty($key, $qty);
        $this->json_response(array(
            'status'     => 'success',
            'cart_count' => $cart['count'],
            'cart'       => $cart
        ));
    }

    public function remove() {
        $key = $this->input->post('key');
        if (empty($key)) {
            $this->json_response(array('status' => 'error', 'message' => 'Item key is required'), 400);
        }

        $cart = $this->Cart_model->remove_item($key);
        $this->json_response(array(
            'status'     => 'success',
            'message'    => 'Item removed from cart',
            'cart_count' => $cart['count'],
            'cart'       => $cart
        ));
    }

    public function toggle_select() {
        $key = $this->input->post('key');
        $selected = $this->input->post('selected') !== null ? (int)$this->input->post('selected') : 1;

        if (empty($key)) {
            $this->json_response(array('status' => 'error', 'message' => 'Item key is required'), 400);
        }

        $cart = $this->Cart_model->toggle_select($key, (bool)$selected);
        $this->json_response(array(
            'status'     => 'success',
            'cart_count' => $cart['count'],
            'cart'       => $cart
        ));
    }

    public function select_all() {
        $selected = $this->input->post('selected') !== null ? (int)$this->input->post('selected') : 1;
        $cart = $this->Cart_model->select_all((bool)$selected);
        $this->json_response(array(
            'status'     => 'success',
            'cart_count' => $cart['count'],
            'cart'       => $cart
        ));
    }

    public function remove_selected() {
        $cart = $this->Cart_model->remove_selected_items();
        $this->json_response(array(
            'status'     => 'success',
            'message'    => 'Produk yang dipilih berhasil dihapus.',
            'cart_count' => $cart['count'],
            'cart'       => $cart
        ));
    }

    public function merge() {
        $raw = file_get_contents('php://input');
        $json = json_decode($raw, true);
        $items = isset($json['items']) ? $json['items'] : $this->input->post('items');

        if (!empty($items) && is_array($items)) {
            $cart = $this->Cart_model->merge_guest_cart($items);
            $this->json_response(array('status' => 'success', 'cart' => $cart));
        } else {
            $this->json_response(array('status' => 'success', 'cart' => $this->Cart_model->get_cart()));
        }
    }
}
