<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cart_model');
        $this->load->model('Order_model');
        $this->load->model('User_model');
    }

    public function index() {
        $data['page_title'] = 'Checkout';

        // 1. Mandatory Login Check: Customer MUST be logged in and registered to purchase/pay
        if (!$this->session->userdata('user_logged_in')) {
            $this->session->set_flashdata('auth_notice', 'Untuk alasan keamanan transaksi & pencatatan pesanan resmi, Anda wajib masuk ke akun Sport Nexus atau mendaftar akun baru terlebih dahulu.');
            $this->session->set_userdata('redirect_after_login', 'checkout.html');
            redirect('signin.html?redirect=checkout.html');
            return;
        }

        $cart = $this->Cart_model->get_selected_cart();

        // If no items selected to checkout, redirect to cart page
        if (empty($cart['items'])) {
            redirect('cart.html');
            return;
        }

        $data['cart'] = $cart;

        // Fetch user addresses for logged in user
        $user_id = $this->session->userdata('user_id');
        $data['addresses'] = $user_id ? $this->User_model->get_user_addresses($user_id) : array();

        $this->render_user_view('checkout_view', $data);
    }

    public function apply_promo() {
        $code = $this->input->post('promo_code');
        $subtotal = (float)$this->input->post('subtotal');

        if (empty($code)) {
            $this->json_response(array('status' => 'error', 'message' => 'Masukkan kode promo.'), 400);
        }

        $res = $this->Order_model->validate_promo($code, $subtotal);
        if ($res['status']) {
            $this->json_response(array(
                'status'   => 'success',
                'message'  => 'Kode promo berhasil digunakan!',
                'code'     => $res['code'],
                'discount' => $res['discount']
            ));
        } else {
            $this->json_response(array('status' => 'error', 'message' => $res['message']), 400);
        }
    }

    public function add_address() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            $this->json_response(array('status' => 'error', 'message' => 'Silakan sign in untuk menyimpan alamat.'), 401);
        }

        $data = array(
            'recipient_name' => $this->input->post('recipient_name'),
            'phone_number'   => $this->input->post('phone_number'),
            'full_address'   => $this->input->post('full_address'),
            'province'       => $this->input->post('province') ?: 'Jawa Barat',
            'city'           => $this->input->post('city') ?: 'Kota Bekasi',
            'district'       => $this->input->post('district') ?: 'Bekasi Selatan',
            'postal_code'    => $this->input->post('postal_code') ?: '17148',
            'is_primary'     => $this->input->post('is_primary') ? 1 : 0
        );

        $addr_id = $this->User_model->add_address($user_id, $data);
        $addresses = $this->User_model->get_user_addresses($user_id);

        $this->json_response(array(
            'status'    => 'success',
            'message'   => 'Alamat berhasil ditambahkan!',
            'addresses' => $addresses,
            'new_id'    => $addr_id
        ));
    }

    public function update_address() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            $this->json_response(array('status' => 'error', 'message' => 'Silakan sign in untuk mengedit alamat.'), 401);
        }

        $address_id = (int)$this->input->post('address_id');
        if (!$address_id) {
            $this->json_response(array('status' => 'error', 'message' => 'ID alamat tidak valid.'), 400);
        }

        $data = array(
            'recipient_name' => $this->input->post('recipient_name'),
            'phone_number'   => $this->input->post('phone_number'),
            'full_address'   => $this->input->post('full_address'),
            'province'       => $this->input->post('province') ?: 'Jawa Barat',
            'city'           => $this->input->post('city'),
            'district'       => $this->input->post('district'),
            'postal_code'    => $this->input->post('postal_code'),
            'is_primary'     => $this->input->post('is_primary') ? 1 : 0
        );

        $this->User_model->update_address($address_id, $user_id, $data);
        $addresses = $this->User_model->get_user_addresses($user_id);

        $this->json_response(array(
            'status'     => 'success',
            'message'    => 'Alamat berhasil diperbarui!',
            'addresses'  => $addresses,
            'updated_id' => $address_id
        ));
    }

    public function delete_address() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            $this->json_response(array('status' => 'error', 'message' => 'Silakan sign in untuk menghapus alamat.'), 401);
        }

        $address_id = (int)$this->input->post('address_id');
        if (!$address_id) {
            $this->json_response(array('status' => 'error', 'message' => 'ID alamat tidak valid.'), 400);
        }

        $this->User_model->delete_address($address_id, $user_id);
        $addresses = $this->User_model->get_user_addresses($user_id);

        $this->json_response(array(
            'status'    => 'success',
            'message'   => 'Alamat berhasil dihapus!',
            'addresses' => $addresses
        ));
    }

    public function process() {
        $cart = $this->Cart_model->get_selected_cart();
        if (empty($cart['items'])) {
            $this->json_response(array('status' => 'error', 'message' => 'Tidak ada produk yang dipilih untuk checkout.'), 400);
        }

        // Enforce mandatory user authentication for completing purchase & payment
        $user_id = $this->session->userdata('user_id');
        if (!$this->session->userdata('user_logged_in') || !$user_id) {
            $this->json_response(array(
                'status'   => 'error',
                'message'  => 'Anda wajib memiliki akun terdaftar dan masuk terlebih dahulu untuk menyelesaikan pembayaran.',
                'redirect' => base_url('signin.html?redirect=checkout.html')
            ), 401);
            return;
        }

        $recipient_name = $this->input->post('recipient_name');
        $recipient_phone = $this->input->post('recipient_phone');
        $shipping_address = $this->input->post('shipping_address');
        $city = $this->input->post('city') ?: 'Kota Bekasi';
        $postal_code = $this->input->post('postal_code') ?: '17148';
        $shipping_courier = $this->input->post('shipping_courier') ?: 'Regular Courier';
        $payment_method = $this->input->post('payment_method') ?: 'QRIS';
        $promo_code = $this->input->post('promo_code');

        // Calculate final amounts
        $subtotal = $cart['total'];
        $shipping_fee = 0; // Free Shipping default promo
        if ($shipping_courier === 'Express (1 Hari)') {
            $shipping_fee = 25000;
        }

        $discount_amount = 0;
        if (!empty($promo_code)) {
            $promo_check = $this->Order_model->validate_promo($promo_code, $subtotal);
            if ($promo_check['status']) {
                $discount_amount = $promo_check['discount'];
            }
        }

        $total_amount = max(0, $subtotal + $shipping_fee - $discount_amount);

        $order_data = array(
            'invoice_number'          => $this->Order_model->generate_invoice_number(),
            'user_id'                 => $user_id ?: null,
            'recipient_name'          => $recipient_name,
            'recipient_phone'         => $recipient_phone,
            'shipping_address'        => $shipping_address,
            'city'                    => $city,
            'district'                => $this->input->post('district') ?: '',
            'postal_code'             => $postal_code,
            'shipping_courier'        => $shipping_courier,
            'payment_method'          => $payment_method,
            'billing_same_as_shipping'=> $this->input->post('billing_same_as_shipping') ? 1 : 0,
            'promo_code'              => $promo_code ?: null,
            'discount_amount'         => $discount_amount,
            'subtotal'                => $subtotal,
            'shipping_fee'            => $shipping_fee,
            'total_amount'            => $total_amount,
            'order_status'            => 'Paid', // Digital simulation instant settlement
            'tracking_number'         => 'NEXUS-' . strtoupper(substr(md5(time()), 0, 10))
        );

        $order = $this->Order_model->create_order($order_data, $cart['items']);

        if ($order) {
            // Remove only checked-out items; unselected items remain in cart
            $this->Cart_model->remove_selected_items();

            $clean_invoice = ltrim($order->invoice_number, '#');
            $this->session->set_userdata('last_invoice_number', $clean_invoice);

            $this->json_response(array(
                'status'         => 'success',
                'invoice_number' => $order->invoice_number,
                'redirect_url'   => base_url('invoice/' . $clean_invoice)
            ));
        } else {
            $this->json_response(array('status' => 'error', 'message' => 'Gagal memproses transaksi.'), 500);
        }
    }

    public function invoice($invoice_number = '') {
        $invoice_number = trim($invoice_number);
        if (empty($invoice_number)) {
            $invoice_number = $this->session->userdata('last_invoice_number');
        }

        if (empty($invoice_number)) {
            $user_id = $this->session->userdata('user_id');
            if ($user_id) {
                $latest = $this->db->where('user_id', $user_id)->order_by('id', 'DESC')->get('orders', 1)->row();
                if ($latest) {
                    $invoice_number = $latest->invoice_number;
                }
            } else {
                $latest = $this->db->order_by('id', 'DESC')->get('orders', 1)->row();
                if ($latest) {
                    $invoice_number = $latest->invoice_number;
                }
            }
        }

        $order = $this->Order_model->get_by_invoice($invoice_number);
        if (!$order) {
            show_404();
            return;
        }

        $data['order'] = $order;
        $data['page_title'] = 'Invoice #' . ltrim($order->invoice_number, '#');
        $this->render_user_view('invoice_view', $data);
    }
}
