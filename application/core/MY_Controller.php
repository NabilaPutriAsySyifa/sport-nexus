<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $current_user = null;

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Product_model');

        // Map brand_uFilter from Sports Station URLs into brand filter
        if ($this->input->get('brand_uFilter')) {
            $buf = $this->input->get('brand_uFilter');
            if (empty($_GET['brand'])) {
                $_GET['brand'] = is_array($buf) ? $buf : array($buf);
            }
        }

        // Check if user is logged in
        if ($this->session->userdata('user_logged_in')) {
            $user_id = $this->session->userdata('user_id');
            $this->current_user = $this->User_model->get_by_id($user_id);
        }
    }

    /**
     * Send standard JSON response
     */
    protected function json_response($data, $status_code = 200) {
        $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    /**
     * Load view wrapped with user layout header and footer
     */
    protected function render_user_view($view_name, $data = array()) {
        $data['current_user'] = $this->current_user;
        $data['cart_count'] = $this->session->userdata('cart_count') ?: 0;
        
        $this->load->view('layouts/header_user', $data);
        $this->load->view('user/' . $view_name, $data);
        $this->load->view('layouts/footer_user', $data);
    }
}

// Ensure Admin_Controller is loaded in CodeIgniter 3 environment
require_once APPPATH . 'core/Admin_Controller.php';
