<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private function _format_product(&$product) {
        if (!$product) return;
        $product->image_url = !empty($product->thumbnail) ? $product->thumbnail : base_url('assets/images/placeholder-shoe.png');
        if (!isset($product->available_sizes)) {
            if (!empty($product->skus)) {
                $sizes = array_unique(array_map(function($s) { return $s->size_eu; }, $product->skus));
                $product->available_sizes = implode(', ', $sizes);
            } else {
                $product->available_sizes = '20-46';
            }
        }
    }

    public function get_by_id($id) {
        $product = $this->db->get_where('products', array('id' => $id))->row();
        if ($product) {
            $product->skus = $this->db->get_where('product_skus', array('product_id' => $id))->result();
            $this->_format_product($product);
        }
        return $product;
    }

    public function get_by_sku($sku) {
        $product = $this->db->get_where('products', array('sku' => $sku))->row();
        if ($product) {
            $product->skus = $this->db->get_where('product_skus', array('product_id' => $product->id))->result();
            $this->_format_product($product);
        }
        return $product;
    }

    /**
     * Apply filter conditions to Active Record query
     */
    private function _apply_filters($filters = array()) {
        if (!empty($filters['brand'])) {
            if (is_array($filters['brand'])) {
                $this->db->where_in('products.brand_name', $filters['brand']);
            } else {
                $this->db->where('products.brand_name', $filters['brand']);
            }
        }

        if (!empty($filters['gender'])) {
            if (is_array($filters['gender'])) {
                $this->db->where_in('products.gender', $filters['gender']);
            } else {
                $this->db->where('products.gender', $filters['gender']);
            }
        }

        if (!empty($filters['primary_sport'])) {
            if (is_array($filters['primary_sport'])) {
                $this->db->where_in('products.primary_sport', $filters['primary_sport']);
            } else {
                $this->db->where('products.primary_sport', $filters['primary_sport']);
            }
        }

        if (!empty($filters['footwear_type'])) {
            if (is_array($filters['footwear_type'])) {
                $this->db->where_in('products.footwear_type', $filters['footwear_type']);
            } else {
                $this->db->where('products.footwear_type', $filters['footwear_type']);
            }
        }

        if (!empty($filters['color'])) {
            if (is_array($filters['color'])) {
                $this->db->where_in('products.color', $filters['color']);
            } else {
                $this->db->where('products.color', $filters['color']);
            }
        }

        if (isset($filters['min_price']) && is_numeric($filters['min_price'])) {
            $this->db->where('products.sale_price >=', (float)$filters['min_price']);
        }

        if (isset($filters['max_price']) && is_numeric($filters['max_price'])) {
            $this->db->where('products.sale_price <=', (float)$filters['max_price']);
        }

        if (isset($filters['min_discount']) && is_numeric($filters['min_discount'])) {
            $this->db->where('products.discount_percent >=', (int)$filters['min_discount']);
        }

        if (isset($filters['max_discount']) && is_numeric($filters['max_discount'])) {
            $this->db->where('products.discount_percent <=', (int)$filters['max_discount']);
        }

        if (!empty($filters['search'])) {
            $q = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('products.name', $q);
            $this->db->or_like('products.sku', $q);
            $this->db->or_like('products.brand_name', $q);
            $this->db->group_end();
        }

        // Filter by Size (EU or US)
        if (!empty($filters['size_eu']) || !empty($filters['size_us'])) {
            $this->db->join('product_skus', 'product_skus.product_id = products.id', 'inner');
            $this->db->where('product_skus.stock_qty >', 0);
            if (!empty($filters['size_eu'])) {
                if (is_array($filters['size_eu'])) {
                    $this->db->where_in('product_skus.size_eu', $filters['size_eu']);
                } else {
                    $this->db->where('product_skus.size_eu', $filters['size_eu']);
                }
            }
            if (!empty($filters['size_us'])) {
                if (is_array($filters['size_us'])) {
                    $this->db->where_in('product_skus.size_us', $filters['size_us']);
                } else {
                    $this->db->where('product_skus.size_us', $filters['size_us']);
                }
            }
            $this->db->group_by('products.id');
        }

        if (isset($filters['is_published'])) {
            $this->db->where('products.is_published', $filters['is_published']);
        }
    }

    public function get_filtered_products($filters = array(), $limit = 36, $offset = 0) {
        $this->db->select('products.*');
        $this->db->from('products');
        $this->_apply_filters($filters);

        // Sorting
        $sort = isset($filters['sort']) ? $filters['sort'] : 'relevance';
        switch ($sort) {
            case 'name_asc':
                $this->db->order_by('products.name', 'ASC');
                break;
            case 'name_desc':
                $this->db->order_by('products.name', 'DESC');
                break;
            case 'price_asc':
                $this->db->order_by('products.sale_price', 'ASC');
                break;
            case 'price_desc':
                $this->db->order_by('products.sale_price', 'DESC');
                break;
            case 'relevance':
            default:
                $this->db->order_by('products.id', 'ASC');
                break;
        }

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        $products = $this->db->get()->result();

        // Fetch sizes for each product
        if (!empty($products)) {
            $pids = array_map(function($p) { return $p->id; }, $products);
            $this->db->where_in('product_id', $pids);
            $all_skus = $this->db->get('product_skus')->result();

            $sku_map = array();
            foreach ($all_skus as $sku) {
                $sku_map[$sku->product_id][] = $sku;
            }

            foreach ($products as &$p) {
                $p->skus = isset($sku_map[$p->id]) ? $sku_map[$p->id] : array();
                $p->total_stock = array_reduce($p->skus, function($sum, $item) { return $sum + $item->stock_qty; }, 0);
                $this->_format_product($p);
            }
        } else {
            foreach ($products as &$p) {
                $this->_format_product($p);
            }
        }

        return $products;
    }

    public function count_filtered_products($filters = array()) {
        if (!empty($filters['size_eu']) || !empty($filters['size_us'])) {
            $this->db->select('COUNT(DISTINCT products.id) as total');
            $this->db->from('products');
            $this->db->join('product_skus', 'product_skus.product_id = products.id', 'inner');
            $this->db->where('product_skus.stock_qty >', 0);
            if (!empty($filters['size_eu'])) {
                if (is_array($filters['size_eu'])) {
                    $this->db->where_in('product_skus.size_eu', $filters['size_eu']);
                } else {
                    $this->db->where('product_skus.size_eu', $filters['size_eu']);
                }
            }
            if (!empty($filters['size_us'])) {
                if (is_array($filters['size_us'])) {
                    $this->db->where_in('product_skus.size_us', $filters['size_us']);
                } else {
                    $this->db->where('product_skus.size_us', $filters['size_us']);
                }
            }
            $other_filters = $filters;
            unset($other_filters['size_eu'], $other_filters['size_us']);
            $this->_apply_filters($other_filters);
            $row = $this->db->get()->row();
            return $row ? (int)$row->total : 0;
        }

        $this->db->from('products');
        $this->_apply_filters($filters);
        return $this->db->count_all_results();
    }

    public function get_total_count() {
        return $this->db->count_all('products');
    }

    public function get_low_stock_count($threshold = 5) {
        $sql = "SELECT COUNT(DISTINCT product_id) as total FROM product_skus WHERE stock_qty > 0 AND stock_qty <= ?";
        $res = $this->db->query($sql, array($threshold))->row();
        return $res ? (int)$res->total : 0;
    }

    public function get_low_stock_items($threshold = 5) {
        $sql = "SELECT p.name, p.sku, p.brand_name, ps.size_eu, ps.stock_qty 
                FROM product_skus ps 
                JOIN products p ON p.id = ps.product_id 
                WHERE ps.stock_qty > 0 AND ps.stock_qty <= ? 
                ORDER BY ps.stock_qty ASC LIMIT 10";
        return $this->db->query($sql, array($threshold))->result();
    }

    public function update_product($id, $data) {
        $this->db->where('id', $id)->update('products', $data);
        return true;
    }

    public function update_sku_stock($sku_id, $new_stock) {
        $this->db->where('id', $sku_id)->update('product_skus', array('stock_qty' => (int)$new_stock));
        return true;
    }

    public function toggle_publish($id, $status = null) {
        if ($status === null) {
            $p = $this->db->select('is_published')->get_where('products', array('id' => $id))->row();
            $status = ($p && $p->is_published == 1) ? 0 : 1;
        }
        $this->db->where('id', $id)->update('products', array('is_published' => (int)$status));
        return $status;
    }

    public function get_brands() {
        return $this->db->order_by('display_order', 'ASC')->get('brands')->result();
    }
}
