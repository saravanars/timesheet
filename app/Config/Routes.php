<?php

namespace Config;
use app\controllers\FormController;
use App\Controllers\GetUsers;
use App\Controllers\GetLogs;
use App\Controllers\Userdashboard;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('FormController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->setAutoRoute(true);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'FormController::index');
$routes->match(['get', 'post'], 'loginAuth', 'FormController::loginAuth');
//user routes //
    $routes->match(['get', 'post'], 'Login/change', 'FormController::change');
    $routes->get('/user', 'EmpController::index',['filter' => 'auth']);
    $routes->get('user_dashbaord',"EmpController::dashboard",['filter' => 'auth']);
    $routes->get('timesheet','Timesheet::index',['filter' => 'auth']);
    
    $routes->get('/login', 'FormController::index');
    $routes->get('/logout', 'FormController::logout');
    $routes->get('recover', 'FormController::recover');
    $routes->match(['get', 'post'], 'recoverpassword', 'FormController::recoverpassword');
    $routes->get('resetpassword/(:any)', 'FormController::resetpassword/$1');
    $routes->match(['get', 'post'],'update','FormController::updatepassword');
    $routes->add('timesheet/save', 'Timesheet::saveTimesheet',['filter' => 'auth']);
    $routes->get('mytimesheet', 'Timesheet::my_timesheets',['filter' => 'auth']);
    $routes->get('timesheet/fetchData', 'Timesheet::fetchdata',['filter' => 'auth']);
    $routes->get('timesheet/edit/(:any)', 'Timesheet::edit/$1',['filter' => 'auth']);
   $routes->get('timesheet/delete/(:num)', 'Timesheet::delete/$1',['filter' => 'auth']);
    $routes->post('timesheet/update', 'Timesheet::update',['filter' => 'auth']);
    $routes->post('timesheet_edit_err', 'Timesheet::edit',['filter' => 'auth']);

 $routes->post('/delete_row', 'Timesheet::delete_row', ['filter' => 'auth']);
 $routes->post('timesheet/ajaxvalidation', 'Timesheet::ajaxValidation');
 $routes->post('timesheet/ajaxvalidation_project_id', 'Timesheet::ajaxvalidation_project_id');

//  $routes->post('/timesheet/ajax_validation', 'Timesheet::ajax_validation', ['filter' => 'auth']);
$routes->get('todaydata/(:any)', 'Timesheet::data/$1',['filter' => 'auth']);
// $routes->delete('timesheet/delete/(:any)', 'Timesheet::delete/$1');
// $routes->post('accesskey/(:any)', 'Timesheet::checkAccess/$1', ['filter' => 'auth']);

$routes->post('access_key', 'Timesheet::access_key');

$routes->post('form_valid', 'Timesheet::form_ajax');

    $routes->get('mail','Mail::index');
    $routes->match(['get', 'post'], 'SendMail/sendMail', 'Mail::sendMail');
// Admin routes ///
    $routes->get('/changepassword', 'Company::changePassword');
    $routes->post('change_password', 'Company::update_Password');
    $routes->get('/admin', 'AdminController::index',['filter' => 'admin']);
    $routes->get('admin/filter/(:any)/(:any)/(:num)/(:num)','AdminController::search/$1/$2/$3/$4',['filter' => 'admin']);
    $routes->get('admin/csv/(:any)/(:any)/(:num)/(:num)','AdminController::csv/$1/$2/$3/$4',['filter' => 'admin']);
    $routes->match(['get', 'post'],'user_reports/download', 'AdminController::download',['filter' => 'admin']);
    $routes->match(['get', 'post'],'user_reports_csv/download', 'AdminController::download_csv',['filter' => 'admin']);

    $routes->get('/back', 'AdminController::index',['filter' => 'admin']);
  $routes->get('employees_dt', 'AdminController::permission_view',['filter' => 'admin']);
  $routes->post('/action_key', 'AdminController::permission_action', ['filter' => 'admin']);
$routes->post('/action_group', 'AdminController::access_key_all', ['filter' => 'admin']);

    $routes->get('add_project', 'AdminController::project_add_page',['filter' => 'admin']);
    $routes->post('project_adding','AdminController::project_adding', ['filter' => 'admin']);
    $routes->post('/project_active', 'AdminController::project_active', ['filter' => 'admin']);
    $routes->post('project_edit', 'AdminController::get_project_data',['filter' => 'admin']);
    $routes->post('update_project_name', 'AdminController::update_project_name',['filter' => 'admin']);
    $routes->get('add_employees', 'AdminController::employees_page',['filter' => 'admin']);
    $routes->post('employees_adding', 'AdminController::employees_adding',['filter' => 'admin']);
    $routes->get('daily_working_hours', 'AdminController::yesterday_reports');

    $routes->get('below_hours', 'AdminController::below_hours');
    $routes->post('/employee_active', 'AdminController::employee_active', ['filter' => 'admin']);


    $routes->get('employees/edit/(:num)', 'AdminController::edit/$1',['filter' => 'admin']);
    $routes->post('employees_update/', 'AdminController::update_employees',['filter' => 'admin']);
// $routes->get('user_reports/exportPDF/(:any)/(:any)/(:num)/(:num)', 'User_reports::exportPDF/$1/$2/$3/$4');
    $routes->post('admin/csv', 'AdminController::csv',['filter' => 'admin']);
    // $routes->match(['get', 'post'], 'admin/filter', 'AdminController::search',);
    $routes->get('adminview/(:any)', 'AdminController::admin_view/$1',['filter' => 'admin']);
   
   
    // $routes->get('/admin', 'Admindashboard::index');
    // User management
    // $routes->get('users', 'AdminController::userManagement');
    // $routes->post('users', 'AdminController::createUser');
    // $routes->get('users/(:num)', 'AdminController::editUser/$1');
    // $routes->put('users/(:num)', 'AdminController::updateUser/$1');
    // $routes->delete('users/(:num)', 'AdminController::deleteUser/$1');




// $routes->get('/user', 'EmpController::index',['filter' => 'auth']);
// $routes->get('timesheet','Timesheet::index',['filter' => 'auth']);
// $routes->get('/logout', 'FormController::logout');
// $routes->get('recover', 'FormController::recover');
// $routes->match(['get', 'post'], 'recoverpassword', 'FormController::recoverpassword');
// $routes->get('resetpassword/(:any)', 'FormController::resetpassword/$1');
// $routes->match(['get', 'post'],'update','FormController::updatepassword');
// $routes->get('mail','Mail::index');
// $routes->match(['get', 'post'], 'SendMail/sendMail', 'Mail::sendMail');


// $routes->match(['get', 'post'], 'LoginController/loginAuth', 'LoginController::loginAuth');
// $routes->get('/login', 'LoginController::index');
// $routes->get('/admin_dashboard', 'Admindashboard::index',['filter' => 'admin']);
// $routes->get('/dashboard', 'DashboardController::dashboard',['filter' => 'auth']);
// $routes->get('logout', 'LoginController::logout');
// $routes->get('UsersList', 'GetUsers::index',['filter' => 'admin']);
// $routes->get('LogsList', 'GetLogs::index',['filter' => 'admin']);
// $routes->get('UserEachList', 'Userdashboard::index',['filter' => 'auth']);
// $routes->get('error', 'ErrorController::index');
// new routes for login
//------------------------------------------------------------------------------
// $routes->get('/recoverpassword', 'FormController::showRecoverPasswordForm');
// $routes->post('/recoverpassword', 'FormController::recoverpassword');

// $routes->get('/activate/(:any)', 'FormController::activate/$1');
// $routes->get('/resetpassword/(:any)', 'FormController::showResetPasswordForm/$1');
// $routes->post('/resetpassword/(:any)', 'FormController::resetPassword/$1');
//--------------------------------------------------------------------------------
//$routes->match(['get', 'post'], 'login', 'LoginController::loginAuth', ["filter" => "noauth"]);
// Admin routes
// $routes->group("admin", ["filter" => "auth"], function ($routes) {
//     $routes->get("/", "Admindashboard::index");
// });
// // Editor routes
// $routes->group("editor", ["filter" => "auth"], function ($routes) {
//     $routes->get("/", "UserController::index");
// });
// $routes->get('logout', 'UserController::logout');
// $routes->match(['get', 'post'], 'SigninController/loginAuth', 'SigninController::loginAuth');
// $routes->get('/signin', 'SigninController::index');
// $routes->get('/profile', 'ProfileController::index',['filter' => 'authGuard']);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

//  $routes->get('/', 'Mail::index');
//  $routes->match(['get', 'post'], 'SendMail/sendMail', 'Mail::sendMail');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
