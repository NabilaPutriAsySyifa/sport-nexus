<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = 'Master Footwear Inventory';

        // 1. Collect Filter Parameters
        $filters = array(
            'brand'        => $this->input->get('brand'),
            'gender'       => $this->input->get('gender'),
            'search'       => $this->input->get('search'),
            'min_discount' => $this->input->get('min_discount'),
            'sort'         => $this->input->get('sort') ?: 'relevance'
        );

        // Filter stock status
        $status = $this->input->get('status');
        if ($status === 'menipis') {
            // will filter in view or custom query
        }

        $page = max(1, (int)$this->input->get('p'));
        $per_page = 25;
        $offset = ($page - 1) * $per_page;

        $data['total_products'] = $this->Product_model->count_filtered_products($filters);
        $data['products'] = $this->Product_model->get_filtered_products($filters, $per_page, $offset);

        // 2. 8 KPI Cards Metrics
        $data['kpi_total'] = $this->Product_model->get_total_count();
        $data['kpi_diadora'] = $this->Product_model->count_filtered_products(array('brand' => array('Diadora')));
        $data['kpi_airwalk'] = $this->Product_model->count_filtered_products(array('brand' => array('Airwalk')));
        $data['kpi_nb'] = $this->Product_model->count_filtered_products(array('brand' => array('New Balance')));
        $data['kpi_converse'] = $this->Product_model->count_filtered_products(array('brand' => array('Converse', 'Converse Kids')));
        $data['kpi_nike'] = $this->Product_model->count_filtered_products(array('brand' => array('Nike', 'Nike Young Athletes', 'Nike Golf')));
        $data['kpi_puma'] = $this->Product_model->count_filtered_products(array('brand' => array('Puma', 'Puma Golf')));
        $data['kpi_low_stock'] = $this->Product_model->get_low_stock_count(5);

        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        $data['total_pages'] = ceil($data['total_products'] / $per_page);
        $data['filters'] = $filters;

        $this->render_admin_view('inventory_table', $data);
    }

    public function update_stock() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));

        $sku_id = $this->input->post('sku_id');
        $new_stock = max(0, (int)$this->input->post('stock_qty'));

        if (empty($sku_id)) {
            $this->json_response(array('status' => 'error', 'message' => 'SKU ID is required'), 400);
        }

        $this->Product_model->update_sku_stock($sku_id, $new_stock);
        $this->json_response(array(
            'status'    => 'success',
            'message'   => 'Stok fisik berhasil diperbarui!',
            'new_stock' => $new_stock
        ));
    }

    public function toggle_status($product_id) {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));
        $new_status = $this->Product_model->toggle_publish($product_id);
        $this->json_response(array('status' => 'success', 'is_published' => $new_status));
    }

    public function get_product_json($id) {
        $product = $this->Product_model->get_by_id($id);
        if (!$product) {
            $this->json_response(array('status' => 'error', 'message' => 'Product not found'), 404);
        }
        $this->json_response(array('status' => 'success', 'data' => $product));
    }

    public function save_product() {
        $this->require_role(array('Super Admin', 'Stock & Catalog Manager'));

        $id = $this->input->post('product_id');
        $orig_price = (float)$this->input->post('original_price');
        $discount = (int)$this->input->post('discount_percent');
        $sale_price = $discount > 0 ? round($orig_price * (1 - $discount / 100)) : $orig_price;

        $product_data = array(
            'name'             => $this->input->post('name'),
            'brand_name'       => $this->input->post('brand_name'),
            'gender'           => $this->input->post('gender'),
            'primary_sport'    => $this->input->post('primary_sport'),
            'footwear_type'    => $this->input->post('footwear_type'),
            'color'            => $this->input->post('color'),
            'original_price'   => $orig_price,
            'discount_percent' => $discount,
            'sale_price'       => $sale_price,
            'thumbnail'        => $this->input->post('thumbnail')
        );

        if ($id) {
            $this->Product_model->update_product($id, $product_data);

            // Update size matrix if provided
            $sizes = $this->input->post('sizes');
            if (!empty($sizes) && is_array($sizes)) {
                foreach ($sizes as $sku_id => $qty) {
                    $this->Product_model->update_sku_stock($sku_id, $qty);
                }
            }

            $this->json_response(array('status' => 'success', 'message' => 'Data sepatu berhasil disimpan!'));
        } else {
            // New product insertion
            $product_data['sku'] = 'SN-' . strtoupper(substr(md5(uniqid()), 0, 8));
            $product_data['is_published'] = 1;
            $this->db->insert('products', $product_data);
            $new_id = $this->db->insert_id();

            // Default sizes EUR 39-44
            $default_sizes = array('39', '40', '41', '42', '43', '44');
            foreach ($default_sizes as $sz) {
                $this->db->insert('product_skus', array(
                    'product_id' => $new_id,
                    'sku_code'   => $product_data['sku'] . '-EU' . $sz,
                    'size_eu'    => $sz,
                    'stock_qty'  => 5
                ));
            }

            $this->json_response(array('status' => 'success', 'message' => 'Sepatu baru berhasil ditambahkan!'));
        }
    }
}
