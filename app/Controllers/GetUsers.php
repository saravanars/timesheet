<?php namespace App\Controllers;

use App\Models\GetUsersModel;

class GetUsers extends BaseController
{
    public function index()
    {
        $userModel = new GetUsersModel();
        $data['company_registration'] = $userModel->getUsers();
echo view('Admin/header');

        echo view('UsersList', $data);
        echo view('Admin/footer');
       
    }
}
