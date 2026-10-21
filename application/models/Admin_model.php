<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    const MASTER_PASSCODE = 'NEXUS-ADMIN-2026';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_id($id) {
        return $this->db->get_where('admin_users', array('id' => $id))->row();
    }

    public function get_by_email($email) {
        return $this->db->get_where('admin_users', array('work_email' => $email))->row();
    }

    public function authenticate($email, $password) {
        $admin = $this->get_by_email($email);
        if ($admin && password_verify($password, $admin->password_hash)) {
            return $admin;
        }
        return false;
    }

    public function create_admin($data, $passcode) {
        if ($passcode !== self::MASTER_PASSCODE) {
            return array('status' => false, 'message' => 'Invalid Admin Secret Key. You are not authorized to register.');
        }

        if ($this->get_by_email($data['work_email'])) {
            return array('status' => false, 'message' => 'Admin email already exists in system.');
        }

        $insert_data = array(
            'work_email'    => $data['work_email'],
            'password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
            'full_name'     => $data['full_name'],
            'employee_id'   => $data['employee_id'],
            'role'          => $data['role']
        );

        $this->db->insert('admin_users', $insert_data);
        return array('status' => true, 'id' => $this->db->insert_id());
    }

    public function get_all_admins() {
        return $this->db->order_by('created_at', 'DESC')->get('admin_users')->result();
    }
}
