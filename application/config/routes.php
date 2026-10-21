<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Customer Catalog and Information Pages (.html mapping)
$route['\*\.html']                = 'Brands/index';
$route['catalog\.html']          = 'Brands/index';
$route['all\.html']              = 'Brands/index';
$route['products\.html']         = 'Brands/index';
$route['brands\.html']           = 'Brands/index';
$route['brands/(.+)']            = 'Brands/brand/$1';
$route['sports\.html']           = 'Sports/index';
$route['men\.html']              = 'Men/index';
$route['women\.html']            = 'Women/index';
$route['kids\.html']             = 'Kids/index';
$route['sale\.html']             = 'Brands/sale';
$route['store-location\.html']   = 'Home/store_locator';
$route['store-location']         = 'Home/store_locator';

// Product Detail Page (PDP)
$route['product/(:any)']         = 'Product/detail/$1';

// Shopping Cart & Multi-Step Checkout
$route['cart\.html']             = 'Cart/index';
$route['checkout\.html']         = 'Checkout/index';
$route['invoice']                 = 'Checkout/invoice';
$route['invoice/(.+)']            = 'Checkout/invoice/$1';
$route['invoice/(:any)']         = 'Checkout/invoice/$1';

// Authentication
$route['signin\.html']           = 'Auth/signin';
$route['signup\.html']           = 'Auth/signup';
$route['signout']                = 'Auth/signout';

// Isolated Admin Portal (/admin/*)
$route['admin']                  = 'admin/Dashboard/index';
$route['admin/signin']           = 'admin/Auth/signin';
$route['admin/signup']           = 'admin/Auth/signup';
$route['admin/signout']          = 'admin/Auth/signout';
$route['admin/dashboard']        = 'admin/Dashboard/index';
$route['admin/inventory']        = 'admin/Inventory/index';
$route['admin/sports']           = 'admin/Sports/index';
$route['admin/men']              = 'admin/Men/index';
$route['admin/women']            = 'admin/Women/index';
$route['admin/kids']             = 'admin/Kids/index';
$route['admin/orders']           = 'admin/Orders/index';
$route['admin/orders/detail/(:any)'] = 'admin/Orders/detail_json/$1';
$route['admin/orders/update-status'] = 'admin/Orders/update_status';
$route['admin/orders/batch-update']  = 'admin/Orders/batch_update_status';
$route['admin/orders/export-csv']    = 'admin/Orders/export_csv';
$route['admin/promos']           = 'admin/Promos/index';
$route['admin/banners']          = 'admin/Dashboard/banners';
$route['admin/banners/save']     = 'admin/Dashboard/save_banner';
$route['admin/banners/delete/(:any)'] = 'admin/Dashboard/delete_banner/$1';
$route['admin/brands']           = 'admin/Dashboard/brands';
$route['admin/brands/save']      = 'admin/Dashboard/save_brand';
$route['admin/brands/toggle/(:any)']  = 'admin/Dashboard/toggle_brand/$1';
$route['admin/size-matrix']      = 'admin/Dashboard/size_matrix';
$route['admin/customers']        = 'admin/Dashboard/customers';
$route['admin/reports']          = 'admin/Dashboard/reports';
$route['admin/shipping-label/(:any)'] = 'admin/Orders/print_label/$1';
