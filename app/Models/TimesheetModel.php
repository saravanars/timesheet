<?php
namespace App\Models;

use CodeIgniter\Model;

class TimesheetModel extends Model
{
    protected $table = 'timesheet_master';
    protected $allowedFields = ['id', 'emp_id', 'report_time', 'module', 'project_id', 'task', 'status', 'hours', 'date'];



    public function getTimesheetsWithProjectNames($empid)
    {
     
        return $this->select('timesheet_master.emp_id, timesheet_master.task, timesheet_master.hours, timesheet_master.date, timesheet_master.report_time, timesheet_master.status, timesheet_master.id,project_list.project_name,tt1.team_name,timesheet_master.module')
        ->distinct()
        ->join('employee as emp1', 'emp1.emp_id = timesheet_master.emp_id')
    ->join('team_master as tt1', 'tt1.team_id = emp1.team_id')
        ->join('project_list', 'project_list.project_id = timesheet_master.project_id')
        ->where('timesheet_master.emp_id', $empid)
        ->orderBy('timesheet_master.date', 'desc')
        ->findAll();
    
    
    }
   

 



    // public function getTimesheetsProject()
    // {
     
    //     return $this->select('timesheet_master.emp_id, timesheet_master.task, timesheet_master.hours, timesheet_master.date, timesheet_master.report_time, timesheet_master.status, timesheet_master.id,project_list.project_name')
    //     ->distinct()
    //    
    //     ->orderBy('timesheet_master.date', 'desc')
    //     ->findAll();
    
    
    // }


    public function getreport()
    {

        $var =  $this->select('timesheet_master.emp_id, timesheet_master.task, timesheet_master.hours, timesheet_master.date, timesheet_master.report_time, timesheet_master.status, timesheet_master.id, project_list.project_name,team_master.team_name,employee.team_id,employee.name')
        ->distinct()
        ->join('employee', 'employee.emp_id = timesheet_master.emp_id')
        ->join('team_master', 'team_master.team_id = employee.team_id')
        ->join('project_list', 'project_list.project_id = timesheet_master.project_id')
        ->orderBy('timesheet_master.date',' employee.emp_id','desc')
        ->findAll();

      return $var;


}

public function getdata($date,$empId){
  // echo "string";exit();

  // $emp = $session->get('emp_id');
  $var = $this->select('timesheet_master.project_id,timesheet_master.emp_id,timesheet_master.task,timesheet_master.status,timesheet_master.hours,timesheet_master.date,project_list.project_name,employee.team_id,employee.name,team_master.team_name')
 ->distinct()
 ->join('employee','employee.emp_id = timesheet_master.emp_id')
 ->join('project_list ', 'project_list.project_id = timesheet_master.project_id')
 ->join('team_master','team_master.team_id = employee.team_id')
 // ->orderBy('timesheet_master.report_date')
 ->where('timesheet_master.emp_id',$empId)
->where('timesheet_master.date',$date)

 ->findAll();
//  print_r($var);
return $var;
}



public function checkTimesheetExists($empId, $date)
    {
        return $this->db->table('timesheet_master')
            ->where('emp_id', $empId)
            ->where('date', $date)
            ->countAllResults() > 0;
    }
}




    


