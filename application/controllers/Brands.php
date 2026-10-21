<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $this->_render_catalog('Brands Catalog', 'brands');
    }

    public function brand($slug = '') {
        $brand_map = array(
            'diadora'             => 'Diadora',
            'new-balance'         => 'New Balance',
            'airwalk'             => 'Airwalk',
            'converse'            => 'Converse',
            'converse-kids'       => 'Converse Kids',
            'nike'                => 'Nike',
            'nike-young-athletes' => 'Nike Young Athletes',
            'nike-golf'           => 'Nike Golf',
            'puma'                => 'Puma',
            'puma-golf'           => 'Puma Golf'
        );

        $brand_name = isset($brand_map[strtolower($slug)]) ? $brand_map[strtolower($slug)] : ucfirst(str_replace('-', ' ', $slug));
        $_GET['brand'] = array($brand_name);

        $this->_render_catalog($brand_name . ' Shoes', 'brands', $brand_name);
    }

    public function sale() {
        $_GET['min_discount'] = 1;
        $this->_render_catalog('Sale & Promo Footwear', 'sale');
    }

    protected function _render_catalog($page_title, $scope = 'brands', $active_brand = null) {
        $data['page_title'] = $page_title;
        $data['scope'] = $scope;
        $data['active_brand'] = $active_brand;

        // Collect filters from $_GET
        $filters = array(
            'brand'         => $this->input->get('brand'),
            'gender'        => $this->input->get('gender'),
            'primary_sport' => $this->input->get('activity'),
            'footwear_type' => $this->input->get('footwear_type'),
            'color'         => $this->input->get('color'),
            'size_eu'       => $this->input->get('size_eu'),
            'size_us'       => $this->input->get('size_us'),
            'min_price'     => $this->input->get('min_price'),
            'max_price'     => $this->input->get('max_price'),
            'min_discount'  => $this->input->get('min_discount'),
            'max_discount'  => $this->input->get('max_discount'),
            'search'        => $this->input->get('search'),
            'sort'          => $this->input->get('sort') ?: 'relevance',
            'is_published'  => 1
        );

        // Pagination
        $page = max(1, (int)$this->input->get('p'));
        $per_page = 36;
        $offset = ($page - 1) * $per_page;

        $total_results = $this->Product_model->count_filtered_products($filters);
        $products = $this->Product_model->get_filtered_products($filters, $per_page, $offset);

        // If AJAX request, return reactive JSON for React/Client
        if ($this->input->is_ajax_request() || $this->input->get('format') === 'json') {
            $this->json_response(array(
                'status'        => 'success',
                'total_results' => $total_results,
                'page'          => $page,
                'per_page'      => $per_page,
                'total_pages'   => ceil($total_results / $per_page),
                'products'      => $products
            ));
        }

        $data['products'] = $products;
        $data['total_results'] = $total_results;
        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_pages'] = ceil($total_results / $per_page);
        $data['filters'] = $filters;

        $this->render_user_view('catalog_view', $data);
    }
}
