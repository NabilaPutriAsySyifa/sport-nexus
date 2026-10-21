<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promos extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_model');
    }

    public function index() {
        $this->require_role(array('Super Admin', 'Finance Staff', 'Stock & Catalog Manager'));

        $data['page_title'] = 'Manajemen Promo & Kupon Diskon';
        $data['promos'] = $this->db->order_by('id', 'DESC')->get('promos')->result();

        // Stats
        $data['total_promos'] = count($data['promos']);
        $data['active_promos'] = $this->db->where('is_active', 1)->count_all_results('promos');
        $data['total_used'] = (int)$this->db->select_sum('used_count')->get('promos')->row()->used_count;

        $this->render_admin_view('promos_view', $data);
    }

    public function create() {
        $this->require_role(array('Super Admin', 'Finance Staff'));

        $code = strtoupper(trim($this->input->post('promo_code')));
        $type = $this->input->post('discount_type') ?: 'percentage';
        $val  = (float)$this->input->post('discount_value');
        $min  = (float)$this->input->post('min_purchase');
        $quota = max(1, (int)$this->input->post('quota_limit'));
        $start = $this->input->post('start_date') ?: date('Y-m-d');
        $end   = $this->input->post('end_date') ?: date('Y-m-d', strtotime('+1 year'));

        if (empty($code) || $val <= 0) {
            $this->json_response(array('status' => 'error', 'message' => 'Kode promo dan nilai diskon wajib diisi.'), 400);
        }

        // Check duplicate
        $exists = $this->db->get_where('promos', array('promo_code' => $code))->row();
        if ($exists) {
            $this->json_response(array('status' => 'error', 'message' => 'Kode promo sudah terdaftar!'), 400);
        }

        $data = array(
            'promo_code'     => $code,
            'discount_type'  => $type,
            'discount_value' => $val,
            'min_purchase'   => $min,
            'quota_limit'    => $quota,
            'used_count'     => 0,
            'start_date'     => $start,
            'end_date'       => $end,
            'is_active'      => 1
        );

        $this->db->insert('promos', $data);
        $this->json_response(array('status' => 'success', 'message' => 'Kode promo ' . $code . ' berhasil ditambahkan!'));
    }

    public function toggle_status($id) {
        $this->require_role(array('Super Admin', 'Finance Staff'));

        $promo = $this->db->get_where('promos', array('id' => $id))->row();
        if (!$promo) {
            $this->json_response(array('status' => 'error', 'message' => 'Promo tidak ditemukan'), 404);
        }

        $new_status = $promo->is_active ? 0 : 1;
        $this->db->where('id', $id)->update('promos', array('is_active' => $new_status));

        $this->json_response(array(
            'status' => 'success',
            'is_active' => $new_status,
            'message' => 'Status voucher berhasil diubah!'
        ));
    }

    public function update_quota() {
        $this->require_role(array('Super Admin', 'Finance Staff'));

        $id = $this->input->post('id');
        $quota = max(1, (int)$this->input->post('quota_limit'));

        if ($id) {
            $this->db->where('id', $id)->update('promos', array('quota_limit' => $quota));
            $this->json_response(array('status' => 'success', 'message' => 'Kuota berhasil diperbarui!'));
        }
        $this->json_response(array('status' => 'error', 'message' => 'Gagal memperbarui kuota'), 400);
    }

    public function delete($id) {
        $this->require_role(array('Super Admin'));

        $this->db->where('id', $id)->delete('promos');
        $this->json_response(array('status' => 'success', 'message' => 'Kupon berhasil dihapus'));
    }
}
