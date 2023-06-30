<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Models\CompanyModel;

class FormController extends BaseController
{
    public $CompanyModel;
    public $email;
   
    public function __construct()
    {
        $session = session();
        helper('custom_helper'); // Load the otp_helper.php file

      
    }
    public function index()
    {


        return view('login');
    }

    public function loginAuth()
    {

        $session = session();
        $request = service('request');
    

        $CompanyModel = new CompanyModel();

        $email = $request->getVar('email');
        $password = $request->getVar('password');

        $data = $CompanyModel->where('email', $email)->first();
        // var_dump($data);die;
        if ($data) {
         
            $pass = $data['password'];
   
            if (password_verify($password,$pass)) {

                $ses_data = [
                    'emp_id' => $data['emp_id'],
                    'name'=>$data['name'],
                    'email' => $data['email'],
                    'status' => $data['status'],
                    'role_id' => $data['role_id'],
                    'first_login' => $data['first_login'],
                    'team_id' => $data['team_id'],
                    'access_key'=>$data['access_key'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                // print_r($ses_data);
                // die;
                if($data['status'] == 0){
                    $session->setFlashdata('msg', 'Invalid user .');
                    return redirect()->to('/login');
                }

                if ($data['first_login'] == 1) {

                    return view('changepassword');
                    //the password change form

                }


                //    $this->loader->helper('redirect', $uri->root());
                if ($data['role_id'] == 2) {
                    // print_r('jncdj');die;
                    return redirect()->to('/admin');
                } else if ($data['role_id'] == 1) {
                    return redirect()->to('/user');
                } else {
                    $session->setFlashdata('msg', 'Invalid user role.');
                    return redirect()->to('/login');
                }
            } else {
                // echo "ssss";die;
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/login');
        }
    }
    


    public function change()
{
    $CompanyModel = new CompanyModel();
    $session = session();
    $Id = $session->get('emp_id');

    $data = $CompanyModel->where('emp_id', $Id)->first();

    if ($this->request->getMethod() == 'post') {
        $rules = [
            'old_pass' => 'required',
            'new_pass' => 'required|min_length[2]|max_length[50]',
            'confirm_pass' => 'required|matches[new_pass]'
        ];

        if ($this->validate($rules)) {
            $oldPass = $this->request->getVar('old_pass');
            $newPass = $this->request->getVar('new_pass');
            $confirmPass = $this->request->getVar('confirm_pass');

            if (password_verify($oldPass, $data['password'])) {
                if ($newPass === $confirmPass) {
                    $date = date('Y-m-d H:i:s');

                    $CompanyModel->set('password', password_hash($newPass, PASSWORD_DEFAULT))
                        ->set('updated_on', $date)
                        ->set('first_login', 0)
                        ->where('emp_id', $data['emp_id'])
                        ->update();

                    $session->setFlashdata('msg', 'Change Password updated successfully.');
                    $data = [];

                    $role_id = $session->get('role_id');
                    if ($role_id == 2) {
                        return redirect()->to('/admin');
                    } else if ($role_id == 1) {
                        return redirect()->to('/user');
                    } else {
                        $session->setFlashdata('msg', 'Invalid user role.');
                        return redirect()->to('/login');
                    }
                } else {
                    $session->setFlashdata('msg', 'Passwords do not match.');
                }
            } else {
                $session->setFlashdata('msg', 'Incorrect old password.');
            }
        } else {
            $data['validation'] = $this->validator;
        }
    }

    return view('changepassword', $data);
}


    public function logout()
    {
        // echo "sdbj"; die;
        $session = session();
        session()->destroy();
        return redirect()->to('/login');
    }

    public function recover()
    {
        return view('forgetpassword');
    }

    public function recoverpassword()
    {
        $request = service('request');
        $session = session();

        $email = $this->request->getPost('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            return view('auth/resetpassword', ['error' => 'Invalid email address']);
        }

        $CompanyModel = new CompanyModel();
        $data = $CompanyModel->where('email', $email)->first();;
        $session->set('email', $email);
        // $session->set('id', $data['id']);
        $datatime = date_default_timezone_set("Asia/Calcutta");


        if ($data) {

            $token = bin2hex(random_bytes(12));
            $session = session();
            // $id = $session->get('id');
            $session->set(['email' => $email, 'otp' => $token]);
            $CompanyModel->updateotp($data['emp_id'], ['otp' => $token], ['reset_created_at' => $datatime]);
            $to = $data['email'];
            $subject = 'Forgot password';
            $message = '<p>
            Hi , You recently requested to reset the password for your account. Click the link below to proceed <br>
             <a href="' . base_url() . 'resetpassword/' . $token . '"> click here </a><p>';
            $email = \config\services::email();
            $email->setTo($to);
            $email->setFrom('saravanakumar_r@itflexsolutions.com', 'itflex');

            $email->setSubject($subject);
            $email->setMessage($message);
            $email->send();
            $session->setFlashdata('msg', ' Reset Password  link sent to your mail <br>Click on the link');
            // delete_expired_otps($email);
            return redirect()->to('/login');
        } else {
            $data['validation'] = $this->validator;
            // print_r($data);die;
            echo view('resetpassword', $data);
        }



  
    }




    public function resetpassword($token)
    {

        $session = session();
        $email = $session->get('email');
        // $reset_token = $session->get('otp');

        // if ($token != $reset_token) {

        //     return view('forgetpassword', ['error' => 'Invalid password reset token']);
        // }
        // $session->set('reset_email', $email);
  

        $CompanyModel = new CompanyModel();
        $this->CompanyModel = $CompanyModel->where('email', $email)->first();
        $link1 = $token;
        $data = $CompanyModel->where('otp', $link1)->first();

        if (!$token) {
            $session->setFlashdata('msg', 'Reset token not found. Please try again');
            return redirect()->to('/login');
        }
        $CompanyModel = new CompanyModel();
        $data = $CompanyModel->where('otp', $token)->first();
        // print_r($data);die;
        if (!$data) {
            $session->setFlashdata('msg', 'Invalid or expired reset link');
            return redirect()->to('/login');
        }

        echo view('resetpassword', $data);
    }
    public function updatepassword()
    {

        // $session = session();
        $request = service('request');
        $user = $request->getVar('emp_id');

        $password = $request->getVar('password');
        $confirmpassword = $request->getVar('confirmpassword');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($request->getMethod() == 'post') {

            $rules = [
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]',
                ],
                'confirmpassword' => [
                    'label' => 'Password Confirmation',
                    'rules' => 'required|matches[password]',
                ]
            ];


            $session = session();
            $email = $session->get('email');
            $reset_token = $session->get('otp');
       
// print_r($_SESSION);
            if (!$reset_token) {

                return view('resetpassword', ['error' => 'Password reset token missing']);
            }
            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
               
                $CompanyModel = new CompanyModel();
                $id['emp_id'] = $user;
                $data['password'] = $password;
                $session = session();
                $email = $session->get('email');
                $result = $CompanyModel->set('password',  $hashedPassword)->where('email', $email)->update();
                if ($result) {
                    $d = $session->get('email');
                    $to = $d;
                    $subject = 'Reset Password';
                    $message = '<p> Account password has been changed successfully! and link for one time useable .<p>';
                    $email = \config\services::email();
                    $email->setTo($to);
                    $email->setFrom('saravanakumar_r@itflexsolutions.com', 'itflex');
                    $email->setSubject($subject);
                    $email->setMessage($message);
                    $email->send();
                    $CompanyModel = new CompanyModel();
                    $session = session();
                    $otp = $session->get('otp');
                    $id = $session->get('email');
                    // print_r($id);
                    // $CompanyModel->set('otp', null)->where('id', $id)->update();
                    $CompanyModel->clearotp($id, ['otp' => null]);

                    // unset($_SESSION['otp']);
                    session()->setFlashdata('msg', ' Update Password  successful. Please login with your new password');
                    return redirect()->to('/login');
                } else {
                    echo "mail is not sent";
                }
            }
        }
        // print_r($data);
        // die;
        echo view('/login');
    }
}
