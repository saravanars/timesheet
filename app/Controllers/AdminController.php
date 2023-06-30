<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Controllers\BaseController;
use App\Models\TimesheetModel;
use App\Models\ProjectlistModel;
use App\Models\CompanyModel;
use App\Models\Team_master;
use Dompdf\Dompdf;
use Mpdf\mPDF;
use CodeIgniter\HTTP\RequestInterface;
use Config\Services;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;





class AdminController extends BaseController
{


    protected $db;

    public function __construct()
    {

        $this->db = db_connect();
        helper('custom_helper'); // Load the otp_helper.php file
        $session = session();
        $db = \Config\Database::connect();


        // Initialize the database connection
    }
    public function index()
    {

        $session = session();

        $CompanyModel = new CompanyModel();
        $Projectmodel = new ProjectlistModel();

        $timesheetModel = new TimesheetModel();






        $timesheetModel->select('timesheet_master.report_time, pl1.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp1.name,tt1.team_name,timesheet_master.status,emp1.emp_id');
        $timesheetModel->join('project_list as pl1', 'pl1.project_id = timesheet_master.project_id');
        $timesheetModel->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id');
        $timesheetModel->join('team_master as tt1', 'tt1.team_id = emp1.team_id');
        $timesheetModel->orderBy('timesheet_master.id', 'desc');

        // print_r($timesheets);die;

        // print_r( $timesheets['row']);die;

        // $data['single_project'] = $timesheetModel->getreport();
        $data['employees_report_details'] = $timesheetModel->findAll();

        $data['data'] =  $CompanyModel->findall();

        // print_r( $timesheets['data']);die;
        $data['row'] =   $Projectmodel->orderBy('project_name', 'ASC')->where('status', 1)->findAll();
        ob_clean();
        flush();


        return view('/admin_dashboard', $data);
    }






    public function search($fromDate, $toDate, $emp, $project_name)
    {
        $request = service('request');

        $timesheetModel = new TimesheetModel();

        // print_r($emp);die;
        if (empty($fromDate && $toDate &&  $emp  && $project_name)) {
            $timesheetModel->select('timesheet_master.report_time, pl1.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp1.name,tt1.team_name,timesheet_master.status,,emp1.emp_id');
            $timesheetModel->join('project_list as pl1', 'pl1.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt1', 'tt1.team_id = emp1.team_id');
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }







        if ($fromDate && $toDate && $emp && $project_name) {

            $timesheetModel->select('timesheet_master.report_time,p5.project_name , timesheet_master.module, timesheet_master.task, timesheet_master.hours,e5.name,e5.emp_id,t5.team_name,timesheet_master.status ');
            $timesheetModel->join('project_list p5', 'p5.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee e5', 'e5.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master t5', 't5.team_id = e5.team_id');
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }


        if ($fromDate && $toDate) {
            $timesheetModel->select('timesheet_master.report_time, pl2.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp2.name,tt2.team_name,timesheet_master.status,emp2.emp_id');
            $timesheetModel->join('project_list as pl2', 'pl2.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee as emp2', 'emp2.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt2', 'tt2.team_id = emp2.team_id');
            $timesheetModel->where("DATE_FORMAT(timesheet_master.report_time, '%Y-%m-%d') >=", $fromDate)
                ->where("DATE_FORMAT(timesheet_master.report_time, '%Y-%m-%d') <=", $toDate);
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }

        if ($project_name) {
            $timesheetModel->select('timesheet_master.report_time, pl3.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp3.name,tt3.team_name,timesheet_master.status,emp3.emp_id');
            $timesheetModel->join('employee as emp3', 'emp3.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt3', 'tt3.team_id = emp3.team_id');
            $timesheetModel->join('project_list as pl3', 'pl3.project_id = timesheet_master.project_id');
            $timesheetModel->where('timesheet_master.project_id', $project_name);
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }

        // Employees
        if ($emp) {
            // echo '<pre>'.$emp;
            $timesheetModel->select('timesheet_master.report_time, pl4.project_name, timesheet_master.module, timesheet_master.task,timesheet_master.status, timesheet_master.hours,emp4.name,tt4.team_name,emp4.emp_id');
            $timesheetModel->join('employee as emp4', 'emp4.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt4', 'tt4.team_id = emp4.team_id');
            $timesheetModel->join('project_list as pl4', 'pl4.project_id = timesheet_master.project_id');
            $timesheetModel->where('timesheet_master.emp_id', $emp);
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }




        $data = $results['form'] = $timesheetModel->findAll();
        //   echo "<pre>"; print_r($data);die



        if ($emp > 0) {
            // echo "scbmns";die;
            $results['name'] = $data[0]['name'];
            $results['team_name'] = $data[0]['team_name'];
        } else {
            $names = [];
            $teamNames = [];

            foreach ($data as $request) {
                $names[] = $request['name'];
                $teamNames[] = $request['team_name'];
            }

            $results['name'] = $names;
            $results['team_name'] = $teamNames;
        }

        // $results['name'] = $data[0]['name'];
        // $results['team_name'] = $data[0]['team_name'];
        $results['emp'] = $emp;
        // print_r($results['name']);die;
        $results['download'] = 0;
        $currentMonth = date('m');
        $results['form'] = array_filter($results['form'], function ($formData) use ($currentMonth) {
            $reportDate = date('m', strtotime($formData['report_time']));
            return $reportDate === $currentMonth;
        });
        // print_r($results);die;

        return view('pdf', $results);
    }







