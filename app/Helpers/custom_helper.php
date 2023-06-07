<?php

use App\Models\CompanyModel;
// use DateTime;
// use DateInterval;


function delete_expired_otps($email)
{
    $CompanyModel = new CompanyModel();
    $expiredTime = strtotime('-15 minutes');
    $datatime = date_default_timezone_set("Asia/Calcutta");
    $expiredDateTime = date($datatime, $expiredTime);

    $data = [
        'otp' => null,
        'otp_expire' => date('Y-m-d H:i:s')
    ];

    $CompanyModel->where('email', $email)
                 ->where('reset_created_at <', $expiredDateTime)
                 ->update($data);
}

 /**
  * Summary of update
  * @return CodeIgniter\HTTP\RedirectResponse
  */
 function update()
{
    $timesheetModel = new TimesheetModel();
    $request = service('request');
    $session = session();
    $empid = $session->get('emp_id');

    $deletedRow = $request->getVar('deleted_row');
    if (!empty($deletedRow)) {
        $deletedRows = [$deletedRow];
        $timesheetModel->whereIn('id', $deletedRows)->delete();
    }

    $date = $request->getVar('date');
    $rowIds = $request->getVar('row_id');
    if (!empty($rowIds)) {
        $timesheetModel->where('id', $rowIds)->delete();
    }

    $counter = $request->getVar('counter');

    for ($i = 1; $i <= $counter; $i++) {
      $projectId = $request->getVar('project_id_' . $i);

        $module = $request->getVar('module_' . $i);
        $status = $request->getVar('status_' . $i);
        $task = $request->getVar('task_' . $i);
        $hour = $request->getVar('hours_' . $i);

        $task = htmlspecialchars($task);
       
        $updatedData = [
            'date' => $date,
            'emp_id' => $empid,
            'project_id' => $projectId,
            'module' => $module,
            'status' => $status,
            'task' => $task,
            'hours' => $hour,
            'report_time' => date('Y-m-d H:i:s'),
        ];

        $timesheetModel->insert($updatedData);
    }


    return redirect()->to('mytimesheet');
}
// Inside the customer_helper file

// Assuming you have a function called stockinfo that requires decoding
function html_decode($data)
{
    $decodedData = [];

    foreach ($data as $item) {
        $decodedItem = htmlspecialchars_decode($item);
        // Perform other necessary operations on $decodedItem

        $decodedData[] = $decodedItem;
    }

    // Return the decoded data
    return $decodedData;
}

// Usage example
