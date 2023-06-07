<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Controllers\BaseController;
use App\Models\TimesheetModel;
use App\Models\ProjectlistModel;
use App\Models\CompanyModel;
use Dompdf\Dompdf;
use Mpdf\mPDF;
use CodeIgniter\HTTP\RequestInterface;
use Config\Services;

class AdminController extends BaseController
{


    protected $db;

    public function __construct()
    {

        $this->db = db_connect();
        helper('custom_helper'); // Load the otp_helper.php file


        // Initialize the database connection
    }
    public function index()
    {

        $CompanyModel = new CompanyModel();
        $Projectmodel = new ProjectlistModel();

        $timesheetModel = new TimesheetModel();






        $timesheetModel->select('timesheet_master.date, pl1.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp1.name,tt1.team_name,timesheet_master.status,emp1.emp_id');
        $timesheetModel->join('project_list as pl1', 'pl1.project_id = timesheet_master.project_id');
        $timesheetModel->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id');
        $timesheetModel->join('team_master as tt1', 'tt1.team_id = emp1.team_id');
        // print_r($timesheets);die;

        // print_r( $timesheets['row']);die;

        // $data['single_project'] = $timesheetModel->getreport();
        $data['single_project'] = $timesheetModel->findAll();

        $data['data'] =  $CompanyModel->findall();

        // print_r( $timesheets['data']);die;
        $data['row'] =  $Projectmodel->findall();







        //     $currentMonth = date('m');
        //     $data['single_project'] = array_filter( $data['single_project'], function($formData) use ($currentMonth) {
        //         $reportDate = date('m', strtotime($formData['date']));
        //         return $reportDate === $currentMonth;
        //     });
        //     $currentMonth = date('m');
        // $currentYear = date('Y');

        // $startDate = date('Y-m-01', strtotime("$currentYear-$currentMonth"));
        // $endDate = date('Y-m-t', strtotime("$currentYear-$currentMonth"));
        //     $data['startDate'] = $startDate;
        // $data['endDate'] = $endDate;
        ob_clean();
        flush();

        // print_r($endDate);die;
        return view('/admin_dashboard', $data);
    }



    // public function searchAndDownload()
    // {
    //     $request = service('request');
    //     $timesheetModel = new TimesheetModel();

    //     $fromDate = $request->getPost('fromDate');
    //     $toDate = $request->getPost('toDate');
    //     $emp = $request->getPost('emp');
    //     $project_name = $request->getPost('project_name');

    //     if (!empty($fromDate) && !empty($toDate) && !empty($emp) && !empty($project_name)) {
    //         $timesheetModel->select('timesheet_master.date, pl1.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours, emp1.name, tt1.team_name');
    //         $timesheetModel->join('project_list as pl1', 'pl1.project_id = timesheet_master.project_id');
    //         $timesheetModel->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id');
    //         $timesheetModel->join('team_master as tt1', 'tt1.team_id = emp1.team_id');
    //         $timesheetModel->where('timesheet_master.date >=', $fromDate);
    //         $timesheetModel->where('timesheet_master.date <=', $toDate);
    //         $timesheetModel->where('timesheet_master.emp_id', $emp);
    //         $timesheetModel->where('timesheet_master.project_id', $project_name);
    //     } elseif (!empty($fromDate) && !empty($toDate)) {
    //         $timesheetModel->select('timesheet_master.date, pl2.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours, emp2.name, tt2.team_name');
    //         $timesheetModel->join('project_list as pl2', 'pl2.project_id = timesheet_master.project_id');
    //         $timesheetModel->join('employee as emp2', 'emp2.emp_id = timesheet_master.emp_id');
    //         $timesheetModel->join('team_master as tt2', 'tt2.team_id = emp2.team_id');
    //         $timesheetModel->where('date >=', $fromDate)->where('date <=', $toDate);
    //     } elseif (!empty($project_name)) {
    //         $timesheetModel->select('timesheet_master.date, pl3.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours, emp3.name, tt3.team_name');
    //         $timesheetModel->join('employee as emp3', 'emp3.emp_id = timesheet_master.emp_id');
    //         $timesheetModel->join('team_master as tt3', 'tt3.team_id = emp3.team_id');
    //         $timesheetModel->join('project_list as pl3', 'pl3.project_id = timesheet_master.project_id');
    //         $timesheetModel->where('timesheet_master.project_id', $project_name);
    //     } elseif (!empty($emp)) {
    //         $timesheetModel->select('timesheet_master.date, pl4.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.status, timesheet_master.hours, emp4.name, tt4.team_name');
    //         $timesheetModel->join('employee as emp4', 'emp4.emp_id = timesheet_master.emp_id');
    //         $timesheetModel->join('team_master as tt4', 'tt4.team_id = emp4.team_id');
    //         $timesheetModel->join('project_list as pl4', 'pl4.project_id = timesheet_master.project_id');
    //         $timesheetModel->where('timesheet_master.emp_id', $emp);
    //         $timesheetModel->orderBy('timesheet_master.date', 'ASC');
    //     }

