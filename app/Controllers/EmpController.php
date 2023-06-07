<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\Userlog;
  
class EmpController extends Controller
{
  // public $Userlog;
  public function __construct(){

  }
    public function index()
    {
    
  
    
      return redirect()->to('mytimesheet');
      // return view('/user_dashboard');
    
      
    }

    public function dashboard()
    {
    
  
      $data['navbar'] = view('common/user/layout/navbar');
      
     return view('/user_dashboard',$data);
      
    }
}
      // $this->Userlog = new Userlog();
      // $ds['ds'] = $this->Userlog->Userdata($ss);
    //     $session = session();
    //  $ss=$session->get('id');
    //   $ds= $this->Userlog->Userdata($ss);
      //  print_r($ds);
      //  die;