<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function generate_invoice_number() {
        $year = date('Y');
        $this->db->select('id');
        $this->db->order_by('id', 'DESC');
        $last = $this->db->get('orders', 1)->row();
        $next_seq = $last ? ($last->id + 1) : 1;
        return sprintf('SN-%s-%03d', $year, $next_seq);
    }

    public function create_order($order_data, $items) {
        $this->db->trans_start();

        if (empty($order_data['invoice_number'])) {
            $order_data['invoice_number'] = $this->generate_invoice_number();
        }

        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

        foreach ($items as $item) {
            $item_insert = array(
                'order_id'     => $order_id,
                'product_id'   => $item['product_id'],
                'sku_code'     => isset($item['sku']) ? $item['sku'] : '',
                'product_name' => $item['name'],
                'brand_name'   => $item['brand_name'],
                'thumbnail'    => $item['thumbnail'],
                'size_eu'      => $item['size_eu'],
                'color'        => $item['color'],
                'unit_price'   => $item['sale_price'],
                'quantity'     => $item['qty'],
                'subtotal'     => $item['sale_price'] * $item['qty']
            );
            $this->db->insert('order_items', $item_insert);

            // Deduct physical inventory stock
            $this->db->set('stock_qty', 'GREATEST(0, stock_qty - ' . (int)$item['qty'] . ')', FALSE);
            $this->db->where('product_id', $item['product_id']);
            $this->db->where('size_eu', $item['size_eu']);
            $this->db->update('product_skus');
        }

        // Increment promo code usage if applied
        if (!empty($order_data['promo_code'])) {
            $this->db->set('used_count', 'used_count + 1', FALSE);
            $this->db->where('promo_code', $order_data['promo_code']);
            $this->db->update('promos');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return $this->get_by_id($order_id);
    }

    public function get_by_id($id) {
        $order = $this->db->get_where('orders', array('id' => $id))->row();
        if ($order) {
            $order->items = $this->db->get_where('order_items', array('order_id' => $id))->result();
        }
        return $order;
    }

    public function get_by_invoice($invoice) {
        $clean = ltrim(trim($invoice), '#');
        $this->db->group_start();
        $this->db->where('invoice_number', $clean);
        $this->db->or_where('invoice_number', '#' . $clean);
        $this->db->group_end();
        $order = $this->db->get('orders', 1)->row();
        if ($order) {
            $order->items = $this->db->get_where('order_items', array('order_id' => $order->id))->result();
        }
        return $order;
    }

    public function get_orders_admin($filters = array(), $limit = 50, $offset = 0) {
        $this->db->select('*');
        $this->db->from('orders');

        if (!empty($filters['search'])) {
            $q = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('invoice_number', $q);
            $this->db->or_like('recipient_name', $q);
            $this->db->or_like('recipient_phone', $q);
            $this->db->group_end();
        }

        if (!empty($filters['status']) && $filters['status'] !== 'Semua') {
            $this->db->where('order_status', $filters['status']);
        }

        if (!empty($filters['payment_method']) && $filters['payment_method'] !== 'Semua') {
            $this->db->like('payment_method', $filters['payment_method']);
        }

        $this->db->order_by('created_at', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        $orders = $this->db->get()->result();

        if (!empty($orders)) {
            $oids = array_map(function($o) { return $o->id; }, $orders);
            $this->db->where_in('order_id', $oids);
            $all_items = $this->db->get('order_items')->result();

            $item_map = array();
            foreach ($all_items as $item) {
                $item_map[$item->order_id][] = $item;
            }

            foreach ($orders as &$ord) {
                $ord->items = isset($item_map[$ord->id]) ? $item_map[$ord->id] : array();
            }
        }

        return $orders;
    }

    public function count_orders_admin($filters = array()) {
        $this->db->from('orders');
        if (!empty($filters['search'])) {
            $q = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('invoice_number', $q);
            $this->db->or_like('recipient_name', $q);
            $this->db->or_like('recipient_phone', $q);
            $this->db->group_end();
        }
        if (!empty($filters['status']) && $filters['status'] !== 'Semua') {
            $this->db->where('order_status', $filters['status']);
        }
        if (!empty($filters['payment_method']) && $filters['payment_method'] !== 'Semua') {
            $this->db->like('payment_method', $filters['payment_method']);
        }
        return $this->db->count_all_results();
    }

    public function update_status($order_id, $status, $tracking_number = null) {
        $order = $this->get_by_id($order_id);
        if (!$order) return false;

        $update_data = array('order_status' => $status);
        if ($tracking_number !== null) {
            $update_data['tracking_number'] = $tracking_number;
        }

        $this->db->trans_start();

        // If cancelled from a previous active status, rollback stock!
        if ($status === 'Cancelled' && $order->order_status !== 'Cancelled') {
            foreach ($order->items as $item) {
                $this->db->set('stock_qty', 'stock_qty + ' . (int)$item->quantity, FALSE);
                $this->db->where('product_id', $item->product_id);
                $this->db->where('size_eu', $item->size_eu);
                $this->db->update('product_skus');
            }
        }

        $this->db->where('id', $order_id)->update('orders', $update_data);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_kpis() {
        $total = $this->db->count_all('orders');
        $pending = $this->db->where('order_status', 'Pending')->count_all_results('orders');
        $ready = $this->db->where_in('order_status', array('Paid', 'Processing'))->count_all_results('orders');
        $completed = $this->db->where('order_status', 'Completed')->count_all_results('orders');

        return array(
            'total_orders'     => $total,
            'payment_pending'  => $pending,
            'ready_to_ship'    => $ready,
            'completed_orders' => $completed
        );
    }

    // Promos validation
    public function validate_promo($code, $subtotal) {
        $now = date('Y-m-d');
        $promo = $this->db->where('promo_code', strtoupper(trim($code)))
                          ->where('is_active', 1)
                          ->where('start_date <=', $now)
                          ->where('end_date >=', $now)
                          ->get('promos')->row();

        if (!$promo) {
            return array('status' => false, 'message' => 'Kode promo tidak valid atau sudah kedaluwarsa.');
        }

        if ($promo->used_count >= $promo->quota_limit) {
            return array('status' => false, 'message' => 'Kuota pemakaian kode promo telah habis.');
        }

        if ($subtotal < $promo->min_purchase) {
            return array('status' => false, 'message' => 'Minimal belanja Rp ' . number_format($promo->min_purchase, 0, ',', '.') . ' untuk kode promo ini.');
        }

        $discount = 0;
        if ($promo->discount_type === 'percentage') {
            $discount = ($subtotal * $promo->discount_value) / 100;
        } else {
            $discount = (float)$promo->discount_value;
        }

        return array(
            'status'   => true,
            'code'     => $promo->promo_code,
            'discount' => $discount,
            'promo'    => $promo
        );
    }
}
