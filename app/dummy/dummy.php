<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\CompanyRegistrationModel;
use App\Models\LogMaintainModel;
use App\Controllers\CompanyModel;
use App\Models\UserDataModel;
use App\Models\GetLogsModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
class LoginController extends Controller
{
    public function __construct()
    {
        public $CompanyModel;
        helper('form');
     
        // $this->load->view("includes/header.php",$headerData);
    }
    public function index()
    {   helper('form');
        echo view('loginview');
        
    }

    public function loginAuth()

{

    $session = session();

    $model = new LogMaintainModel();
    // Get the form input values
    $request = service('request');


    $email = $request->getPost('email');
    $password = $request->getPost('password');
  
    // $email = $this->request->getPost('email');
    // $password = $this->request->getPost('password');
    // Check if the user exists in the admin table
    $CompanyModel = new CompanyModel();
    $CompanyModel = $CompanyModel->where('email', $email)->first();
   
   
    // Check if the user exists in the company_registration table
    // $companyRegistrationModel = new CompanyRegistrationModel();
    // $companyRegistration = $companyRegistrationModel->where('email', $email)->first();

    // Insert the login timestamp with ID, email and IP address in log_maintain table
  

    if($CompanyModel){
        $pass = $CompanyModel['password'];
        $authenticatePassword = password_verify($password, $pass);
        if($authenticatePassword){
            $ses_data = [
                'id' => $CompanyModel['id'],
                'email' => $CompanyModel['email'],
                'type'=>$CompanyModel['type'],
                 'isLoggedIn' => TRUE
            ];
            $session->set($ses_data);
        // print_r($ses_data);
        // die()
        // $id= $ses_data['id'];
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $data = [
                'email' => $email,
                'log_time' => date('Y-m-d H:i:s'),
                'ip_address' => $ipAddress,
                
            ];
            $model->insert($data);
            return redirect('admin_dashboard');
        
        }else{
            $session->setFlashdata('msg', 'Password is incorrect.');
            return view('login');
        }
    }elseif($companyRegistration){
        $pass = $companyRegistration['password'];
        $authenticatePassword = password_verify($password, $pass);
        if($authenticatePassword){
          
            $ses_data = [
                'id' => $companyRegistration['id'],
                'email' => $companyRegistration['email'],
                 'type'=>$companyRegistration['type'],
                 'isLoggedIn' => TRUE
            ];
            $session->set($ses_data);
          
            $id= $companyRegistration['id'];
          
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $data = [
                'email' => $email,
                'log_time' => date('Y-m-d H:i:s'),
                'ip_address' => $ipAddress,
                'person_id'=>$id
            ];

            $model->insert($data);
           
            return view('dashboard');
         
        
        }else{
            $session->setFlashdata('msg', 'Password is incorrect.');
            return redirect()->to('login');
        }
    }else{
        $session->setFlashdata('msg', 'Email does not exist.');
        return redirect()->to('login');
    }
}
public function logout()
{
    $session=session();
    
    $session->destroy();
    return redirect()->to('login');
}


}
// private function logLogin($id, $email)
// {
//     $logMaintainModel = new LogMaintainModel();
//     $logMaintainModel->insert([
//         'user_id' => $id,
//         'user_email' => $email,
//         'login_time' => date('Y-m-d H:i:s')
//     ]);
// }


<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
  
class SignupController extends Controller
{
    public function index()
    {
        helper(['form']);
        $data = [];
        echo view('signup', $data);
    }
  
