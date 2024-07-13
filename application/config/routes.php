<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "user";
$route['404_override'] = 'error';
$route['translate_uri_dashes'] = '';



/*********** USER DEFINED ROUTES *******************/


/*********** Login/Regis/Diskusi pengguna *******************/
$route['regispengguna'] = 'login/regispengguna';
$route['loginpengguna'] = 'login/loginpengguna';
$route['viewpenggunaLogin'] = 'login/viewpenggunaLogin';
$route['logoutpengguna'] = 'login/logoutpengguna';
$route['dashboardAlum'] = 'pengguna';
$route['profilepengguna'] = 'pengguna/profilepengguna';
$route['editProfile'] = 'pengguna/editProfile';
$route['ChangePasswordpengguna'] = 'pengguna/ChangePasswordpengguna';
$route['datapengguna'] = 'pengguna/datapengguna';
$route['DataUpload'] = 'pengguna/DataUpload';

// Proses Upload
$route['work'] = 'user/work';
$route['upload_work'] = "user/upload_work";
$route['deletework/(:any)'] = 'user/deletework/$1';

/*********** END *******************/


// /*********** Control Pengguna  *******************/
$route['pengguna'] = 'user/pengguna';
$route['tambah_pengguna'] = "user/tambah_pengguna";
$route['import_excel'] = "user/import_excel";
$route['cetak_pdf'] = "user/cetakpdf";
$route['cetak_upload'] = "pengguna/cetak_upload";
$route['newpengguna'] = "user/newpengguna";
$route['deletepengguna/(:any)'] = "user/deletepengguna/$1";
$route['updateStatuspengguna'] = "user/updateStatuspengguna";
$route['prosesupdate'] = 'user/prosesupdate';

/*********** END *******************/


$route['login'] = 'login';
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNewUser'] = "user/addNewUser";
$route['addNew'] = "user/addNew";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";

$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";

$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['checkEmailpengguna'] = "user/checkEmailpengguna";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

/* End of file routes.php */
/* Location: ./application/config/routes.php */