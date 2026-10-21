<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_model');
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = 'Manajemen Pesanan & Pengiriman';

        $filters = array(
            'search'         => $this->input->get('search'),
            'status'         => $this->input->get('status'),
            'payment_method' => $this->input->get('payment_method')
        );

        $page = max(1, (int)$this->input->get('p'));
        $per_page = 20;
        $offset = ($page - 1) * $per_page;

        $data['orders'] = $this->Order_model->get_orders_admin($filters, $per_page, $offset);
        $data['total_orders'] = $this->Order_model->count_orders_admin($filters);
        $data['kpi'] = $this->Order_model->get_kpis();

        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_pages'] = ceil($data['total_orders'] / $per_page);
        $data['filters'] = $filters;

        $this->render_admin_view('order_fulfillment', $data);
    }

    public function detail_json($id) {
        $order = $this->Order_model->get_by_id($id);
        if (!$order) {
            $this->json_response(array('status' => 'error', 'message' => 'Order not found'), 404);
        }
        $this->json_response(array('status' => 'success', 'data' => $order));
    }

    public function update_status() {
        $this->require_role(array('Super Admin', 'Order Operator'));

        $order_id = $this->input->post('order_id');
        $status   = $this->input->post('order_status');
        $tracking = $this->input->post('tracking_number');

        if ($this->Order_model->update_status($order_id, $status, $tracking)) {
            $this->json_response(array('status' => 'success', 'message' => 'Status pesanan berhasil diperbarui!'));
        } else {
            $this->json_response(array('status' => 'error', 'message' => 'Gagal mengubah status pesanan.'), 500);
        }
    }

    public function batch_update_status() {
        $this->require_role(array('Super Admin', 'Order Operator'));

        $order_ids = $this->input->post('order_ids');
        $status    = $this->input->post('order_status');

        if (empty($order_ids) || !is_array($order_ids) || empty($status)) {
            $this->json_response(array('status' => 'error', 'message' => 'Pilih pesanan dan tentukan status baru.'), 400);
        }

        $count = 0;
        foreach ($order_ids as $oid) {
            $oid = (int)$oid;
            if ($oid > 0) {
                if ($this->Order_model->update_status($oid, $status)) {
                    $count++;
                }
            }
        }

        $this->json_response(array(
            'status'  => 'success',
            'message' => "Berhasil memperbarui $count pesanan ke status '$status'!"
        ));
    }

    public function print_label($order_id) {
        $order = $this->Order_model->get_by_id($order_id);
        if (!$order) {
            show_404();
            return;
        }

        $data['order'] = $order;
        $this->load->view('admin/shipping_label_print', $data);
    }

    public function export_csv() {
        $this->require_role(array('Super Admin', 'Finance Staff', 'Order Operator'));

        $orders = $this->Order_model->get_orders_admin(array(), 0, 0);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Laporan_Pesanan_SportNexus_' . date('Ymd_His') . '.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, array('No Invoice', 'Waktu Transaksi', 'Nama Penerima', 'No HP', 'Alamat', 'Kota', 'Kurir', 'Metode Bayar', 'Promo Code', 'Diskon', 'Subtotal', 'Ongkir', 'Total', 'Status', 'No Resi'));

        foreach ($orders as $o) {
            fputcsv($output, array(
                $o->invoice_number,
                $o->created_at,
                $o->recipient_name,
                $o->recipient_phone,
                $o->shipping_address,
                $o->city,
                $o->shipping_courier,
                $o->payment_method,
                $o->promo_code,
                $o->discount_amount,
                $o->subtotal,
                $o->shipping_fee,
                $o->total_amount,
                $o->order_status,
                $o->tracking_number
            ));
        }
        fclose($output);
        exit;
    }
}