    //     $data = $results['form'] = $timesheetModel->findAll();

    //     $results['name'] = $data[0]['name'];
    //     $results['team_name'] = $data[0]['team_name'];

    //     $results['download'] = " ";
    //     $currentMonth = date('m');
    //     $results['form'] = array_filter($results['form'], function ($formData) use ($currentMonth) {
    //         $reportDate = date('m', strtotime($formData['date']));
    //         return $reportDate === $currentMonth;
    //     });

    //     $html = view('pdf', $results);
    //     $dompdf = new \Dompdf\Dompdf();
    //     $dompdf->loadHtml($html);
    //     $dompdf->setPaper('A4', 'landscape');

    //     $filename = date('Ymd-His') . '.pdf';

    //     $dompdf->render();

    //     // Set the appropriate headers for PDF download
    //     header('Content-Type: application/pdf');
    //     header('Content-Disposition: attachment; filename="' . $filename . '"');

    //     echo $dompdf->output();
    // }




    public function search($fromDate, $toDate, $emp, $project_name)
    {
        $request = service('request');

        $timesheetModel = new TimesheetModel();


        if (empty($fromDate && $toDate &&  $emp  && $project_name)) {
            $timesheetModel->select('timesheet_master.date, pl1.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp1.name,tt1.team_name,timesheet_master.status,,emp1.emp_id');
            $timesheetModel->join('project_list as pl1', 'pl1.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt1', 'tt1.team_id = emp1.team_id');
        }




        // if ($fromDate && $toDate && $emp && $project_name) {
        //     $timesheetModel->select('timesheet_master.date, project_list.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours');
        //     $timesheetModel->join('project_list', 'project_list.project_id = timesheet_master.project_id');
        //     $timesheetModel->where('timesheet_master.date >=', $fromDate);
        //     $timesheetModel->where('timesheet_master.date <=', $toDate);
        //     $timesheetModel->where('timesheet_master.emp_id', $emp);
        //     $timesheetModel->where('timesheet_master.project_id', $project_name);
        // }



        if ($fromDate && $toDate && $emp && $project_name) {
            $timesheetModel->select('timesheet_master.date,p5.project_name , timesheet_master.module, timesheet_master.task, timesheet_master.hours,e5.name,e5.emp_id,t5.team_name,timesheet_master.status ');
            $timesheetModel->join('project_list p5', 'p5.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee e5', 'e5.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master t5', 't5.team_id = e5.team_id');
        }


        if ($fromDate && $toDate) {
            $timesheetModel->select('timesheet_master.date, pl2.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp2.name,tt2.team_name,timesheet_master.status,emp2.emp_id');
            $timesheetModel->join('project_list as pl2', 'pl2.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee as emp2', 'emp2.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt2', 'tt2.team_id = emp2.team_id');

            $timesheetModel->where('date >=', $fromDate)->where('date <=', $toDate);
        }

        if ($project_name) {
            $timesheetModel->select('timesheet_master.date, pl3.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp3.name,tt3.team_name,timesheet_master.status,emp3.emp_id');
            $timesheetModel->join('employee as emp3', 'emp3.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt3', 'tt3.team_id = emp3.team_id');
            $timesheetModel->join('project_list as pl3', 'pl3.project_id = timesheet_master.project_id');
            $timesheetModel->where('timesheet_master.project_id', $project_name);
        }

        // Employees
        if ($emp) {
            // echo '<pre>'.$emp;
            $timesheetModel->select('timesheet_master.date, pl4.project_name, timesheet_master.module, timesheet_master.task,timesheet_master.status, timesheet_master.hours,emp4.name,tt4.team_name,emp4.emp_id');
            $timesheetModel->join('employee as emp4', 'emp4.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt4', 'tt4.team_id = emp4.team_id');
            $timesheetModel->join('project_list as pl4', 'pl4.project_id = timesheet_master.project_id');
            $timesheetModel->where('timesheet_master.emp_id', $emp);
            $timesheetModel->orderBy('timesheet_master.date', 'ASC');
        }




        $data = $results['form'] = $timesheetModel->findAll();
        // $enhf = $data[0]['task'];
        // echo strip_tags($enhf);die;
        $results['name'] = $data[0]['name'];
        $results['team_name'] = $data[0]['team_name'];

        $results['download'] = 0;
        $currentMonth = date('m');
        $results['form'] = array_filter($results['form'], function ($formData) use ($currentMonth) {
            $reportDate = date('m', strtotime($formData['date']));
            return $reportDate === $currentMonth;
        });

        return view('pdf', $results);
    }







