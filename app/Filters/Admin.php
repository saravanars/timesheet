<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Admin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
       

        $role_id = session()->get('role_id');
        if (!session()->get('isLoggedIn') || $role_id != 2) {
            return redirect()->to('/login');
        }
        
			
        }


   
        
    
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
