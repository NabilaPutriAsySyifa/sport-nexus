<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_by_id($id) {
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    public function get_by_email($email) {
        return $this->db->get_where('users', array('email' => $email))->row();
    }

    public function check_email_exists($email) {
        return !empty($this->get_by_email($email));
    }

    public function authenticate($email, $password) {
        $user = $this->get_by_email($email);
        if ($user && password_verify($password, $user->password_hash)) {
            return $user;
        }
        return false;
    }

    public function create_user($data) {
        if ($this->get_by_email($data['email'])) {
            return array('status' => false, 'message' => 'The mobile or email already exist.');
        }

        // Format birth date if in DD/MM/YYYY
        $dob = null;
        if (!empty($data['date_of_birth'])) {
            if (strpos($data['date_of_birth'], '/') !== false) {
                $parts = explode('/', $data['date_of_birth']);
                if (count($parts) === 3) {
                    $dob = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                }
            } else {
                $dob = $data['date_of_birth'];
            }
        }

        $insert_data = array(
            'email'         => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'date_of_birth' => $dob,
            'gender'        => isset($data['gender']) ? $data['gender'] : 'Male'
        );

        $this->db->insert('users', $insert_data);
        return array('status' => true, 'id' => $this->db->insert_id());
    }

    // OTP functions
    public function generate_otp($email) {
        $otp = strval(rand(100000, 999999));
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        
        $this->db->where('email', $email)->delete('email_otps');
        $this->db->insert('email_otps', array(
            'email'      => $email,
            'otp_code'   => $otp,
            'expires_at' => $expires
        ));

        return $otp;
    }

    public function verify_otp($email, $otp_code) {
        $this->db->where('email', $email);
        $this->db->where('otp_code', trim($otp_code));
        $this->db->where('expires_at >=', date('Y-m-d H:i:s'));
        $record = $this->db->get('email_otps')->row();
        
        if ($record) {
            $this->db->where('id', $record->id)->delete('email_otps');
            return true;
        }
        return false;
    }

    // Multi-Address Management
    public function get_user_addresses($user_id) {
        return $this->db->where('user_id', $user_id)->order_by('is_primary', 'DESC')->order_by('id', 'DESC')->get('user_addresses')->result();
    }

    public function add_address($user_id, $data) {
        $count = $this->db->where('user_id', $user_id)->count_all_results('user_addresses');
        $is_primary = ($count === 0 || !empty($data['is_primary'])) ? 1 : 0;
        
        if ($is_primary) {
            $this->db->where('user_id', $user_id)->update('user_addresses', array('is_primary' => 0));
        }

        $insert_data = array(
            'user_id'        => $user_id,
            'recipient_name' => $data['recipient_name'],
            'phone_number'   => $data['phone_number'],
            'full_address'   => $data['full_address'],
            'province'       => !empty($data['province']) ? $data['province'] : 'Jawa Barat',
            'city'           => !empty($data['city']) ? $data['city'] : 'Kota Bekasi',
            'district'       => !empty($data['district']) ? $data['district'] : 'Bekasi Selatan',
            'postal_code'    => !empty($data['postal_code']) ? $data['postal_code'] : '17148',
            'is_primary'     => $is_primary
        );

        $this->db->insert('user_addresses', $insert_data);
        return $this->db->insert_id();
    }

    public function update_address($address_id, $user_id, $data) {
        if (!empty($data['is_primary'])) {
            $this->db->where('user_id', $user_id)->update('user_addresses', array('is_primary' => 0));
        }

        $this->db->where('id', $address_id)->where('user_id', $user_id)->update('user_addresses', $data);
        return true;
    }

    public function delete_address($address_id, $user_id) {
        $this->db->where('id', $address_id)->where('user_id', $user_id)->delete('user_addresses');
        return true;
    }
}
