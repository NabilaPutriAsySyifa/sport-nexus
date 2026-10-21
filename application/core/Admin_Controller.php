<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

    protected $admin_user = null;

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');

        // Verify Admin Session
        if (!$this->session->userdata('admin_logged_in')) {
            // If request is AJAX / JSON API
            if ($this->input->is_ajax_request() || $this->input->get_request_header('Accept') === 'application/json') {
                $this->json_response(array('status' => 'error', 'message' => 'Unauthorized admin access'), 401);
            }
            redirect('admin/signin');
            exit;
        }

        $admin_id = $this->session->userdata('admin_id');
        $this->admin_user = $this->Admin_model->get_by_id($admin_id);
        if (!$this->admin_user) {
            $this->session->unset_userdata(array('admin_logged_in', 'admin_id', 'admin_name', 'admin_role'));
            redirect('admin/signin');
            exit;
        }
    }

    /**
     * Check if active admin has required role
     */
    protected function require_role($allowed_roles = array()) {
        if (!in_array($this->admin_user->role, $allowed_roles)) {
            show_error('Access Denied: You do not have permission to access this module.', 403, 'Permission Denied');
            exit;
        }
    }

    /**
     * Render view with isolated admin header and status bar footer
     */
    protected function render_admin_view($view_name, $data = array()) {
        $this->load->model('Product_model');
        $data['admin_user'] = $this->admin_user;
        $data['total_skus'] = $this->Product_model->get_total_count();
        $data['low_stock_count'] = $this->Product_model->get_low_stock_count(5);
        $data['app_version'] = 'v1.0.0 (Release 2026)';
        
        $this->load->view('layouts/header_admin', $data);
        $this->load->view('admin/' . $view_name, $data);
        $this->load->view('layouts/footer_admin', $data);
    }
}