    public function download()
    {


        $date = $this->request->getPost('report_date[]');
        $employee = $this->request->getPost('name[]');
        // print_r($_POST);die;

        $project_name = $this->request->getPost('project_name[]');
        $team_name = $this->request->getPost('team[]');

        $module = $this->request->getPost('module[]');

        $task = $this->request->getPost('task[]');
        $tasks = array_map('html_entity_decode', $task);

        $empid = $this->request->getPost('emp_id[]');
        $status = $this->request->getPost('status[]');
        $working_hours = $this->request->getPost('working_hours[]');
        // print_r($date);exit();

        $datas = [];
        $data = array();
        if (isset($project_name) && is_array($project_name)) {
            $data = array();

            $master = count($project_name);

            for ($i = 0; $i < $master; $i++) {
                $Project_model = new ProjectlistModel();
                $timesheetModel = new TimesheetModel();
                $project = $Project_model->where('project_name', $project_name[$i])->first();
                // print_r($project);die;
                $pro_id  = $project['project_id'];
                // print_r($pro_id);exit();
                $data = $timesheetModel->where('emp_id', $empid[$i])->where('project_id', $pro_id)->where('date', $date[$i])->first();

                $formData = [
                    'emp_id' => $empid[$i],
                    'date' => $date[$i],
                    'project_name' => $project_name[$i],
                    'task' => htmlspecialchars_decode($task[$i], ENT_NOQUOTES),
                    'module' => $module[$i],
                    'status' => $status[$i],
                    'hours' => $working_hours[$i]
                ];
                array_push($datas, $formData);
            }
        }

        //echo '<pre>'; print_r($formData); die;

        $results['form'] = $datas;
        $results['name'] = $employee;
        $results['team_name'] = $team_name;
        $results['download'] = 1;
        $html = view('pdf', $results);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('pdf'));
        $dompdf->setPaper('A4', 'landscape');
        // $filename = date('Y_m_d H_i_s') . '.pdf';
        // $dompdf->setOutputFilename($filename);
        // $config['file_name'] = date("Y_m_d H:i:s");

        // $dompdf->render();
        // $dompdf->stream();
        $filename = date('Ymd-h_i_s') . '.pdf';

        $dompdf->render();

