<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['page_title'] = 'Home';

        // 1. Fetch active hero banners from DB
        $data['hero_banners'] = $this->db->where('is_published', 1)
                                         ->order_by('sort_order', 'ASC')
                                         ->get('hero_banners')->result();
        foreach ($data['hero_banners'] as &$b) {
            $b->image_url = !empty($b->desktop_image) ? $b->desktop_image : 'uploads/banners/hero-banner-1.jpg';
            $b->subtitle = !empty($b->subheadline) ? $b->subheadline : '';
            $b->cta_text = !empty($b->cta_label) ? $b->cta_label : 'Shop Now';
            $b->cta_link = !empty($b->cta_link) ? $b->cta_link : 'brands.html';
        }

        // 2. Fetch brands for marquee bar
        $data['brands'] = $this->db->where('is_active', 1)
                                   ->order_by('display_order', 'ASC')
                                   ->get('brands')->result();

        // 3. Featured Shoes (Popular & New Releases from each main brand)
        $data['featured_products'] = $this->Product_model->get_filtered_products(array('is_published' => 1), 8, 0);

        // 4. Shop by Size Static Data (12 sizes per category as specified in document)
        $data['size_matrix_men'] = array(
            array('us' => '6.5', 'eu' => '39.5'),
            array('us' => '7',   'eu' => '40'),
            array('us' => '7.5', 'eu' => '40.5'),
            array('us' => '8',   'eu' => '41.5'),
            array('us' => '8.5', 'eu' => '42'),
            array('us' => '9',   'eu' => '42.5'),
            array('us' => '9.5', 'eu' => '43'),
            array('us' => '10',  'eu' => '44'),
            array('us' => '10.5','eu' => '44.5'),
            array('us' => '11',  'eu' => '45'),
            array('us' => '11.5','eu' => '45.5'),
            array('us' => '12',  'eu' => '46')
        );

        $data['size_matrix_women'] = array(
            array('us' => '5',   'eu' => '35'),
            array('us' => '5.5', 'eu' => '36'),
            array('us' => '6',   'eu' => '36.5'),
            array('us' => '6.5', 'eu' => '37'),
            array('us' => '7',   'eu' => '37.5'),
            array('us' => '7.5', 'eu' => '38'),
            array('us' => '8',   'eu' => '39'),
            array('us' => '8.5', 'eu' => '40'),
            array('us' => '9',   'eu' => '40.5'),
            array('us' => '9.5', 'eu' => '41'),
            array('us' => '10',  'eu' => '41.5'),
            array('us' => '11',  'eu' => '43')
        );

        $data['size_matrix_kids'] = array(
            array('us' => '1',   'eu' => '16'),
            array('us' => '1.5', 'eu' => '16.5'),
            array('us' => '2',   'eu' => '17'),
            array('us' => '2.5', 'eu' => '18'),
            array('us' => '3',   'eu' => '18.5'),
            array('us' => '4',   'eu' => '20'),
            array('us' => '5',   'eu' => '21'),
            array('us' => '6',   'eu' => '22.5'),
            array('us' => '7',   'eu' => '23.5'),
            array('us' => '8',   'eu' => '25'),
            array('us' => '9',   'eu' => '26'),
            array('us' => '10',  'eu' => '27.5')
        );

        $this->render_user_view('home_view', $data);
    }

    public function store_locator() {
        $data['page_title'] = 'Store Location';
        $city = $this->input->get('city');

        if (!empty($city)) {
            $data['stores'] = $this->db->where('city', $city)->get('store_locations')->result();
        } else {
            $data['stores'] = $this->db->get('store_locations')->result();
        }

        $data['selected_city'] = $city;
        $this->render_user_view('store_locator_view', $data);
    }
}
