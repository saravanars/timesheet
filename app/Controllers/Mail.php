<?php 
namespace App\Controllers;
use App\Models\FormModel;
use CodeIgniter\Controller;
class Mail extends Controller
{
    public function index() 
	{
        return view('Mailform');
    }

   function sendMail() { 
    $request = service('request');
        $to = $request->getVar('mailTo');
        $subject = $request->getVar('subject');
        $message = $request->getVar('message');
        
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('saravanakumar_r@itflexsolutions.com', 'Confirm Registration');
        
        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) 
		{
            echo 'Email successfully sent';
        } 
		else 
		{
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }
}