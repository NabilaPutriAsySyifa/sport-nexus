<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Order_model');
    }

    public function index() {
        $data['page_title'] = 'Dashboard Analitik';

        // 1. KPI Metrics
        $data['total_products'] = $this->Product_model->get_total_count();
        $data['low_stock_count'] = $this->Product_model->get_low_stock_count(5);
        $data['order_kpis'] = $this->Order_model->get_kpis();

        // 2. Recent Orders
        $data['recent_orders'] = $this->Order_model->get_orders_admin(array(), 5, 0);

        // 3. Brand distribution breakdown
        $data['brand_stats'] = $this->db->query("SELECT brand_name, COUNT(*) as count FROM products GROUP BY brand_name ORDER BY count DESC")->result();

        // 4. Low stock items list
        $data['low_stock_items'] = $this->Product_model->get_low_stock_items(5);

        $this->render_admin_view('dashboard_view', $data);
    }

    public function banners() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));
        $data['page_title'] = 'Hero Banner Slider Manager';
        $data['banners'] = $this->db->order_by('sort_order', 'ASC')->get('hero_banners')->result();
        $this->render_admin_view('banner_manager', $data);
    }

    public function save_banner() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));
        $id = $this->input->post('id');
        $data = array(
            'title'         => $this->input->post('title'),
            'headline'      => $this->input->post('headline'),
            'subheadline'   => $this->input->post('subheadline'),
            'desktop_image' => $this->input->post('desktop_image') ?: 'uploads/banners/hero-banner-1.jpg',
            'mobile_image'  => $this->input->post('mobile_image') ?: 'uploads/banners/hero-banner-1-mobile.jpg',
            'cta_label'     => $this->input->post('cta_label') ?: 'Beli Sekarang',
            'cta_link'      => $this->input->post('cta_link') ?: 'brands.html',
            'target_brand'  => $this->input->post('target_brand') ?: 'All',
            'sort_order'    => max(1, (int)$this->input->post('sort_order')),
            'is_published'  => $this->input->post('is_published') ? 1 : 0,
            'start_date'    => $this->input->post('start_date') ?: null,
            'end_date'      => $this->input->post('end_date') ?: null
        );

        if ($id) {
            $this->db->where('id', $id)->update('hero_banners', $data);
            $this->json_response(array('status' => 'success', 'message' => 'Banner berhasil diperbarui!'));
        } else {
            $this->db->insert('hero_banners', $data);
            $this->json_response(array('status' => 'success', 'message' => 'Banner baru berhasil ditambahkan!'));
        }
    }

    public function delete_banner($id) {
        $this->require_role(array('Super Admin'));
        $this->db->where('id', $id)->delete('hero_banners');
        $this->json_response(array('status' => 'success', 'message' => 'Banner berhasil dihapus!'));
    }

    public function brands() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));
        $data['page_title'] = 'Brand Showcase Manager';
        $data['brands'] = $this->db->order_by('display_order', 'ASC')->get('brands')->result();
        $this->render_admin_view('brand_manager', $data);
    }

    public function save_brand() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));
        $id = $this->input->post('id');
        $sub_brands = $this->input->post('sub_brands');
        $data = array(
            'name'            => $this->input->post('name'),
            'slug'            => $this->input->post('slug'),
            'total_quota'     => (int)$this->input->post('total_quota'),
            'display_order'   => (int)$this->input->post('display_order'),
            'show_in_marquee' => $this->input->post('show_in_marquee') ? 1 : 0,
            'is_active'       => $this->input->post('is_active') ? 1 : 0
        );
        if ($sub_brands) {
            $data['sub_brands'] = is_array($sub_brands) ? json_encode(array_values($sub_brands)) : $sub_brands;
        }

        if ($id) {
            $this->db->where('id', $id)->update('brands', $data);
            $this->json_response(array('status' => 'success', 'message' => 'Brand berhasil diperbarui!'));
        } else {
            $this->db->insert('brands', $data);
            $this->json_response(array('status' => 'success', 'message' => 'Brand berhasil ditambahkan!'));
        }
    }

    public function toggle_brand($id) {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));
        $b = $this->db->get_where('brands', array('id' => $id))->row();
        if ($b) {
            $new_status = $b->show_in_marquee ? 0 : 1;
            $this->db->where('id', $id)->update('brands', array('show_in_marquee' => $new_status));
            $this->json_response(array('status' => 'success', 'show_in_marquee' => $new_status));
        }
        $this->json_response(array('status' => 'error'), 404);
    }

    public function size_matrix() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));
        $data['page_title'] = 'Shop by Size Navigation Matrix';
        $this->render_admin_view('size_matrix_settings', $data);
    }

    public function toggle_banner($id) {
        $b = $this->db->get_where('hero_banners', array('id' => $id))->row();
        if ($b) {
            $new_status = $b->is_published ? 0 : 1;
            $this->db->where('id', $id)->update('hero_banners', array('is_published' => $new_status));
            $this->json_response(array('status' => 'success', 'is_published' => $new_status));
        }
        $this->json_response(array('status' => 'error'), 404);
    }

    public function customers() {
        $this->require_role(array('Super Admin', 'Order Operator'));
        $data['page_title'] = 'Data Pelanggan Terdaftar';
        $customers = $this->db->order_by('created_at', 'DESC')->get('users')->result();
        foreach ($customers as &$c) {
            $c->order_count = $this->db->where('user_id', $c->id)->count_all_results('orders');
            $c->addresses = $this->db->where('user_id', $c->id)->get('user_addresses')->result();
        }
        $data['customers'] = $customers;
        $this->render_admin_view('customers_view', $data);
    }

    public function reports() {
        $this->require_role(array('Super Admin', 'Order Operator'));
        $data['page_title'] = 'Laporan & Audit Operasional';
        $data['order_kpis'] = $this->Order_model->get_kpis();
        $data['total_revenue'] = (float)$this->db->select_sum('total_amount')->where('order_status !=', 'Cancelled')->get('orders')->row()->total_amount;
        $data['city_stats'] = $this->db->query("SELECT city, COUNT(*) as orders_count, SUM(total_amount) as revenue FROM orders GROUP BY city")->result();
        $data['brand_stock'] = $this->db->query("SELECT brand_name, COUNT(*) as models_count FROM products GROUP BY brand_name ORDER BY models_count DESC")->result();
        $this->render_admin_view('reports_view', $data);
    }
}
