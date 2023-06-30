<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Models\TimesheetModel;
use App\Models\ProjectlistModel;
use App\Models\CompanyModel;
use Carbon\Carbon;
use CodeIgniter\API\ResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Timesheet extends BaseController
{
    protected $timesheet;
    protected $companyModel;
    public $session;

    public function __construct()
    {
        $session = session();
        $this->companyModel = new CompanyModel();
        $this->timesheet = new TimesheetModel();
        date_default_timezone_set("Asia/Calcutta");
    }

    public function index()
    {
        $session = session();
        $data = [];
        $empid = $session->get('emp_id');
        $data['access_key'] = $session->get('access_key');
        $projectModel = new ProjectlistModel();
        $data['projects_name'] = $projectModel->orderBy('project_name', 'ASC')->where('status', 1)->findAll();


        $data['navbar'] = view('common/user/layout/navbar');
        return view('timesheet', $data);
    }










    public function saveTimesheet()
    {
        // print_r($_POST);die;



       

        $request = service('request');
        $session = session();
        $empid = $session->get('emp_id');
        $companyData = $this->companyModel->where('emp_id', $empid)->first();
        $dates = date('Y-m-d');

        $date = $request->getVar('date');

        $time = date('H:i:s');
        $day = $date . " " . $time;
        // print_r($day);
        $report_time = date('Y-m-d H:i:s', strtotime($day));
        // print_r($report_time);die;
        $counter = $request->getVar('counter');
        $projectId = '';
        $errors = []; // Array to store validation errors
        // print_r($counter);die;
        for ($i = 1; $i <= $counter; $i++) {


            $projectId = $request->getVar('project_id_' . $i);
            // print_r($projectId);die;
            if (isset($projectId) && $projectId != '') {
                $module = $request->getVar('module_' . $i);
                $status = $request->getVar('status_' . $i);
                $task = $request->getVar('task_' . $i);
                $hour = $request->getVar('hours_' . $i);



                $emp_id = session('emp_id');
                $companyData = $this->companyModel->where('emp_id', $emp_id)->first();
                $today = date('Y-m-d');
                $access_key = $companyData['access_key'];
                // print_r($access_key);die
                
                
                
                
                $selectedDate = $date;// get the selected date from your form or request

                // Create the target time by adding 1 day and setting the desired time
                $targetTime = (new \DateTime($selectedDate))->modify('+1 day')->setTime(13, 0, 0);
// print_r($date);
                // Get the current time
                $currentTime = new \DateTime();
                // print_r($currentTime);die;
        
                if ($currentTime > $targetTime) {
                
                
                
      
                    if ($access_key !== '1') {
                        $errors[] = 'Invalid date. You can only save timesheets for the current date.';
                    }
                }

                // if ($companyData !== null) {
                //     $access_key = $companyData['access_key'];


                //     if ($access_key == 0 || $dates == $today) {
                //         $errors[] = 'Invalid date. You can only save timesheets for the current date.';

                //     } else {
                //         $errors[] = 'Access denied. Invalid access key. Please contact the admin.';
                //     }
                // } else {
                //     $errors[] = 'Company data not found.';
                // }


                if (!empty($hour)) {
                    $hour = floatval($hour);
                    if ($hour < 0.5 || $hour > 2) {
                        $errors[] = 'Hours should be between 1 and 2';
                    }
                } else {
                    $errors[] = 'Hours field is required';
                }

                if (empty($task)) {
                    $errors[] = 'Task is empty.';
                }
                // print_r($errors);die;
                if (empty($errors)) {
                    // Validation passed, proceed with saving the data
                    $task = htmlspecialchars($task);
                    $insertData = [
                        // 'date' => $date,
                        'emp_id' => $empid,
                        'project_id' => $projectId,
                        'module' => $module,
                        'status' => $status,
                        'task' => $task,
                        'hours' => $hour,
                        'report_time' => $report_time,
                    ];
                    // print_r($insertData);die;
                    $this->timesheet = new TimesheetModel();


                    $this->timesheet->insert($insertData);
                } else {

                    session()->setFlashdata('errors', $errors);
                    // print_r($errors);die;
                    return redirect()->back();
                }
            }
        }

        // If everything is successful, redirect to the desired page
        return redirect()->to('mytimesheet');
    }



    public function my_timesheets()
    {
        $session = session();

        $empId = $session->get('emp_id');
        $timesheetModel = new TimesheetModel();
        $data['myemployee'] = $timesheetModel
            ->select('timesheet_master.id, timesheet_master.emp_id, timesheet_master.report_time, timesheet_master.task, timesheet_master.hours, timesheet_master.updated_date_and_time, timesheet_master.report_time, timesheet_master.status, timesheet_master.id, project_list.project_name, tt1.team_name, timesheet_master.module')
            ->distinct()
            ->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id')
            ->join('team_master as tt1', 'tt1.team_id = emp1.team_id')
            ->join('project_list', 'project_list.project_id = timesheet_master.project_id')
            ->where('timesheet_master.emp_id', $empId)
            ->orderBy('timesheet_master.id', 'DESC')
            ->findAll();
        $companyModel = new CompanyModel();

        $company = $companyModel->where('emp_id', $empId)->first();
        $data['company'] = $company;

        $data['navbar'] = view('common/user/layout/navbar');
        $data['show_delete_button'] = false;
        $data['today_date'] = date('Y-m-d');
        return view('emptimesheet', $data);
    }






    public function edit($id)
    {
        // print_r($id);
        $session = session();
        $empId = $session->get('emp_id');

        $timesheetModel = new TimesheetModel();
        $projectModel = new ProjectlistModel();

        // Get the existing timesheet data with project names
        $timesheet = $timesheetModel
            ->select('timesheet_master.project_id, timesheet_master.id, timesheet_master.status, timesheet_master.task, timesheet_master.hours, timesheet_master.emp_id, timesheet_master.report_time, timesheet_master.module, timesheet_master.updated_date_and_time, project_list.project_id, project_list.project_name')
            ->join('project_list', 'timesheet_master.project_id = project_list.project_id', 'left')
            ->where('timesheet_master.emp_id', $empId)
            ->where('timesheet_master.id', $id)
            ->orderBy('timesheet_master.id', 'ASC')
            ->findAll();


        //    $date= $timesheet['report_time'];
        //    print_r($date);die;
        // Prepare the data to be passed to the view
        $date = date('Y-m-d');


        $companyData = $this->companyModel->where('emp_id', $empId)->first();
        $today = date('Y-m-d');
        $access_key = $companyData['access_key'];
        // print_r($access_key);die;
        if ($date !== $today) {
            if ($access_key !== '1') {
                $errors[] = ' Access denied.';
                session()->setFlashdata('errors', $errors);
                // print_r($errors);die;
                return redirect()->back();
            }
        }





        //  
        $data['timesheet'] = $timesheet;
        $data['navbar'] = view('common/user/layout/navbar');
        $data['projects_name'] = $projectModel->orderBy('project_name')->where('status', 1)->findAll();
        $data['date'] = $date;
        $newDate = $date;

        $data['newDate'] = $newDate;

        return view('timesheet_edit', $data);
    }



    public function update()
    {
        $timesheetModel = new TimesheetModel();
        $request = service('request');
        $session = session();
        $empid = $session->get('emp_id');
        $date = $request->getVar('date');
        $time = date('H:i:s');
        $day = $date . " " . $time;
        // print_r($dates);
        $updated_time = date('Y-m-d H:i:s', strtotime($day));
        // Add validation for the date
        if ($date != date('Y-m-d')) {
            $errors[] = 'Invalid date. Only the current date can be updated.';
        }

        $formData['data'] = $timesheetModel->where('report_time', $date)->where('emp_id', $empid)->findAll();

        $counter = $request->getVar('counter');
        if (!is_numeric($counter) || $counter < 0) {
            $counter = 0;
        }

        for ($i = 1; $i <= $counter; $i++) {
            $projectId = $request->getVar('project_id_' . $i);
            if (isset($projectId) && $projectId != '') {
                $module = $request->getVar('module_' . $i);
                $status = $request->getVar('status_' . $i);
                $task = $request->getVar('task_' . $i);
                $hour = $request->getVar('hours_' . $i);
                $id = $request->getVar('row_id_' . $i);

                $task = htmlspecialchars($task);






                // Add validation for the task
                if (empty($task)) {
                    $errors[] = 'Task field is empty';
                }

                // Add validation for the hour
                if (!empty($hour)) {
                    $hour = floatval($hour);
                    if ($hour < 0.5 || $hour > 2) {
                        $errors[] = 'Hours should be between 1 and 2';
                    }
                } else {
                    $errors[] = 'Hours field is required';
                }

                // if ($date != $request->getVar('date')) {
                //     $errors[] = 'Invalid date. Please select the current date.';
                // }

                if (empty($errors)) {
                    // Validation passed, proceed with updating or inserting the data
                    $updatedData = [
                        // 'date' => $date,
                        'emp_id' => $empid,
                        'project_id' => $projectId,
                        'module' => $module,
                        'status' => $status,
                        'task' => $task,
                        'hours' => $hour,
                        'updated_date_and_time' => $updated_time,
                    ];

                    if (!empty($id)) {
                        // Update existing record
                        $timesheetModel->update($id, $updatedData);
                    } else {
                        // Insert new record
                        $timesheetModel->insert($updatedData);
                    }
                }
            }
        }

        if (!empty($errors)) {
            $session->setFlashdata('errors', $errors);
            return redirect()->back()->with('errors', $session->getFlashdata('errors'));
        } else {
            return redirect()->to('mytimesheet');
        }

        // If everything is successful, redirect to the desired page
    }









    public function delete_row()
    {

        $timesheetModel = new TimesheetModel();
        $request = service('request');
        $id = $request->getVar('id');

        if (!empty($id)) {
            $deletedRows = [$id];
            $timesheetModel->whereIn('id', $deletedRows)->delete();
        }
    }

    // Assuming this code is in your server-side controller or route handler


    public function access_key()
    {

        $empId = $_POST['emp_id'];
        $companyModel = new CompanyModel();
        $companyData = $this->companyModel->where('emp_id', $empId)->first();
        $data = $companyData['access_key'];
        //  print_r($data);die;

        return $this->response->setJSON($data);
    }












    function ajaxValidation()
    {
        // Retrieve the submitted values

        $hourss = $_POST['hourss'];

        // Perform validation
        if (!is_numeric($hourss) || $hourss < 0.5 || $hourss > 2) {
            // Handle validation error
            $response =  array('error' => 'Maximum value is 2 hours.');
        } else {

            $response =  array('pass' => 'passed');
        }

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }














    public function data($date)
    {
        // echo "dklfdj";
        // die;
        $session = session();
        $empId = $session->get('emp_id');
        $timesheetModel = new TimesheetModel();
        $projectModel = new ProjectlistModel();
        // Get the existing timesheet data with project names
        $timesheet = $timesheetModel

            ->distinct()
            ->select('tm.project_id, tm.id, tm.status, tm.task, tm.hours, tm.emp_id, tm.report_time, tm.module, tm.date, pl.project_id, pl.project_name')
            ->from('timesheet_master as tm')
            ->join('project_list as pl', 'tm.project_id = pl.project_id', 'left')
            ->where('tm.emp_id', $empId)
            ->where('tm.date', $date)
            ->findAll();


        $data['timesheet'] = $timesheet;
        $data['navbar'] = view('common/user/layout/navbar');
        $data['projects_name'] = $projectModel->orderBy('project_name')->where('status', 1)->findAll();
        $data['date'] = $date;

        // Load the edit view with the timesheet data
        return view('data_view', $data);
    }


    public function delete($id)
    {
        // print_r($_POST);die;
        $session = session();
        $empId = $session->get('emp_id');

        $timesheetModel = new TimesheetModel();

        // Delete rows based on date and employee ID
        $deletedRows = $timesheetModel
            ->where('timesheet_master.emp_id', $empId)
            ->where('timesheet_master.id', $id)
            ->delete();

        if ($deletedRows === 0) {
            // No rows deleted, handle the error accordingly
            return redirect()->to('/timesheet')->with('error', 'Timesheet not found');
        }

        // Redirect to the timesheet listing page with a success message
        return redirect()->to('mytimesheet')->with('success', 'Timesheet deleted successfully');
    }
}




    // return view('emptimesheet', $data);
