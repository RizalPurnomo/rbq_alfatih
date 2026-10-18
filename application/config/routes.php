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
$route['default_controller'] = 'Profil';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Public Profile Website Routes
$route['tentang']            = 'Profil/tentang';
$route['visi-misi']          = 'Profil/visi_misi';
$route['pengajar']           = 'Profil/pengajar';
$route['pengajar/detail/(:num)'] = 'Profil/ajax_detail_pengajar/$1';
$route['pendaftaran']        = 'Profil/pendaftaran';
$route['berita']             = 'Profil/berita';
$route['berita/(:any)']      = 'Profil/detail_berita/$1';
$route['kontak']             = 'Profil/kontak';

// Authentication Routes
$route['login']              = 'Auth/login';
$route['logout']             = 'Auth/logout';

// Dashboard Route
$route['dashboard']                    = 'Dashboard/index';

// Tahun Ajaran Routes (Mapping URI underscore ke PascalCase Controller)
$route['tahun_ajaran']                 = 'TahunAjaran/index';
$route['tahun_ajaran/(:any)']          = 'TahunAjaran/$1';
$route['tahun_ajaran/(:any)/(:any)']   = 'TahunAjaran/$1/$2';

// Kelas Saya Routes (Wali Kelas)
$route['kelas_saya']                   = 'Kelas_saya/index';
$route['kelas_saya/(:any)']            = 'Kelas_saya/$1';

// Berita Admin Routes
$route['berita_admin']                 = 'Berita_admin/index';
$route['berita_admin/(:any)']          = 'Berita_admin/$1';
$route['berita_admin/(:any)/(:any)']   = 'Berita_admin/$1/$2';

// Pengajar Admin Routes
$route['pengajar_admin']               = 'Pengajar_admin/index';
$route['pengajar_admin/(:any)']        = 'Pengajar_admin/$1';
$route['pengajar_admin/(:any)/(:any)'] = 'Pengajar_admin/$1/$2';



