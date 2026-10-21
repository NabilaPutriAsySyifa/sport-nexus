<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Women extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = "Women's Footwear Dashboard";
        $data['gender_category'] = 'Women';

        $filters = array(
            'gender'       => array('Women', 'Unisex'),
            'brand'        => $this->input->get('brand'),
            'search'       => $this->input->get('search'),
            'is_published' => 1
        );

        $page = max(1, (int)$this->input->get('p'));
        $per_page = 25;
        $offset = ($page - 1) * $per_page;

        $data['total_products'] = $this->Product_model->count_filtered_products($filters);
        $data['products'] = $this->Product_model->get_filtered_products($filters, $per_page, $offset);

        // Women's Inventory KPI Board (7 Brands)
        $data['kpi_total']    = $data['total_products'];
        $data['kpi_diadora']  = $this->Product_model->count_filtered_products(array('gender' => array('Women', 'Unisex'), 'brand' => array('Diadora')));
        $data['kpi_airwalk']  = $this->Product_model->count_filtered_products(array('gender' => array('Women', 'Unisex'), 'brand' => array('Airwalk')));
        $data['kpi_converse'] = $this->Product_model->count_filtered_products(array('gender' => array('Women', 'Unisex'), 'brand' => array('Converse')));
        $data['kpi_nb']       = $this->Product_model->count_filtered_products(array('gender' => array('Women', 'Unisex'), 'brand' => array('New Balance')));
        $data['kpi_nike']     = $this->Product_model->count_filtered_products(array('gender' => array('Women', 'Unisex'), 'brand' => array('Nike')));
        $data['kpi_puma']     = $this->Product_model->count_filtered_products(array('gender' => array('Women', 'Unisex'), 'brand' => array('Puma')));
        $data['kpi_golf']     = $this->Product_model->count_filtered_products(array('gender' => array('Women', 'Unisex'), 'brand' => array('Nike Golf')));

        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_pages'] = ceil($data['total_products'] / $per_page);
        $data['target_sizes'] = array('36', '36.5', '37', '37.5', '38', '38.5', '39', '40', '40.5', '41');

        $this->render_admin_view('sizing_manager', $data);
    }
}
