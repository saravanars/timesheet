<?php

namespace App\Models;

use DateTime;
use DateInterval;
use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'employee';

    protected $allowedFields = ['emp_id','team_id','email', 'password','status', 'name','role_id','first_login','access_key'];

    public function email_exists($email)
    {
        return $this->where('email', $email)->first();
    }
    // $CompanyModel->updateotp($data['id'], ['reset_token' => $token]);
    public function updateotp($id, $token){
       
        $data = [
            'otp' => $token,
        ];
            return $this->db ->table('employee')->where(["emp_id" => $id])->set($data)->update();
        
    }
 public function expire_otp($id,$token){
    $data = [
        'otp' => $token,
    ];
        return $this->db ->table('employee')->where(["emp_id" => $id])->set($data)->update();
 }

 public function clearotp($id,$otp){

        //    print_r($otp); 
                  

        $data['otp'] = '';

    return $this->db ->table('employee')->where(["email" => $id])->set($data)->update();

        
    



 }
 


    
}