        // Set the appropriate headers for PDF download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo $dompdf->output();
    }




    public function csv($fromDate, $toDate, $emp, $project_name)
    {
        $request = service('request');
        // print_r($_POST);die;
        $timesheetModel = new TimesheetModel();


        if (empty($fromDate && $toDate &&  $emp  && $project_name)) {
            $timesheetModel->select('timesheet_master.date, pl1.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp1.name,tt1.team_name,timesheet_master.status,emp1.emp_id');
            $timesheetModel->join('project_list as pl1', 'pl1.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt1', 'tt1.team_id = emp1.team_id');
        }

        if ($fromDate && $toDate) {
            $timesheetModel->select('timesheet_master.date, pl2.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp2.name,tt2.team_name,timesheet_master.status,emp2.emp_id');
            $timesheetModel->join('project_list as pl2', 'pl2.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee as emp2', 'emp2.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt2', 'tt2.team_id = emp2.team_id');

            $timesheetModel->where('date >=', $fromDate)->where('date <=', $toDate);
        }
        if ($project_name) {
            $timesheetModel->select('timesheet_master.date, pl3.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp3.name,tt3.team_name,timesheet_master.status,emp3.emp_id');
            $timesheetModel->join('employee as emp3', 'emp3.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt3', 'tt3.team_id = emp3.team_id');
            $timesheetModel->join('project_list as pl3', 'pl3.project_id = timesheet_master.project_id');
            $timesheetModel->where('timesheet_master.project_id', $project_name);
        }

        // Employees
        if ($emp) {
            // echo '<pre>'.$emp;
            $timesheetModel->select('timesheet_master.date, pl4.project_name, timesheet_master.module, timesheet_master.task,timesheet_master.status, timesheet_master.hours,emp4.name,tt4.team_name,emp4.emp_id');
            $timesheetModel->join('employee as emp4', 'emp4.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt4', 'tt4.team_id = emp4.team_id');
            $timesheetModel->join('project_list as pl4', 'pl4.project_id = timesheet_master.project_id');
            $timesheetModel->where('timesheet_master.emp_id', $emp);
            $timesheetModel->orderBy('timesheet_master.date', 'ASC');
        }



        if ($fromDate && $toDate && $emp && $project_name) {
            $timesheetModel->select('timesheet_master.date,p5.project_name , timesheet_master.module, timesheet_master.task, timesheet_master.hours,e5.name,e5.emp_id,t5.team_name,timesheet_master.status ');
            $timesheetModel->join('project_list p5', 'p5.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee e5', 'e5.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master t5', 't5.team_id = e5.team_id');
        }

        $data = $results['form'] = $timesheetModel->findAll();

        $results['name'] = $data[0]['name'];
        $results['team_name'] = $data[0]['team_name'];

        $results['download'] = " ";
        $currentMonth = date('m');
        $results['form'] = array_filter($results['form'], function ($formData) use ($currentMonth) {
            $reportDate = date('m', strtotime($formData['date']));
            return $reportDate === $currentMonth;
        });
        return view('csv', $results);
    }



    public function download_csv()
    {
        $Date = $this->request->getPost('report_date[]');
        $employee = $this->request->getPost('name[]');
        $Project_name = $this->request->getPost('project_name[]');
        $team_name = $this->request->getPost('team[]');
        $Module = $this->request->getPost('module[]');
        $task = $this->request->getPost('task[]');
        $empid = $this->request->getPost('emp_id[]');
        $status = $this->request->getPost('status[]');

        $Working_hours = $this->request->getPost('working_hours[]');

        $data = array();
        $master = count($Project_name);

        $head = [
            'Date',
            'Project Name',
            'Modules',
            'Task',
            'Status',
            'Working Hours'
        ];

        array_push($data, $head);
        $csvData = array(); // Use a different variable to store the CSV data
        for ($i = 0; $i < $master; $i++) {
            $Project_model = new ProjectlistModel();
            $timesheetModel = new TimesheetModel();
            $project = $Project_model->where('project_name', $Project_name[$i])->first();
            // print_r($project);die;
            $pro_id  = $project['project_id'];
            // print_r($pro_id);exit();
            $data = $timesheetModel->where('emp_id', $empid[$i])->where('project_id', $pro_id)->where('date', $Date[$i])->first();
            $csv_data = [
                'emp_id' => $empid[$i],
                'date' => $Date[$i],
                'project_name' => $Project_name[$i],
                'module' => $Module[$i],
                'task' => htmlspecialchars_decode($task[$i], ENT_NOQUOTES),
                'status' => $status[$i],

                'hours' => $Working_hours[$i]
            ];





            array_push($csvData, $csv_data); // Store the CSV data in the $csvData array

            $results['form'] = $data;
            $results['name'] = $employee;
            $results['download'] = 1;
            $results['team_name'] = $team_name;
        }
        // print_r($csvData);die;
        if (is_array($csvData)) {

            // Extract values from the array
            $name = $results['name'];

            $teamName = $results['team_name'];

            // Create the CSV string
            $csvString = "Date,Name,Team Name,Project Name,Module,Task Description,Status,Hours\n";

            foreach ($csvData as $task) {
                // Extract task information from $task array

                $date = $task['date'];
                $projectName = $task['project_name'];
                $module = $task['module'];
                $taskDescription = strip_tags($task['task']);
                $status = $task['status'];
                $hours = $task['hours'];

                // Append the task information to the CSV string
                $csvString .= "$date,$name,$teamName,$projectName,$module,\"$taskDescription\",$status,$hours\n";
            }

            // Set the appropriate headers for CSV file download
            header('Content-Type: text/csv');
            $filename = date('Ymd-h_i_s') . '.csv';

            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Output the CSV string
            echo $csvString;
        } else {
            echo "Invalid data provided.";
        }
    }


    //     if (is_array($csvData)) {
    //         // Extract values from the array
    //         $name = $results['name'];
    //         $teamName = $results['team_name'];

    //         // Create the CSV string
    //         $csvString = "Date,Name,Team Name,Project Name,Module,Task Description,Status,Hours\n";

    //         foreach ($csvData as $task) {
    //             // Extract task information from $task array
    //             $date = $task['date'];
    //             $projectName = $task['project_name'];
    //             $module = $task['module'];
    //             $taskDescription = strip_tags($task['task']);
    //             $status = $task['status'];
    //             $hours = $task['hours'];

    //             // Append the task information to the CSV string
    //             $csvString .= "$date,$name,$teamName,$projectName,$module,\"$taskDescription\",$status,$hours\n";
    //         }

    //         // Set the appropriate headers for CSV file download
    //         header('Content-Type: text/csv');
    //         header('Content-Disposition: attachment; filename="tasks.csv"');

    //         // Output the CSV string
    //         echo $csvString;
    //     } else {
    //         echo "Invalid data provided.";
    //     }
    // }

    // Extract values from the array
    // $name = $results['name'];
    // $teamName = $results['team_name'];
    // $projectName = $results['form'][0]['project_name'];
    // $module = $results['form']['module'];
    // $taskDescription = strip_tags($results['form'][0]['task']); // Strip HTML tags from the task description
    // $status = $results['form'][0]['status'];
    // $hours = $results['form'][0]['hours'];

    // // Create the CSV string
    // $csvString = "Name,Team Name,Project Name,Module,Task,Status,Hours\n";
    // $csvString .= "$name,$teamName,$projectName,$module,\"$taskDescription\",$status,$hours";

    // // Set the appropriate headers for CSV file download
    // header('Content-Type: text/csv');
    // header('Content-Disposition: attachment; filename="task.csv"');

    // // Output the CSV string
    // echo $csvString;





    // $csvData = '';
    // foreach ($data as $row) {
    //     if (is_array($row)) {
    //         $csvData .= implode(',', $row) . "\r\n";
    //     }
    // }

    // $response = Services::response();

    // // Set the appropriate headers for the CSV file download
    // $response->setHeader('Content-Type', 'text/csv');
    // $response->setHeader('Content-Disposition', 'attachment; filename="timesheet.csv"');
    // $response->setBody($csvData);

    // return $response;


    // Output the contents of the CSV file and trigger the download







    public function admin_view($date, $empId, $Id)
    {

        $timesheetModel = new TimesheetModel();

        // print_r($date);die;
        // $emp = $this->request->getVar('emp_id');
        // $date = $this->request->getVar('date');
        // print_r ($emp);echo "string";
        // print_r ($date);die;


        $timesheetModel = new TimesheetModel();
        $timesheet = $timesheetModel->distinct()
            ->select('tm.project_id, tm.id, tm.status, tm.task, tm.hours, tm.emp_id, tm.report_time, tm.module, tm.date, pl.project_id, pl.project_name,emp.name')
            ->from('timesheet_master as tm')
            ->join('employee as emp', 'tm.emp_id = emp.emp_id', 'left')
            ->join('project_list as pl', 'tm.project_id = pl.project_id', 'left')
            ->where('tm.emp_id', $empId)
            ->where('tm.date', $date)
            ->where('tm.id', $Id)
            ->findAll();

        $data['timesheet'] = $timesheet;
        return view('admin_view', $data);
    }
    public function permission_view()
    {
        $CompanyModel = new CompanyModel();

        $employees = $CompanyModel->distinct()
        ->select('emp.emp_id, emp.team_id,tt1.team_name, emp.name, emp.email, emp.password, emp.role_id, emp.status, emp.otp, emp.reset_created_at, emp.update_on, emp.first_login ,emp.access_key')
            ->from('employee as emp ')
            ->join('team_master as tt1', 'tt1.team_id = emp.team_id', 'left')
            ->where('emp.role_id', 1)
            ->where('emp.status', 1)
            ->findAll();

        $data['employees'] = $employees;

        return view('permission', $data);
    }


    // public function permission_action()
    // {


    //     print_r($_POST);die;
    //     $CompanyModel = new CompanyModel();

    //     $employees = $CompanyModel->distinct()
    //     ->select('emp.emp_id, emp.team_id,tt1.team_name, emp.name, emp.email, emp.password, emp.role_id, emp.status, emp.otp, emp.reset_created_at, emp.update_on, emp.first_login ,emp.access_key')
    //         ->from('employee as emp ')
    //         ->join('team_master as tt1', 'tt1.team_id = emp.team_id', 'left')
    //         ->where('emp.role_id', 1)
    //         ->findAll();

    //     $data['employees'] = $employees;

    //     return view('permission', $data);
    // }



    public function permission_action()
    {
        $empId = str_replace(['(', ')', "'"], '', $this->request->getPost('empId'));
        $check = $this->request->getPost('check');
        
        $CompanyModel = new CompanyModel();
        $CompanyModel->where('emp_id', $empId)->set('access_key', $check)->update();
    
        return $this->response->setJSON(['success' => true]);
    }
    
    public function permission_group()
    {

        print_r($_POST);
        $empIds = $this->request->getPost('empId');
        $check = $this->request->getPost('check');
        
        $CompanyModel = new CompanyModel();
    
        // Assuming 'access_key' is a column in the 'company' table
        foreach ($empIds as $empId) {
            $empId = str_replace(['(', ')', "'"], '', $empId);
            $CompanyModel->where('emp_id', $empId)->set('access_key', $check)->update();
        }
    
        return $this->response->setJSON(['success' => true]);
    }
    
    


    public function access_key_all()
    {
        // echo "hi";
        $empId = $this->request->getPost('emp_id');
        $check = $this->request->getPost('check');
        // print_r($empId);die;
        $CompanyModel = new CompanyModel();
    
        foreach ($empId as $empId) {
            $emp_Id = str_replace(['(', ')', "'"], '', $empId);
            $CompanyModel->where('emp_id', $emp_Id)->set('access_key' , $check)->update();
    
        }
        // print_r($Employee);die;
    
        return $this->response->setJSON(['success' => true]);
    }
    

}
