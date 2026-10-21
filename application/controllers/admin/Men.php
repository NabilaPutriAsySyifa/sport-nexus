<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Men extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = "Men's Footwear Dashboard";
        $data['gender_category'] = 'Men';

        $filters = array(
            'gender'       => array('Men', 'Unisex'),
            'brand'        => $this->input->get('brand'),
            'search'       => $this->input->get('search'),
            'is_published' => 1
        );

        $page = max(1, (int)$this->input->get('p'));
        $per_page = 25;
        $offset = ($page - 1) * $per_page;

        $data['total_products'] = $this->Product_model->count_filtered_products($filters);
        $data['products'] = $this->Product_model->get_filtered_products($filters, $per_page, $offset);

        // Men's Inventory KPI Board (8 Brands)
        $data['kpi_total']    = $data['total_products'];
        $data['kpi_diadora']  = $this->Product_model->count_filtered_products(array('gender' => array('Men', 'Unisex'), 'brand' => array('Diadora')));
        $data['kpi_converse'] = $this->Product_model->count_filtered_products(array('gender' => array('Men', 'Unisex'), 'brand' => array('Converse')));
        $data['kpi_airwalk']  = $this->Product_model->count_filtered_products(array('gender' => array('Men', 'Unisex'), 'brand' => array('Airwalk')));
        $data['kpi_nb']       = $this->Product_model->count_filtered_products(array('gender' => array('Men', 'Unisex'), 'brand' => array('New Balance')));
        $data['kpi_nike']     = $this->Product_model->count_filtered_products(array('gender' => array('Men', 'Unisex'), 'brand' => array('Nike')));
        $data['kpi_puma']     = $this->Product_model->count_filtered_products(array('gender' => array('Men', 'Unisex'), 'brand' => array('Puma')));
        $data['kpi_golf']     = $this->Product_model->count_filtered_products(array('gender' => array('Men', 'Unisex'), 'brand' => array('Nike Golf', 'Puma Golf')));

        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_pages'] = ceil($data['total_products'] / $per_page);
        $data['target_sizes'] = array('39', '40', '40.5', '41', '42', '42.5', '43', '44', '44.5', '45', '46');

        $this->render_admin_view('sizing_manager', $data);
    }

    public function batch_stock_update() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));
        $size = $this->input->post('size_eu');
        $add_qty = (int)$this->input->post('add_qty');

        if ($size && $add_qty > 0) {
            $this->db->query("UPDATE product_skus ps 
                              JOIN products p ON p.id = ps.product_id 
                              SET ps.stock_qty = ps.stock_qty + ? 
                              WHERE ps.size_eu = ? AND p.gender IN ('Men', 'Unisex')", array($add_qty, $size));
            $this->json_response(array('status' => 'success', 'message' => "Stok ukuran EUR $size berhasil ditambah +$add_qty!"));
        }
        $this->json_response(array('status' => 'error', 'message' => 'Input tidak valid'), 400);
    }
}
