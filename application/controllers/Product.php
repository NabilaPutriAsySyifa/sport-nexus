<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function detail($sku = '') {
        $product = $this->Product_model->get_by_sku($sku);
        if (!$product && is_numeric($sku)) {
            $product = $this->Product_model->get_by_id($sku);
        }

        if (!$product) {
            show_404();
            return;
        }

        $data['product'] = $product;
        $data['page_title'] = $product->name;

        // Fetch related products from same brand
        $data['related_products'] = $this->Product_model->get_filtered_products(
            array('brand' => array($product->brand_name), 'is_published' => 1),
            4,
            0
        );

        $this->render_user_view('pdp_view', $data);
    }
}
