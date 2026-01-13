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
$route['user/home'] = 'user/Beranda/index'; // Alias untuk user/home
$route['pencarian'] = 'user/Pencarian/index';
$route['cari'] = 'user/Pencarian/index';
$route['api/tbs_prices'] = 'user/Api/harga_tbs';
$route['api/search'] = 'user/Api/cari';
$route['api/get_dosis'] = 'user/Api/get_dosis';
$route['kalkulator-pupuk'] = 'user/Pupuk/index';
$route['kalkulator-panen'] = 'user/Panen/index';
$route['panen/save'] = 'user/Panen/simpan';
$route['panen/get_perusahaan'] = 'user/Panen/get_perusahaan_by_kabupaten';
$route['panen/get_harga_tbs'] = 'user/Panen/get_harga_tbs';
$route['pupuk/save_dosis'] = 'user/Pupuk/simpan_dosis';
$route['riwayat'] = 'user/Riwayat/index';
$route['riwayat/hapus_panen/(:num)'] = 'user/Riwayat/hapus_panen/$1';
$route['riwayat/hapus_pupuk/(:num)'] = 'user/Riwayat/hapus_pupuk/$1';
$route['jenis-pupuk'] = 'user/Pupuk/daftar_jenis';
$route['pupuk/list'] = 'user/Pupuk/daftar_jenis';
$route['pupuk/detail/(:num)'] = 'user/Pupuk/detail_pupuk/$1';
$route['pupuk/detail/(:any)'] = 'user/Pupuk/detail_pupuk/$1';
$route['penyakit'] = 'user/Penyakit/index';
$route['penyakit/detail/(:num)'] = 'user/Penyakit/detail_penyakit/$1';
$route['penyakit/detail/(:any)'] = 'user/Penyakit/detail_penyakit/$1';
$route['informasi'] = 'user/Informasi/index';
$route['informasi/detail/(:any)'] = 'user/Informasi/detail_informasi/$1';
$route['informasi/(:num)'] = 'user/Informasi/index';
$route['profil'] = 'user/Profil/index';

$route['perusahaan/tentang-kami'] = 'user/Profil_perusahaan/tentang_kami';
$route['perusahaan/visi-misi'] = 'user/Profil_perusahaan/visi_misi';
$route['perusahaan/mitra-kerjasama'] = 'user/Profil_perusahaan/mitra_kerjasama';
$route['perusahaan/program'] = 'user/Profil_perusahaan/program';

$route['bantuan/pusat-bantuan'] = 'user/Bantuan/pusat_bantuan';
$route['bantuan/faq'] = 'user/Bantuan/faq';
$route['bantuan/syarat-ketentuan'] = 'user/Bantuan/syarat_ketentuan';
$route['bantuan/kebijakan-privasi'] = 'user/Bantuan/kebijakan_privasi';
$route['bantuan/hubungi-kami'] = 'user/Bantuan/hubungi_kami';

$route['masuk'] = 'Auth/login';
$route['login'] = 'Auth/login';
$route['auth/login'] = 'Auth/login';
$route['auth/masuk'] = 'Auth/login';
$route['keluar'] = 'Auth/logout';
$route['logout'] = 'Auth/logout';
$route['auth/logout'] = 'Auth/logout';
$route['auth/keluar'] = 'Auth/logout';
$route['daftar'] = 'Auth/register';
$route['register'] = 'Auth/register';


$route['admin'] = 'admin/Admin_dashboard/index';

$route['admin/login'] = 'Auth/login';
$route['admin/logout'] = 'Auth/logout';
$route['admin/dashboard'] = 'admin/Admin_dashboard/index';
$route['admin/harga_tbs'] = 'admin/Admin_harga_tbs/index';
$route['admin/harga_tbs/tambah'] = 'admin/Admin_harga_tbs/tambah_harga_tbs';
$route['admin/harga_tbs/ubah/(:num)'] = 'admin/Admin_harga_tbs/ubah_harga_tbs/$1';
$route['admin/harga_tbs/hapus/(:num)'] = 'admin/Admin_harga_tbs/hapus_harga_tbs/$1';
$route['admin/harga_tbs/get_perusahaan'] = 'admin/Admin_harga_tbs/get_perusahaan_by_kabupaten';
$route['admin/perusahaan'] = 'admin/Admin_perusahaan/index';
$route['admin/perusahaan/tambah'] = 'admin/Admin_perusahaan/tambah_perusahaan';
$route['admin/perusahaan/ubah/(:num)'] = 'admin/Admin_perusahaan/ubah_perusahaan/$1';
$route['admin/perusahaan/hapus/(:num)'] = 'admin/Admin_perusahaan/hapus_perusahaan/$1';
$route['admin/kabupaten'] = 'admin/Admin_kabupaten/index';
$route['admin/kabupaten/tambah'] = 'admin/Admin_kabupaten/tambah_kabupaten';
$route['admin/kabupaten/ubah/(:num)'] = 'admin/Admin_kabupaten/ubah_kabupaten/$1';
$route['admin/kabupaten/hapus/(:num)'] = 'admin/Admin_kabupaten/hapus_kabupaten/$1';
$route['admin/kalkulator_panen'] = 'admin/Admin_kalkulator_panen/index';
$route['admin/kalkulator_pupuk'] = 'admin/Admin_kalkulator_pupuk/index';
$route['admin/pupuk'] = 'admin/Admin_pupuk/index';
$route['admin/pupuk/tambah'] = 'admin/Admin_pupuk/tambah_pupuk';
$route['admin/pupuk/ubah/(:num)'] = 'admin/Admin_pupuk/ubah_pupuk/$1';
$route['admin/pupuk/hapus/(:num)'] = 'admin/Admin_pupuk/hapus_pupuk/$1';
$route['admin/tanah'] = 'admin/Admin_tanah/index';
$route['admin/tanah/tambah'] = 'admin/Admin_tanah/tambah_tanah';
$route['admin/tanah/ubah/(:num)'] = 'admin/Admin_tanah/ubah_tanah/$1';
$route['admin/tanah/hapus/(:num)'] = 'admin/Admin_tanah/hapus_tanah/$1';
$route['admin/penyakit'] = 'admin/Admin_penyakit/index';
$route['admin/penyakit/tambah'] = 'admin/Admin_penyakit/tambah_penyakit';
$route['admin/penyakit/ubah/(:num)'] = 'admin/Admin_penyakit/ubah_penyakit/$1';
$route['admin/penyakit/hapus/(:num)'] = 'admin/Admin_penyakit/hapus_penyakit/$1';
$route['admin/informasi'] = 'admin/Admin_informasi/index';
$route['admin/informasi/tambah'] = 'admin/Admin_informasi/tambah_informasi';
$route['admin/informasi/ubah/(:num)'] = 'admin/Admin_informasi/ubah_informasi/$1';
$route['admin/informasi/hapus/(:num)'] = 'admin/Admin_informasi/hapus_informasi/$1';
$route['admin/users'] = 'admin/Admin_users/index';
$route['admin/users/delete/(:num)'] = 'admin/Admin_users/delete/$1';
$route['admin/profile'] = 'admin/Admin_profile/index';
$route['admin/settings'] = 'admin/Admin_settings/index';

// Allow direct access to assets (CSS, JS, images)
$route['assets/(:any)'] = '';

$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
