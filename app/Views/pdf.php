<!DOCTYPE html>
<html>
  <head>
    <title>Timesheet Report</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #333;
      }
      h1 {
        color: #333;
        text-align: center;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
      }
      th, td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
      }
      th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
      }
      tr:nth-child(even) {
        background-color: #f2f2f2;
      }
      button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        margin-bottom: 20px;
        cursor: pointer;
      }
      button:hover {
        background-color: #3e8e41;
      }
    </style>
  </head>
  <body>
    <h1>Timesheet Report</h1>
    <form method="post" action="<?php echo base_url('user_reports/download'); ?>">
  
    <?php

if ($download == 1 )
 {
    ?>
    
    <?php 
}
 else
  {
    ?>
    <button type="submit" class="btn btn-success float-right">Download PDF</button>
    <?php
}
?>  



<div>
         
    <label>Employee:</label>
    <?php echo ucfirst($name); ?><input type="hidden" name="name" value="<?php echo $name; ?>">
    <br>
    <label>Team:</label>
    <?php echo ucfirst($team_name); ?><input type="hidden" name="team" value="<?php echo $team_name; ?>">

</div>
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Project Name</th>
            <th>Modules</th>
            <th>Task</th>
            <th>Status</th>
            <th>Working Hours</th>
          </tr>
        </thead>
        <tbody>
          <?php  foreach ($form as $row){ ?>
          <tr>
            <td style="display:none;"><?php echo $row['emp_id']; ?><input type="hidden" name="emp_id[]" value="<?php echo $row['emp_id']; ?>"></td>
          <td><?php echo $row['date']; ?><input type="hidden" name="report_date[]" value="<?php echo $row['date']; ?>"></td>
            <td><?php echo $row['project_name']; ?><input type="hidden" name="project_name[]" value="<?php echo $row['project_name']; ?>"></td>
            <td><?php echo ucfirst($row['module']); ?><input type="hidden" name="module[]" value="<?php echo $row['module']; ?>"></td>
            <td><?php echo  htmlspecialchars_decode($row['task'], ENT_NOQUOTES); ?><input type="hidden" name="task[]" value="<?php echo   htmlspecialchars_decode($row['task'], ENT_NOQUOTES); ?>"></td>
            <td><?php echo ucfirst($row['status']); ?><input type="hidden" name="status[]" value="<?php echo $row['status']; ?>"></td>
            <td><?php echo $row['hours']; ?><input type="hidden" name="working_hours[]" value="<?php echo $row['hours']; ?>"></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
  </body>
</html>