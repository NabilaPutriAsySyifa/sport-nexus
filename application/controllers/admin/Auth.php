<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    public function signin() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
            return;
        }

        $data['page_title'] = 'Admin Sign In';
        $data['error'] = '';

        if ($this->input->method() === 'post') {
            $email = trim($this->input->post('work_email'));
            $password = $this->input->post('password');

            $admin = $this->Admin_model->authenticate($email, $password);
            if ($admin) {
                $this->session->set_userdata(array(
                    'admin_logged_in'   => true,
                    'admin_id'          => $admin->id,
                    'admin_name'        => $admin->full_name,
                    'admin_email'       => $admin->work_email,
                    'admin_role'        => $admin->role,
                    'admin_employee_id' => $admin->employee_id
                ));

                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'success', 'redirect' => base_url('admin/dashboard')));
                }
                redirect('admin/dashboard');
                return;
            } else {
                $err = 'Access Denied: Invalid admin credentials.';
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $err), 401);
                }
                $data['error'] = $err;
            }
        }

        $this->load->view('admin/signin_view', $data);
    }

    public function signup() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
            return;
        }

        $data['page_title'] = 'Admin Registration';
        $data['error'] = '';

        if ($this->input->method() === 'post') {
            $email = trim($this->input->post('work_email'));
            $passcode = trim($this->input->post('secret_passcode'));
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            $full_name = trim($this->input->post('full_name'));
            $employee_id = trim($this->input->post('employee_id'));
            $role = $this->input->post('role') ?: 'Stock & Catalog Manager';

            if ($password !== $confirm_password) {
                $err = 'Password and confirm password do not match.';
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $err), 400);
                }
                $data['error'] = $err;
                $this->load->view('admin/signup_view', $data);
                return;
            }

            $admin_data = array(
                'work_email'  => $email,
                'password'    => $password,
                'full_name'   => $full_name,
                'employee_id' => $employee_id,
                'role'        => $role
            );

            $result = $this->Admin_model->create_admin($admin_data, $passcode);

            if ($result['status']) {
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array(
                        'status'   => 'success',
                        'message'  => 'Admin registration successful! Redirecting to sign in...',
                        'redirect' => base_url('admin/signin')
                    ));
                }
                redirect('admin/signin?registered=1');
                return;
            } else {
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $result['message']), 400);
                }
                $data['error'] = $result['message'];
            }
        }

        $this->load->view('admin/signup_view', $data);
    }

    public function signout() {
        $this->session->unset_userdata(array('admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role'));
        redirect('admin/signin');
    }
}
