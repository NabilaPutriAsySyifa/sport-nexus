<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kids extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = "Kids' Footwear Dashboard";
        $data['gender_category'] = 'Kids';

        $filters = array(
            'gender'       => array('Boys', 'Girls', 'Unisex Kids'),
            'brand'        => $this->input->get('brand'),
            'search'       => $this->input->get('search'),
            'is_published' => 1
        );

        $page = max(1, (int)$this->input->get('p'));
        $per_page = 25;
        $offset = ($page - 1) * $per_page;

        $data['total_products'] = $this->Product_model->count_filtered_products($filters);
        $data['products'] = $this->Product_model->get_filtered_products($filters, $per_page, $offset);

        // Kids' Inventory KPI Board (6 Brands)
        $data['kpi_total']    = $data['total_products'];
        $data['kpi_diadora']  = $this->Product_model->count_filtered_products(array('gender' => array('Boys', 'Girls', 'Unisex Kids'), 'brand' => array('Diadora')));
        $data['kpi_nike_ya']  = $this->Product_model->count_filtered_products(array('gender' => array('Boys', 'Girls', 'Unisex Kids'), 'brand' => array('Nike Young Athletes')));
        $data['kpi_nb']       = $this->Product_model->count_filtered_products(array('gender' => array('Boys', 'Girls', 'Unisex Kids'), 'brand' => array('New Balance')));
        $data['kpi_ck']       = $this->Product_model->count_filtered_products(array('gender' => array('Boys', 'Girls', 'Unisex Kids'), 'brand' => array('Converse Kids')));
        $data['kpi_converse'] = $this->Product_model->count_filtered_products(array('gender' => array('Boys', 'Girls', 'Unisex Kids'), 'brand' => array('Converse')));
        $data['kpi_nike']     = $this->Product_model->count_filtered_products(array('gender' => array('Boys', 'Girls', 'Unisex Kids'), 'brand' => array('Nike')));
        $data['kpi_airwalk']  = 0;
        $data['kpi_puma']     = 0;

        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_pages'] = ceil($data['total_products'] / $per_page);
        $data['target_sizes'] = array('20', '22', '24', '26', '28', '29', '30', '31', '32', '33', '34', '35');

        $this->render_admin_view('sizing_manager', $data);
    }
}