    public function download()
    {


        //  print_r($_POST);die;
        // $employee = $this->request->getPost('name[]');
        $emp = $this->request->getPost('emp');
        //   print_r($emp);die;
        if ($emp != 0) {

            $date = $this->request->getPost('report_date[]');
            $employee = $this->request->getPost('name');
            $team_name = $this->request->getPost('team');
            $project_name = $this->request->getPost('project_name[]');
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
                    $data = $timesheetModel->where('emp_id', $empid[$i])->where('project_id', $pro_id)->where('report_time', $date[$i])->first();

                    $formData = [
                        'emp_id' => $empid[$i],
                        'report_time' => $date[$i],
                        'project_name' => $project_name[$i],
                        'task' => htmlspecialchars_decode($task[$i], ENT_NOQUOTES),
                        'module' => $module[$i],
                        'status' => $status[$i],
                        'hours' => $working_hours[$i]
                    ];
                    array_push($datas, $formData);
                }
            }

            // echo '<pre>'; print_r($formData); die;
            $results['emp'] = $emp;
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


        //   echo "<pre>"; print_r($_POST);die;
        if ($emp == 0) {


            $date = $this->request->getPost('report_date[]');
            $employee = $this->request->getPost('name[]');


            $project_name = $this->request->getPost('project_name[]');
            $team_name = $this->request->getPost('team[]');

            $module = $this->request->getPost('module[]');

            $task = $this->request->getPost('task[]');
            $tasks = array_map('html_entity_decode', $task);

            $empid = $this->request->getPost('emp_id[]');
            // print_r($empid);die;
            $status = $this->request->getPost('status[]');
            $working_hours = $this->request->getPost('working_hours[]');
            // print_r($date);exit();

            $datas = [];
            $data = array();
            if (isset($project_name) && is_array($project_name)) {
                $master = count($project_name);

                for ($i = 0; $i < $master; $i++) {
                    $Project_model = new ProjectlistModel();
                    $timesheetModel = new TimesheetModel();

                    // Get the project_id from the Project_model based on the project_name
                    $project = $Project_model->where('project_name', $project_name[$i])->first();
                    $pro_id = $project['project_id'];

                    // Fetch the data from the timesheetModel
                    $data = $timesheetModel->where('emp_id', $empid[$i])->where('project_id', $pro_id)->where('report_time', $date[$i])->first();

                    // Create the form data array
                    $formData = [
                        'emp_id' => $empid[$i],
                        'name' => $employee[$i],
                        'team_name' => $team_name[$i],
                        'report_time' => $date[$i],
                        'project_name' => $project_name[$i],
                        'task' => htmlspecialchars_decode($task[$i], ENT_NOQUOTES),
                        'module' => $module[$i],
                        'status' => $status[$i],
                        'hours' => $working_hours[$i]
                    ];

                    array_push($datas, $formData);
                }
            }

            // Prepare the data for the view
            $results['emp'] = $emp;
            $results['form'] = $datas;
            $results['download'] = 1;

            $html = view('pdf', $results);
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $filename = date('Ymd-h_i_s') . '.pdf';
            $dompdf->render();

            // Set the appropriate headers for PDF download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo $dompdf->output();
        }
    }




    public function csv($fromDate, $toDate, $emp, $project_name)
    {
        $request = service('request');
        // print_r($fromDate);
        // print_r($toDate);die;

        $timesheetModel = new TimesheetModel();


        if (empty($fromDate && $toDate &&  $emp  && $project_name)) {
            $timesheetModel->select('timesheet_master.report_time, pl1.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp1.name,tt1.team_name,timesheet_master.status,emp1.emp_id');
            $timesheetModel->join('project_list as pl1', 'pl1.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt1', 'tt1.team_id = emp1.team_id');
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }

        if ($fromDate && $toDate) {
            $timesheetModel->select('timesheet_master.report_time, pl2.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp2.name,tt2.team_name,timesheet_master.status,emp2.emp_id');
            $timesheetModel->join('project_list as pl2', 'pl2.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee as emp2', 'emp2.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt2', 'tt2.team_id = emp2.team_id');
            $timesheetModel->where("DATE_FORMAT(timesheet_master.report_time, '%Y-%m-%d') >=", $fromDate)
                ->where("DATE_FORMAT(timesheet_master.report_time, '%Y-%m-%d') <=", $toDate);
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');


            //    print_r($fromDate);die;
        }
        if ($project_name) {
            $timesheetModel->select('timesheet_master.report_time, pl3.project_name, timesheet_master.module, timesheet_master.task, timesheet_master.hours,emp3.name,tt3.team_name,timesheet_master.status,emp3.emp_id');
            $timesheetModel->join('employee as emp3', 'emp3.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt3', 'tt3.team_id = emp3.team_id');
            $timesheetModel->join('project_list as pl3', 'pl3.project_id = timesheet_master.project_id');
            $timesheetModel->where('timesheet_master.project_id', $project_name);
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }

        // Employees
        if ($emp) {
            // echo '<pre>'.$emp;
            $timesheetModel->select('timesheet_master.report_time, pl4.project_name, timesheet_master.module, timesheet_master.task,timesheet_master.status, timesheet_master.hours,emp4.name,tt4.team_name,emp4.emp_id');
            $timesheetModel->join('employee as emp4', 'emp4.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master as tt4', 'tt4.team_id = emp4.team_id');
            $timesheetModel->join('project_list as pl4', 'pl4.project_id = timesheet_master.project_id');
            $timesheetModel->where('timesheet_master.emp_id', $emp);
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }



        if ($fromDate && $toDate && $emp && $project_name) {
            $timesheetModel->select('timesheet_master.report_time,p5.project_name , timesheet_master.module, timesheet_master.task, timesheet_master.hours,e5.name,e5.emp_id,t5.team_name,timesheet_master.status ');
            $timesheetModel->join('project_list p5', 'p5.project_id = timesheet_master.project_id');
            $timesheetModel->join('employee e5', 'e5.emp_id = timesheet_master.emp_id');
            $timesheetModel->join('team_master t5', 't5.team_id = e5.team_id');
            $timesheetModel->orderBy('timesheet_master.report_time', 'ASC');
        }

        $data = $results['form'] = $timesheetModel->findAll();
        // print_r($data);die;
        //echo $timesheetModel->getLastQuery()->getQuery();
        //    die;

        if ($emp > 0) {
            // echo "scbmns";die;
            $results['name'] = $data[0]['name'];
            $results['team_name'] = $data[0]['team_name'];
        } else {
            $names = [];
            $teamNames = [];

            foreach ($data as $request) {
                $names[] = $request['name'];
                $teamNames[] = $request['team_name'];
            }

            $results['name'] = $names;
            $results['team_name'] = $teamNames;
        }

        // $results['name'] = $data[0]['name'];
        // $results['team_name'] = $data[0]['team_name'];
        $results['emp'] = $emp;

        $results['download'] = " ";
        $currentMonth = date('m');
        $results['form'] = array_filter($results['form'], function ($formData) use ($currentMonth) {
            $reportDate = date('m', strtotime($formData['report_time']));
            return $reportDate === $currentMonth;
        });
        return view('csv', $results);
    }



    public function download_csv()
    {
        // $emp = $this->request->getPost('emp');


        $emp = $this->request->getPost('emp');

        // print_r($_POST);die;
        if ($emp != 0) {
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
            array_push($data);
            $csvData = array(); // Use a different variable to store the CSV data
            for ($i = 0; $i < $master; $i++) {

                $csv_data = [
                    'emp_id' => $empid[$i],
                    // 'name'=>$employee[$i],
                    'report_time' => $Date[$i],
                    'project_name' => $Project_name[$i],
                    'module' => $Module[$i],
                    'task' => htmlspecialchars_decode($task[$i], ENT_NOQUOTES),
                    'status' => $status[$i],

                    'hours' => $Working_hours[$i]
                ];

                array_push($csvData, $csv_data); // Store the CSV data in the $csvData array
                $results['emp'] = $data;
                $results['form'] = $data;
                $results['name'] = $employee;
                $results['Team_name'] = $employee;
                $results['download'] = 1;
            }

            $spreadsheet = new Spreadsheet();
            $templateFile = 'app\assets\admin\excel_format.xlsx';
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($templateFile);

            /** Create a new Reader object of the identified input file type **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $worksheet = $spreadsheet->getActiveSheet();

            // Modify the contents of the worksheet based on $csvData
            if (is_array($csvData)) {
                // Set the header row
                $worksheet->setCellValue('A1', 'Date');
                $worksheet->setCellValue('B1', 'Name');
                $worksheet->setCellValue('C1', 'Team Name');
                $worksheet->setCellValue('D1', 'Project Name');
                $worksheet->setCellValue('E1', 'Module');
                $worksheet->setCellValue('F1', 'Project Details');
                $worksheet->setCellValue('G1', 'Status');
                $worksheet->setCellValue('H1', 'Hours');
                $headingStyle = $worksheet->getStyle('A1:H1');
                $headingStyle->getFont()->setSize(14);
                // Set the data rows
                $row = 2;
                foreach ($csvData as $task) {
                    $date = date('d-m-Y', strtotime($task['report_time']));;

                    $projectName = $task['project_name'];
                    // $employee = $task['name'];
                    // $team_name = $task['team_name'];
                    $module = $task['module'];
                    $tasks = strip_tags($task['task']);
                    $status = $task['status'];
                    $hours = $task['hours'];

                    $worksheet->setCellValue('A' . $row, $date);
                    $worksheet->setCellValue('B' . $row, $employee);
                    $worksheet->setCellValue('C' . $row, $team_name);
                    $worksheet->setCellValue('D' . $row, $projectName);
                    $worksheet->setCellValue('E' . $row, $module);
                    $worksheet->setCellValue('F' . $row, $tasks);
                    $worksheet->setCellValue('G' . $row, $status);
                    $worksheet->setCellValue('H' . $row, $hours);

                    foreach (range('A', 'H') as $column) {
                        $worksheet->getColumnDimension($column)->setAutoSize(true);
                        $worksheet->getStyle($column)->getFont()->setSize(10);
                    }

                    // Adjust row height based on content size
                    $rowDimension = $worksheet->getRowDimension($row);
                    $rowDimension->setRowHeight(-1);
                    $row++;
                    $cell = $worksheet->getCell('F' . $row);
                    $cell->getStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                }





                ob_end_clean();

                $writer = new Xlsx($spreadsheet);


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . date('Ymd-h_i_s') . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
                exit;
            } else {
                echo "Invalid data provided.";
            }
        }

        if ($emp == 0) {

            // echo "<pre>"; "hjhk";die; 
            $Date = $this->request->getPost('report_date[]');
            $employee = $this->request->getPost('name[]');
            $Project_name = $this->request->getPost('project_name[]');
            $team_name = $this->request->getPost('team[]');
            $Module = $this->request->getPost('module[]');
            $task = $this->request->getPost('task[]');
            // print_r($task); die;
            $empid = $this->request->getPost('emp_id[]');
            $status = $this->request->getPost('status[]');

            $Working_hours = $this->request->getPost('working_hours[]');
            $data = array();
            $master = count($Project_name);
            array_push($data);
            $csvData = array();
            for ($i = 0; $i < $master; $i++) {
                $csv_data = [
                    'emp_id' => $empid[$i],
                    'name' => $employee[$i],
                    'team_name' => $team_name[$i],
                    'report_time' => $Date[$i],
                    'project_name' => $Project_name[$i],
                    'module' => $Module[$i],
                    'task' => htmlspecialchars_decode($task[$i], ENT_NOQUOTES),
                    'status' => $status[$i],

                    'hours' => $Working_hours[$i]
                ];

                array_push($csvData, $csv_data); // Store the CSV data in the $csvData array
                $results['emp'] = $data;
                $results['form'] = $data;
                // $results['name'] = $employee;
                $results['download'] = 1;
                // $results['team_name'] = $team_name;
            }
            // print_r($results);die;
            // print_r($csvData);die;


            // $spreadsheet = new Spreadsheet();
            $spreadsheet = new Spreadsheet();
            $templateFile = 'app\assets\admin\excel_format.xlsx';
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($templateFile);

            /** Create a new Reader object of the identified input file type **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            // Get the active worksheet
            $worksheet = $spreadsheet->getActiveSheet();

            // Modify the contents of the worksheet based on $csvData
            if (is_array($csvData)) {
                // Set the header row
                $worksheet->setCellValue('A1', 'Date');
                $worksheet->setCellValue('B1', 'Name');
                $worksheet->setCellValue('C1', 'Team Name');
                $worksheet->setCellValue('D1', 'Project Name');
                $worksheet->setCellValue('E1', 'Module');
                $worksheet->setCellValue('F1', 'Project Details');
                $worksheet->setCellValue('G1', 'Status');
                $worksheet->setCellValue('H1', 'Hours');
                $headingStyle = $worksheet->getStyle('A1:H1');
                $headingStyle->getFont()->setSize(14);
                // Set the data rows
                $row = 2;
                foreach ($csvData as $task) {
                    $date = date('d-m-Y', strtotime($task['report_time']));;
                    $projectName = $task['project_name'];
                    $employee = $task['name'];
                    $team_name = $task['team_name'];
                    $module = $task['module'];
                    $tasks = strip_tags($task['task']);
                    $status = $task['status'];
                    $hours = $task['hours'];

                    $worksheet->setCellValue('A' . $row, $date);
                    $worksheet->setCellValue('B' . $row, $employee);
                    $worksheet->setCellValue('C' . $row, $team_name);
                    $worksheet->setCellValue('D' . $row, $projectName);
                    $worksheet->setCellValue('E' . $row, $module);
                    $worksheet->setCellValue('F' . $row, $tasks);
                    $worksheet->setCellValue('G' . $row, $status);
                    $worksheet->setCellValue('H' . $row, $hours);


                    foreach (range('A', 'H') as $column) {
                        $worksheet->getColumnDimension($column)->setAutoSize(true);
                        $worksheet->getStyle($column)->getAlignment()->setWrapText(true);
                        $worksheet->getStyle($column)->getFont()->setSize(10);
                    }

                    // Adjust row height based on content size
                    $rowDimension = $worksheet->getRowDimension($row);
                    $rowDimension->setRowHeight(-1);
                    $row++;

                    $cell = $worksheet->getCell('F' . $row);
                    $cell->getStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                }


                ob_end_clean();

                $writer = new Xlsx($spreadsheet);


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . date('Ymd-h_i_s') . '.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');
                exit;
            } else {
                echo "Invalid data provided.";
            }
        }
    }









    public function yesterday_reports()
    {
        //    " yesterday_reports"



        // $request = service('GET');
        //         print_r($_GET);
        // die;



        date_default_timezone_set('Asia/Kolkata');

        $current_time = date('d-m-Y ');
        $yesterday = $_GET['yesterday'];
        // print_r($yesterday);die;
        $timesheetModel = new TimesheetModel();

        $currentDate = date('Y-m-d');
        $previousDate = date('Y-m-d', strtotime('-1 day'));

        // print_r($currentDate);
        //    print_r($previousDate);die;
        // print_r($yesterday);die;
        if ($yesterday == '1') {


            if ($previousDate) {

                $db = \Config\Database::connect();  // Connect to the database

                $db->query("SET @row_number = 0");
                $query = $db->query("
                SELECT (@row_number:=@row_number + 1) as row_number, emp_id, name, COALESCE(total_hours, 0) as total_hours
                FROM (
                    SELECT e.emp_id, e.name, ROUND(SUM(tm.hours)) AS total_hours
                    FROM employee e
                    LEFT JOIN timesheet_master tm ON e.emp_id = tm.emp_id
                    WHERE DATE_FORMAT(tm.report_time, '%Y-%m-%d') = ?
                    GROUP BY e.emp_id, e.name
                ) AS subquery
                UNION
                SELECT (@row_number:=@row_number + 1) as row_number, emp_id, name, 0 as total_hours
                FROM employee
                WHERE emp_id NOT IN (
                    SELECT DISTINCT emp_id
                    FROM timesheet_master
                    WHERE DATE_FORMAT(report_time, '%Y-%m-%d') = ?
                )
                ORDER BY row_number
            ", [$previousDate, $previousDate]);

                $result = $query->getResult();

                // $lastQuery = $db->getLastQuery();
                // echo $lastQuery;





                $tableHTML = '<style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
            </style>';


                // $tableHTML .= '<h3>' .  $current_time . 'Mail  sented time - Employee Working Hours Report</h3>';
                $tableHTML .= '<h3>Reports  on: ' . $previousDate . '</h3>';
                $tableHTML .= '<table  style="border: 1px solid black; margin-left: auto; margin-right: auto;    width: 100%; ">';
                $tableHTML .= '<thead>';
                $tableHTML .= '<tr>';
                $tableHTML .= '<th style="border: 1px solid black; text-align: center;">SNo</th>';
                $tableHTML .= '<th style="border: 1px solid black; text-align: center;">Name</th>';
                $tableHTML .= '<th style="border: 1px solid black; text-align: center;">Total Hours</th>';
                $tableHTML .= '</tr>';
                $tableHTML .= '</thead>';
                $tableHTML .= '<tbody>';

                foreach ($result as $row) {
                    $tableHTML .= '<tr>';
                    $tableHTML .= '<td style="border: 1px solid black; text-align: center;">' . $row->row_number . '</td>';
                    $tableHTML .= '<td style="border: 1px solid black; text-align: center;">' . $row->name . '</td>';
                    $tableHTML .= '<td style="border: 1px solid black; text-align: center;">' . $row->total_hours . '</td>';
                    $tableHTML .= '</tr>';
                }

                $tableHTML .= '</tbody>';
                $tableHTML .= '</table>';


                $email = \config\services::email();
                $email->setTo('saravanakumar_r@itflexsolutions.com');
                $email->setFrom('saravanakumar_r@itflexsolutions.com', 'itflex');
                $email->setSubject($previousDate . '- Daily Timesheets: Working Hours Reports ');
                $email->setMessage('<html>
                <head>
                    <style>
                        .mail_header {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                        }
            
                        .date_time {
                            font-weight: 700;
                        }
                    </style>
                </head>
                <body>
                    <div class="mail_header">
                        <h3>Hi HR team,</h3>
                      
                       
                        </div>
                    <p>Please find below  Our Daily Timesheets report for employee working hours on: ' . $previousDate . '.</p>' . $tableHTML . '<p> <br>  Thanks & Regards  <br> ITF Teams.</p>
                </body>
            </html>');

                // $email->send();

                if ($email->send()) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Email sent successfully.'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to send email.'
                    ];
                }

                echo json_encode($response);
            }
        }
    }






    public function below_hours()
    {
                          

        $yesterday = $_GET['yesterday'];
        if ($yesterday == 2) {
            $currentDate = date('Y-m-d');
            $previousDate = date('Y-m-d', strtotime('-1 day'));
            $db = \Config\Database::connect();

            $query = "SELECT `emp_id`, `team_id`, `name`, `email`, `reset_created_at`, `role_id` FROM `employee` WHERE `role_id` = 1";
            $employee = $db->query($query);
            $employee = $employee->getResultArray();
           $emailService = \Config\Services::email();

            //    $i=1;
            foreach ($employee as $row) {

                $email_id = $row['email'];
                // echo   $email_id;
                $emp_id = $row['emp_id'];

                $name = $row['name'];
                $previousDate = date('Y-m-d', strtotime('-1 day'));

                $query1 = "SELECT p.project_name, t.module, t.task, t.hours ,t.report_time
                           FROM timesheet_master t
                           LEFT JOIN project_list p ON t.project_id = p.project_id
                           WHERE t.emp_id = $emp_id AND DATE(t.report_time) ='" . $previousDate . "'";

                $result1 = $db->query($query1);
                $timesheetResult = $result1->getResultArray();

                $totalHours = 0;
                foreach ($timesheetResult as $row) {
                    $totalHours += $row['hours'];
                }


                // Create the table format for the email
                $table = "<table  style='border: 1px solid black; margin-left: auto; margin-right: auto;    width: 100%;'>
                            <thead>
                                <tr>
                                   <th style='border: 1px solid black; text-align: center;'> SNO</th>
                                    <th style='border: 1px solid black; text-align: center;'>Project Name</th>
                                    <th style='border: 1px solid black; text-align: center;'>Module</th>
                                    <th style='border: 1px solid black; text-align: center;'>Task</th>
                                    <th style='border: 1px solid black; text-align: center;'>Hours</th>
                                </tr>
                            </thead>
                            <tbody>";


                $counter = 1;
                foreach ($timesheetResult as $timeRow) {
                    $projectName = $timeRow['project_name'];
                    $module = $timeRow['module'];
                    $task = html_entity_decode($timeRow['task']);
                    $hours = $timeRow['hours'];

                    // Add a new row to the table for each timesheet entry
                    $table .= "<tr>
                                    <td style='border: 1px solid black; text-align: center;'>$counter</td>
                                    <td style='border: 1px solid black; text-align: center;'>$projectName</td>
                                    <td style='border: 1px solid black; text-align: center;'>$module</td>
                                    <td style='border: 1px solid black; text-align: center;'>$task</td>
                                    <td style='border: 1px solid black; text-align: center;'>$hours</td>
                                </tr>";
                                $counter++;
                }


                $table .= "</tbody></table>";

                

                $emailService->setFrom('saravanakumar_r@itflexsolutions.com', 'itflex');
                $emailService->setTo($email_id);
                $emailService->setSubject("Daily Timesheet Report: $previousDate");
                $message = "
            <html>
            <body>
                <div style='font-family: Arial, sans-serif;'>
                    <h3>Hi ".$name.",</h3>
                    <p>This is the daily report of your Timesheet</p>
                    <h4>Date: $previousDate</h4>
                    <h4>Total hours: $totalHours</h4>
                    $table
                     <br>
                    <p style='font-size: 14px;'>Thanks & regards,</p>
                    <p style='font-size: 14px;'>ITF Teams</p>
                </div>
            </body>
            </html>
            ";

                $emailService->setMessage($message);
                $emailService->send();
            }
        }







        // $yesterday = $_GET['yesterday'];
        // // $timesheetModel = new TimesheetModel();
    
        //     if ($yesterday == 2) {
        //         $currentDate = date('Y-m-d');
        //         $previousDate = date('Y-m-d', strtotime('-1 day'));
    
        //         // Get database connection
        //         $db = \Config\Database::connect();
    
        //         // Build the query to fetch the employees with total_hours = 0
        //         $query = "
        //             SELECT e.emp_id, e.name, e.email, 0 AS total_hours
        //             FROM employee e
        //             WHERE e.emp_id NOT IN (
        //                 SELECT DISTINCT t.emp_id
        //                 FROM timesheet_master t
        //                 WHERE DATE_FORMAT(t.report_time, '%Y-%m-%d') = ?
        //             )";
    
        //         // Execute the query with the previous date parameter
        //         $result = $db->query($query, [$previousDate]);
    
        //         // Check for query execution errors
    
        //         // Fetch the employee results
        //         $data = [];
        //         foreach ($result->getResultArray() as $row) {
        //             $emp_id = $row['emp_id'];
        //             $name = $row['name'];
        //             $email = $row['email'];
        //             $total_hours = $row['total_hours'];
    
        //             $data[$emp_id] = [
        //                 'name' => $name,
        //                 'email' => $email,
        //                 'total_hours' => $total_hours,
        //             ];
        //         }
    
        //         // Send email to employees with total_hours = 0
        //         $emailService = \Config\Services::email();
        //         $emailService->setFrom('saravanakumar_r@itflexsolutions.com', 'itflex');
        //         $emailService->setSubject('Daily Working Hours Notification - ' . $previousDate);
    
        //         foreach ($data as $emp_id => $employee) {
        //             $name = $employee['name'];
        //             $email = $employee['email'];
        //             $total_hours = $employee['total_hours'];
    
        //             // No timesheets available
        //             $message = "Hi $name,
    
        // There are no timesheets updated for you on $previousDate.
    
        // Please ensure to submit your timesheets regularly.
    
        // Thanks & Regards,
        // ITF Teams.";
    
        //             $emailService->setTo($email);
        //             $emailService->setMessage($message);
    
        //             if ($emailService->send()) {
        //                 echo "Email sent successfully to $email";
        //             } else {
        //                 echo $emailService->printDebugger(['headers']);
        //             }
        //         }
        //     }
        // }



    }

    // $lastQuery = $db->getLastQuery();
    // echo $lastQuery;die;










  






    public function project_add_page()
    {

        $projectModel = new ProjectlistModel();
        $data['projects_name'] = $projectModel->orderBy('project_id', 'ASC')->findAll();

        // $data['date'] = $date;

        return view("project_add", $data);
    }


    public function project_adding()
    {
        $request = service('request');
        $projectModel = new ProjectlistModel();
        $project = $request->getPost('project');
        $status = 1;

        // Check if project with the same name already exists
        $existingProject = $projectModel->where('project_name', strtoupper($project))->first();
        if ($existingProject) {
            $response = array(
                'status' => 'error',
                'message' => 'Project with the same name already exists.'
            );
            echo json_encode($response);
            return; // Stop execution
        }

        $data = array(
            'project_name' => strtoupper($project),
            'status' => $status
        );

        $projectModel->insert($data);

        $response = array(
            'status' => 'success',
            'message' => 'Project inserted successfully.'
        );
        echo json_encode($response);
    }


    public function get_project_data()
    {
        // Get the project ID from the AJAX request
        $projectId = $this->request->getPost('project_id');

        // Create an instance of the ProjectModel or replace it with your own model
        $projectModel = new ProjectlistModel();
        $projectData = $projectModel->where('project_id', $projectId)->findAll();

        // Check if any project data was found
        if (!empty($projectData)) {
            // Assuming there's only one row for the project ID, you can directly access it
            $row = $projectData[0];
            // print_r($row);die;
            // Retrieve the project name from the row
            $projectName = $row['project_name'];
            $project_id = $row['project_id'];
            // print_r($project_id);die;
            $project = strtoupper($projectName);
            $response = [
                'project_name' => $project,
                'project_id' => $project_id
            ];

            // print_r($response);
            // die;
            // print_r($response);die;
            return $this->response->setJSON($response);
        } else {
            // If no project data was found, return an appropriate response
            return $this->response->setJSON(['error' => 'Project not found']);
        }
    }


    public function update_project_name()
    {

        $request = service('request');
        $projectId = $request->getPost('project_id');
        $projectName = $request->getPost('project_name');
        $project = strtoupper($projectName);
        // Create an instance of the ProjectModel or replace it with your own model
        $projectModel = new ProjectlistModel();


        $projectModel->where('project_id', $projectId)->set('project_name', $project)->update();
        // print_r($projectModel);die;
        // Return a response indicating the success of the update
        return $this->response->setJSON(['success' => true]);
    }













    public function project_active()
    {


        // print_r($_POST);die;
        $empId = str_replace(['(', ')', "'"], '', $this->request->getPost('empId'));
        $check = $this->request->getPost('check');

        $projectModel = new ProjectlistModel();
        $projectModel->where('project_id', $empId)->set('status', $check)->update();

        return $this->response->setJSON(['success' => true]);
    }




    public function  employee_active()
    {


        // print_r($_POST);die;
        $empId = str_replace(['(', ')', "'"], '', $this->request->getPost('empId'));
        $check = $this->request->getPost('check');

        $CompanyModel = new CompanyModel();
        $CompanyModel->where('emp_id', $empId)->set('status', $check)->update();

        return $this->response->setJSON(['success' => true]);
    }


    public  function employees_page()
    {

        $session = session();
        $CompanyModel = new CompanyModel();

        $employees = $CompanyModel->distinct()
            ->select('emp.emp_id, emp.team_id,tt1.team_name, emp.name, emp.email, emp.password, emp.role_id, emp.status, emp.otp, emp.reset_created_at, emp.update_on, emp.first_login ,emp.access_key')
            ->from('employee as emp ')
            ->join('team_master as tt1', 'tt1.team_id = emp.team_id', 'left')
            ->where('emp.role_id', 1)
            // ->where('emp.status', 1)
            ->orderby('emp.emp_id', 'desc')
            ->findAll();

        $team_master = new Team_master();
        // print_r(count($team_master->getTeamMaster()));die;

        // $team_master = new Team_master()
        $data['team_master'] = $team_master->orderBy('team_id', 'ASC')->where('status', 1)->findAll();

        $data['employees'] = $employees;
        return view('employees_adding', array_merge($data, ['session' => $session]));
    }

    public function employees_adding()
    {


        $session = session();
        $CompanyModel = new CompanyModel();

        // Retrieve the submitted form data
        $employee_name = $this->request->getPost('employee_name');
        $name = ucfirst($employee_name);
        $team_id = $this->request->getPost('team_id');
        $employee_email = $this->request->getPost('employee_email');
        $role_id = $this->request->getPost('role_id');

        // Validate the form data (e.g., check for required fields, validate email, etc.)
        // ...

        $status = 1;
        $first_login = 1;
        $password = "123456";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Perform the database insertion
        $insert_data = [
            'name' =>  $name,
            'team_id' => $team_id,
            'email' => $employee_email,
            'role_id' => $role_id,
            'status' => $status,
            "password"   =>  $hashed_password,
            "first_login" => $first_login
        ];
        // print_r($insert_data);die;
        $CompanyModel->insert($insert_data);

        if ($CompanyModel->affectedRows() > 0) {
            // Insertion successful, set a success session message
            $session->setFlashdata('successful', 'Employee added successfully.');
        } else {
            // Insertion failed, set an error session message
            $session->setFlashdata('error_message', 'Failed to add employee.');
        }

        // Redirect to the "add_employees" page

        // Redirect to a relevant page or show a view
        return redirect()->to('add_employees', 302);
    }





    public function edit($emp_id)
    {
        $CompanyModel = new CompanyModel();

        $employees = $CompanyModel->distinct()
            ->select('emp.emp_id, emp.team_id,tt1.team_name, emp.name, emp.email, emp.password, emp.role_id, emp.status, emp.otp, emp.reset_created_at, emp.update_on, emp.first_login ,emp.access_key')
            ->from('employee as emp ')
            ->join('team_master as tt1', 'tt1.team_id = emp.team_id', 'left')
            ->where('emp.role_id', 1)
            ->where('emp.status', 1)
            ->where('emp.emp_id', $emp_id)
            ->findAll();

        $team_master = new Team_master();
        // print_r(count($team_master->getTeamMaster()));die;

        // $team_master = new Team_master()
        $data['team_master'] = $team_master->orderBy('team_id', 'ASC')->where('status', 1)->findAll();

        $data['employees'] = $employees;



        return view('employees_edit', $data);
    }






    public function update_employees()
    {

        $request = service('request');
        $session = session();
        $emp_id = $this->request->getPost('emp_id');
        $employee_name = $this->request->getPost('employee_name');
        $team_id = $this->request->getPost('team_id');
        $employee_email = $this->request->getPost('employee_email');
        $role_id = $this->request->getPost('role_id');

        // Perform the update operation using the employee ID
        $updateData = [
            'name' => $employee_name,
            'team_id' => $team_id,
            'email' => $employee_email,
            'role_id' => $role_id
            // Add other fields to be updated if needed
        ];


        $CompanyModel = new CompanyModel();



        $CompanyModel->where('emp_id', $emp_id)->set($updateData)->update();


        if ($CompanyModel->affectedRows() > 0) {
            // Insertion successful, set a success session message
            $session->setFlashdata('successful to update employee.');
        } else {
            // Insertion failed, set an error session message
            $session->setFlashdata('Failed to update employee.');
        }

        return redirect()->to('add_employees');
    }




    public function admin_view($date, $empId, $Id)
    {

        $timesheetModel = new TimesheetModel();



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

        // print_r($_POST);
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
            $CompanyModel->where('emp_id', $emp_Id)->set('access_key', $check)->update();
        }
        // print_r($Employee);die;

        return $this->response->setJSON(['success' => true]);
    }
}