    public function store()
    {
        $session = session();
        helper(['form']);
        $rules = [
            'name'          => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'phonenumber'   => 'required|min_length[10]|max_length[13]',
            'address'       => 'required|min_length[15]|max_length[100]',
            'gender'        => 'required|min_length[1]|max_length[2]',
            'dateofbirth'   => 'required|min_length[10]|max_length[15]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'confirmpassword'  => 'matches[password]'
        ];
          
        if($this->validate($rules)){
            $userModel = new UserModel();
            helper('text');
            $link = random_string('alnum',5);
            $user = 0;
            $data = [
                'name'     => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'phonenumber'    => $this->request->getVar('phonenumber'),
                'address'    => $this->request->getVar('address'),
                'gender'    => $this->request->getVar('gender'),
                'dateofbirth'    => $this->request->getVar('dateofbirth'), 
                'link' => $link,
                'isadmin' => $user,                   
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)

            ];
            $userModel->save($data);
            $to = $data['email'];
            $subject = 'Email Verification';
            $message = '<p>Please activate the account <a href="' . base_url().'/SignupController/activate/'.$link.'"> Activate Now </a><p>';
            $email = \config\services::email();
            $email->setTo($to);
            $email->setFrom('azhaguthilip@itflexsolutions.com', 'Confirm Registration');

            $email->setSubject($subject);
            $email->setMessage($message);
            $email->send();
            $session->setFlashdata('msg', 'Activation Link sent to your account<br>Click on the link to Activate');
                            return redirect()->to('/signin');
           
        }else{
            $data['validation'] = $this->validator;
            echo view('signup', $data);
        }
          
    }
  
    public function sendMail()
    {
    //    $this->request->setVar('email', $this->request->getVar('email'));
        helper(['form']);
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $data = $userModel->where('email', $email)->first();
        if ($data > 0) {
            $otp = "";
            for ($i = 1; $i <= 6; $i++) {
                $otp .= rand(0,9);
            }
        
            $userModel->set('otp', $otp)->where('email', $email)->update();
            $to = $email;
            $subject = 'Email Verification';
            $message = 'Hi,<br><br>Your Registration OTP is '.$otp.' dont share with others';
            $email = \config\services::email();
            $email->setTo($to);
            $email->setFrom('azhaguthilip@itflexsolutions.com', 'Confirm Registration');
    
            $email->setSubject($subject);
            $email->setMessage($message);
            if ($email->send()){
                echo view('/emailotp');
            } 
            else 
            {
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }
        }else{
            $session->setFlashdata('msg', 'Enter the Registered Mail Id');
            return redirect()->to('/verify');
        }
       
    }

    public function activate($link)
    {
        $session = session();
        $userModel = new UserModel();
        $link1 = $link;
        $data = $userModel->where('link', $link1)->first();
        $status = 1;
        
        if($data){
            $link2 = $data['link'];
            if ($link1 == $link2) {
                $userModel->set('status', $status)->where('link', $link2)->update();
                $session->setFlashdata('msg', 'successfully activated the account <br><br> login to Continue');
                return redirect()->to('/signin');
            }
        }
    }
}
---------------------------
<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        return redirect()->to('/auth/login');
    }

    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        // Validate login form submission
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            $data['validation'] = $validation->getErrors();
            return view('auth/login', $data);
        }

        // Verify login credentials
        $userModel = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $userModel->where('username', $username)->first();
        if (!$user || !password_verify($password, $user['password'])) {
            $data['validation'] = [
                'login' => 'Invalid username or password',
            ];
            return view('auth/login', $data);
        }

        // Set session data and redirect
        session()->set([
            'isLoggedIn' => true,
            'userId' => $user['id'],
            'username' => $user['username'],
            'firstName' => $user['first_name'],
            'lastName' => $user['last_name'],
        ]);
        if ($user['first_login']) {
            return redirect()->to('/auth/change-password');
        } else {
            return redirect()->to('/dashboard');
        }
    }

    public function changePassword()
    {
        // Only allow logged in users with first_login = true to access this page
        if (!session()->get('isLoggedIn') || !session()->get('firstLogin')) {
            return redirect()->to('/auth/login');
        }

        // Validate change password form submission
        $validation = \Config\Services::validation();
        $validation->setRules([
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            $data['validation'] = $validation->getErrors();
            return view('auth/change_password', $data);
        }

        // Update user's password and set first_login = false
        $userModel = new UserModel();
        $userModel->update(session()->get('userId'), [
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'first_login' => false,
        ]);

        // Set session data and redirect
        session()->set([
            'firstLogin' => false,
        ]);
        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        // Destroy session data and redirect to login page
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
--------------
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'first_name', 'last_name', 'first_login'];
}


--------------------------
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    public function authenticate($username, $password)
    {
        // Load the user from the database based on the provided username
        $user = $this->where('username', $username)
                     ->first();

        // Check if the user exists and if the password is correct
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    public function changePassword($userId, $oldPassword, $newPassword, $confirmPassword)
    {
        // Load the user from the database
        $user = $this->find($userId);

        // Check if the old password is correct
        if (!password_verify($oldPassword, $user['password'])) {
            return false;
        }

        // Check if the new password and confirm password match
        if ($newPassword !== $confirmPassword) {
            return false;
        }

        // Update the user's password in the database
        $this->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return true;
    }

    public function updateFirstLogin($userId)
    {
        // Update the user's first_login flag to false
        $this->update($userId, [
            'first_login' => false
        ]);
    }
}

<?= form_open('/auth/processLogin') ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
<?= form_close() ?>

<?= form_open('/auth/processChangePassword') ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <div class="form-group">
        <label for="old_password">Old Password:</label>
        <input type="password" class="form-control" name="old_password" required>
    </div>
    <div class="form-group">
        <label for="new_password">New Password:</label>
        <input type="password" class="form-control" name="new_password" required>
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" class="form-control" name="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-primary">Change Password</button>
<?= form_close() ?>
------------------


