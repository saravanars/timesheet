<?php
//  namespace App\Controllers;

// use App\Models\GetLogsModel;

// class GetLogs extends BaseController
// {
//     public function index()
//     {
//         $userModel = new GetLogsModel();
//         $data['log_maintain'] = $userModel->getUsers();

//         return view('LogsList', $data);
//     }
// }
namespace App\Controllers;

use App\Models\GetLogsModel;
use CodeIgniter\Controller;

class GetLogs extends BaseController
{
    public function index()
    {
        $model = new GetLogsModel();
        $data['logs'] = $model->getLogs();
        echo view('Admin/header');
        return view('LogsList', $data);
    }
}
