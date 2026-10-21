<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function signin() {
        $redirect = $this->input->get('redirect') ?: ($this->input->post('redirect') ?: $this->session->userdata('redirect_after_login'));

        if ($this->session->userdata('user_logged_in')) {
            redirect($redirect ?: '');
            return;
        }

        $data['page_title'] = 'Sign In with Sport Nexus';
        $data['error'] = '';
        $data['redirect'] = $redirect;
        $data['auth_notice'] = $this->session->flashdata('auth_notice');

        if ($this->input->method() === 'post') {
            $email = trim($this->input->post('email'));
            $password = $this->input->post('password');

            $user = $this->User_model->authenticate($email, $password);
            if ($user) {
                $user_full_name = trim($user->first_name . ' ' . $user->last_name);
                $this->session->set_userdata(array(
                    'user_logged_in' => true,
                    'user_id'        => $user->id,
                    'user_name'      => $user_full_name ?: $user->first_name,
                    'user_email'     => $user->email
                ));

                // Clear redirect from session
                $this->session->unset_userdata('redirect_after_login');
                $target_url = $redirect ? base_url($redirect) : base_url();

                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'success', 'redirect' => $target_url));
                }
                redirect($redirect ?: '');
                return;
            } else {
                $data['error'] = 'Invalid email or password.';
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $data['error']), 401);
                }
            }
        }

        $this->render_user_view('signin_view', $data);
    }

    public function signup() {
        $redirect = $this->input->get('redirect') ?: ($this->input->post('redirect') ?: $this->session->userdata('redirect_after_login'));

        if ($this->session->userdata('user_logged_in')) {
            redirect($redirect ?: '');
            return;
        }

        $data['page_title'] = 'Sign Up';
        $data['error'] = '';
        $data['redirect'] = $redirect;
        $data['auth_notice'] = $this->session->flashdata('auth_notice') ?: ($redirect === 'checkout.html' ? 'Anda wajib mendaftar dan masuk ke akun resmi untuk melanjutkan pembayaran.' : '');

        if ($this->input->method() === 'post') {
            $email = trim($this->input->post('email'));
            $otp = trim($this->input->post('validation_code'));
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            $first_name = trim($this->input->post('first_name'));
            $last_name = trim($this->input->post('last_name'));
            $dob = $this->input->post('date_of_birth');
            $gender = $this->input->post('gender');

            // 1. Check duplicate email first
            if ($this->User_model->check_email_exists($email)) {
                $err = 'The mobile or email already exist.';
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $err), 400);
                }
                $data['error'] = $err;
                $this->render_user_view('signup_view', $data);
                return;
            }

            // 2. Validate OTP
            if (!$this->User_model->verify_otp($email, $otp)) {
                $err = 'Invalid or expired validation code. Please click Send again.';
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $err), 400);
                }
                $data['error'] = $err;
                $this->render_user_view('signup_view', $data);
                return;
            }

            // 3. Validate password
            if (strlen($password) < 8) {
                $err = 'Password must be at least 8 characters long.';
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $err), 400);
                }
                $data['error'] = $err;
                $this->render_user_view('signup_view', $data);
                return;
            }

            if ($password !== $confirm_password) {
                $err = 'Password and confirm password do not match.';
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $err), 400);
                }
                $data['error'] = $err;
                $this->render_user_view('signup_view', $data);
                return;
            }

            // 4. Create user
            $user_data = array(
                'email'         => $email,
                'password'      => $password,
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'date_of_birth' => $dob,
                'gender'        => $gender ?: 'Male'
            );

            $res = $this->User_model->create_user($user_data);
            if ($res['status']) {
                $redir_param = !empty($redirect) ? '&redirect=' . urlencode($redirect) : '';
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array(
                        'status'   => 'success',
                        'message'  => 'Registration successful! Redirecting to sign in...',
                        'redirect' => base_url('signin.html?registered=1' . $redir_param)
                    ));
                }
                redirect('signin.html?registered=1' . $redir_param);
                return;
            } else {
                $data['error'] = $res['message'];
                if ($this->input->is_ajax_request()) {
                    $this->json_response(array('status' => 'error', 'message' => $res['message']), 400);
                }
            }
        }

        $this->render_user_view('signup_view', $data);
    }

    public function send_otp() {
        $email = trim($this->input->post('email'));
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json_response(array('status' => 'error', 'message' => 'Please provide a valid email address.'), 400);
        }

        // Check if email already registered
        if ($this->User_model->check_email_exists($email)) {
            $this->json_response(array('status' => 'error', 'message' => 'The mobile or email already exist.'), 400);
        }

        $otp = $this->User_model->generate_otp($email);

        // Simulation response: in production this emails the customer, in simulation we also return code in JSON for seamless testing!
        $this->json_response(array(
            'status'  => 'success',
            'message' => 'Validation code has been sent to your email: ' . $email,
            'otp'     => $otp
        ));
    }

    public function signout() {
        $this->session->unset_userdata(array('user_logged_in', 'user_id', 'user_name', 'user_email'));
        redirect('');
    }
}
