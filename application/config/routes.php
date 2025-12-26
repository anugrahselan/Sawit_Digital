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
// User/Public Routes
$route['default_controller'] = 'Home';
$route['beranda'] = 'user/Beranda/index';
$route['dashboard'] = 'user/Beranda/index';
$route['pencarian'] = 'user/Pencarian/index';
$route['cari'] = 'user/Pencarian/index';
$route['api/tbs_prices'] = 'user/Api/tbs_prices';
$route['api/search'] = 'user/Api/search';
$route['api/get_dosis'] = 'user/Api/get_dosis';
$route['kalkulator-pupuk'] = 'user/Pupuk/index';
$route['kalkulator-panen'] = 'user/Panen/index';
$route['panen/save'] = 'user/Panen/save';
$route['pupuk/save_dosis'] = 'user/Pupuk/save_dosis';
$route['jenis-pupuk'] = 'user/Pupuk/list';
$route['penyakit'] = 'user/Penyakit/index';
$route['informasi'] = 'user/Informasi/index';
$route['informasi/(:any)'] = 'user/Informasi/detail/$1';
$route['masuk'] = 'user/Autentikasi/login';
$route['login'] = 'user/Autentikasi/login';
$route['daftar'] = 'user/Autentikasi/register';
$route['register'] = 'user/Autentikasi/register';
$route['keluar'] = 'user/Autentikasi/logout';
$route['logout'] = 'user/Autentikasi/logout';

// Admin Routes
$route['admin'] = 'admin/Admin_dashboard/index';
$route['admin/login'] = 'admin/Admin_auth/login';
$route['admin/logout'] = 'admin/Admin_auth/logout';
$route['admin/dashboard'] = 'admin/Admin_dashboard/index';
$route['admin/harga_tbs'] = 'admin/Admin_harga_tbs/index';
$route['admin/harga_tbs/create'] = 'admin/Admin_harga_tbs/create';
$route['admin/harga_tbs/update/(:num)'] = 'admin/Admin_harga_tbs/update/$1';
$route['admin/harga_tbs/delete/(:num)'] = 'admin/Admin_harga_tbs/delete/$1';
$route['admin/harga_tbs/get_perusahaan'] = 'admin/Admin_harga_tbs/get_perusahaan_by_kabupaten';
$route['admin/perusahaan'] = 'admin/Admin_perusahaan/index';
$route['admin/perusahaan/create'] = 'admin/Admin_perusahaan/create';
$route['admin/perusahaan/update/(:num)'] = 'admin/Admin_perusahaan/update/$1';
$route['admin/perusahaan/delete/(:num)'] = 'admin/Admin_perusahaan/delete/$1';
$route['admin/kabupaten'] = 'admin/Admin_kabupaten/index';
$route['admin/kabupaten/create'] = 'admin/Admin_kabupaten/create';
$route['admin/kabupaten/update/(:num)'] = 'admin/Admin_kabupaten/update/$1';
$route['admin/kabupaten/delete/(:num)'] = 'admin/Admin_kabupaten/delete/$1';
$route['admin/kalkulator_panen'] = 'admin/Admin_kalkulator_panen/index';
$route['admin/pupuk'] = 'admin/Admin_pupuk/index';
$route['admin/pupuk/create'] = 'admin/Admin_pupuk/create';
$route['admin/pupuk/update/(:num)'] = 'admin/Admin_pupuk/update/$1';
$route['admin/pupuk/delete/(:num)'] = 'admin/Admin_pupuk/delete/$1';
$route['admin/tanah'] = 'admin/Admin_tanah/index';
$route['admin/penyakit'] = 'admin/Admin_penyakit/index';
$route['admin/penyakit/create'] = 'admin/Admin_penyakit/create';
$route['admin/penyakit/update/(:num)'] = 'admin/Admin_penyakit/update/$1';
$route['admin/penyakit/delete/(:num)'] = 'admin/Admin_penyakit/delete/$1';
$route['admin/informasi'] = 'admin/Admin_informasi/index';
$route['admin/informasi/create'] = 'admin/Admin_informasi/create';
$route['admin/informasi/update/(:num)'] = 'admin/Admin_informasi/update/$1';
$route['admin/informasi/delete/(:num)'] = 'admin/Admin_informasi/delete/$1';
$route['admin/users'] = 'admin/Admin_users/index';
$route['admin/settings'] = 'admin/Admin_settings/index';

$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
