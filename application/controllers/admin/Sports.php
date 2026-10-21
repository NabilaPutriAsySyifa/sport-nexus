<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sports extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = 'Sports & Activity Management';

        $sport_filter = $this->input->get('sport');
        $filters = array('is_published' => 1);
        if (!empty($sport_filter) && $sport_filter !== 'Semua') {
            $filters['primary_sport'] = array($sport_filter);
        }

        $page = max(1, (int)$this->input->get('p'));
        $per_page = 25;
        $offset = ($page - 1) * $per_page;

        $data['total_products'] = $this->Product_model->count_filtered_products($filters);
        $data['products'] = $this->Product_model->get_filtered_products($filters, $per_page, $offset);

        // Sports Distribution KPI Metrics
        $data['kpi_lifestyle'] = $this->Product_model->count_filtered_products(array('primary_sport' => array('Lifestyle')));
        $data['kpi_running']   = $this->Product_model->count_filtered_products(array('primary_sport' => array('Running')));
        $data['kpi_fitness']   = $this->Product_model->count_filtered_products(array('primary_sport' => array('Fitness')));
        $data['kpi_soccer']    = $this->Product_model->count_filtered_products(array('primary_sport' => array('Soccer')));
        $data['kpi_tennis']    = $this->Product_model->count_filtered_products(array('primary_sport' => array('Tennis')));
        $data['kpi_badminton'] = $this->Product_model->count_filtered_products(array('primary_sport' => array('Badminton')));
        $data['kpi_golf']      = $this->Product_model->count_filtered_products(array('primary_sport' => array('Golf')));
        $data['kpi_swimming']  = $this->Product_model->count_filtered_products(array('primary_sport' => array('Swimming')));

        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_pages'] = ceil($data['total_products'] / $per_page);
        $data['selected_sport'] = $sport_filter;

        $this->render_admin_view('sports_matrix', $data);
    }

    public function assign_activity() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));

        $product_id = $this->input->post('product_id');
        $new_sport  = $this->input->post('primary_sport');

        if ($product_id && $new_sport) {
            $this->db->where('id', $product_id)->update('products', array('primary_sport' => $new_sport));
            $this->json_response(array('status' => 'success', 'message' => 'Cabang olahraga berhasil diubah!'));
        }
        $this->json_response(array('status' => 'error', 'message' => 'Data tidak lengkap'), 400);
    }
}