-------------------------

-----------------------
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(255) DEFAULT NULL,
    `first_name` varchar(255) DEFAULT NULL,
    `last_name` varchar(255) DEFAULT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `first_login` tinyint(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  --------------
  <?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Router\RouteGroup;

$routes = new RouteCollection();

$routes->add('/', 'Auth::index');
$routes->add('/auth', 'Auth::index');
$routes->add('/auth/login', 'Auth::login');
$routes->add('/auth/change-password', 'Auth::changePassword');
$routes->add('/auth/logout', 'Auth::logout');

return $routes;
------------------------------final
    // public function change_password()
    // {
    //     $session = session();
      
    //     $companyModel = new CompanyModel();

    //     $id = $session->get('id');
    //       print_r($id);die;
    //     $data = $companyModel->find($id);
     
    

    //     if (!$data) {
    //         $session->setFlashdata('msg', 'User not found.');
    //         return redirect()->to('/login');
    //     }

    //     $request = service('request');

    //     $oldPassword = $request->getVar('old_password');
    //     $newPassword = $request->getVar('new_password');
    //     $confirmPassword = $request->getVar('confirm_password');

    //     if ($newPassword !== $confirmPassword) {
    //         $session->setFlashdata('msg', 'New password and confirm password do not match.');
    //         return redirect()->to('/changepassword');
    //     }

    //     $password = $data['password'];

    //     if (!password_verify($oldPassword, $password)) {
    //         $session->setFlashdata('msg', 'Old password is incorrect.');
    //         return redirect()->to('/changepassword');
    //     }

    //     $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    //     $data['password'] = $passwordHash;
    //     $data['first_login'] = 0;

    //     $companyModel->save($data);

    //     $session->setFlashdata('msg', 'Password has been changed successfully.');
    //     return redirect()->to('/');
    // }

    // public function update_Password()
    // {
    //     $session = session();

    //     // check if user is logged in
    //     if (!$session->get('isLoggedIn')) {
    //         return redirect()->to('/login');
    //     }

    //     $request = service('request');
    //     $model = new CompanyModel();

    //     // define validation rules
    //     $rules = [
    //         'old_password' => 'required',
    //         'new_password' => 'required|min_length[8]',
    //         'confirm_password' => 'matches[new_password]'
    //     ];

    //     // run validation
    //     if (!$this->validate($rules)) {
    //         $session->setFlashdata('errors', $this->validator->getErrors());
    //         return redirect()->to('/user/change_password')->withInput();
    //     }

    //     $userId = $session->get('id');
    //     $userData = $model->find($userId);

    //     // check if old password is correct
        
    //     // update user's password and first_login flag
    //     $model->update($userId, ['password' => password_hash($request->getPost('new_password'), PASSWORD_DEFAULT), 'first_login' => 0]);

    //     // set success message and redirect to change password page
    //     $session->setFlashdata('success', 'Password updated successfully!');
    //     return redirect()->to('/login');
    // }


    // public function change()
// {
//     $session = session();
//     $request = service('request');
//     $CompanyModel = new CompanyModel();
//     $Id = $session->get('emp_id');
//     $data = $CompanyModel->where('emp_id', $Id)->first();

//     if ($request->getMethod() == 'post') {
//         $rules = [
//             'old_pass' => 'required',
//             'new_pass' => 'required|min_length[2]|max_length[50]',
//             'confirm_pass' => 'required|matches[new_pass]',
//         ];

//         if ($this->validate($rules)) {
//             $old_pass = $request->getVar('old_pass');
//             $new_pass = $request->getVar('new_pass');
//             $confirm_pass = $request->getVar('confirm_pass');

//             if (md5($old_pass) != $data['password']) {
//                 $data['old_pass_error'] = 'Incorrect old password';
//                 return view('changepassword', $data);
//             }

//             if ($new_pass != $confirm_pass) {
//                 $data['new_pass_error'] = 'New passwords do not match';
//                 return view('changepassword', $data);
//             }

//             $CompanyModel->update($data['emp_id'], [
//                 'password' => md5($new_pass),
//                 'first_login' => 0
//             ]);

//             $session->setFlashdata('msg', 'Password updated successfully.');
//             $role_id = $session->get('role_id');

//             if ($role_id == 2) {
//                 return redirect()->to('/admin');
//             } else if ($role_id == 1) {
//                 return redirect()->to('/user');
//             } else {
//                 $session->setFlashdata('msg', 'Invalid user status.');
//                 return redirect()->to('/login');
//             }
//         } else {
//             $data['validation'] = $this->validator;
//             return view('changepassword', $data);
//         }
//     } else {
//         return view('changepassword', $data);
//     }
// }