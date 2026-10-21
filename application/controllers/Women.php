<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Women extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = "Women's Footwear";
        $data['scope'] = 'women';

        $filters = array(
            'brand'         => $this->input->get('brand'),
            'gender'        => array('Women', 'Unisex'),
            'primary_sport' => $this->input->get('activity'),
            'footwear_type' => $this->input->get('footwear_type') ?: $this->input->get('type'),
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

        // Strict Exclusion: 7 women brands (Diadora, Airwalk, Converse, New Balance, Nike, Puma, Nike Golf)
        if (empty($filters['brand'])) {
            $filters['brand'] = array('Diadora', 'Airwalk', 'Converse', 'New Balance', 'Nike', 'Puma', 'Nike Golf');
        }

        $page = max(1, (int)$this->input->get('p'));
        $per_page = 36;
        $offset = ($page - 1) * $per_page;

        $total_results = $this->Product_model->count_filtered_products($filters);
        $products = $this->Product_model->get_filtered_products($filters, $per_page, $offset);

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
