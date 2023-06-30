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

    th,
    td {
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

    if ($download == 1) {
    ?>

    <?php
    } else {
    ?>
      <button type="submit" class="btn btn-success float-right">Download PDF</button>
    <?php
    }
    ?>



    <div>
      <?php
      // print_r($name);die;

      if ($emp > 0) {
        echo " <label>Employee:</label>";
        echo ucfirst($name);
      ?><input type="hidden" name="name" value="<?php echo $name; ?>">
     
      <?php } ?>
      <br>
      <?php if ($emp >0) {
        echo  "<label>Team:</label>";
        echo ucfirst($team_name);
      ?><input type="hidden" name="team" value="<?php echo $team_name; ?>">
      <?php } ?>
    </div>
    <input type="hidden" name="emp" value="<?php echo $emp; ?>">

    <table>
      <thead>
        <tr>
          <th>Date</th>
          <?php if ($emp == 0) {
            echo "<th> Name</th>";
          } ?>
          <?php if ($emp == 0) {
            echo "<th> Team name</th>";
          } ?>


          <th>Project Name</th>
          <th>Modules</th>
          <th>Task</th>
          <th>Status</th>
          <th>Working Hours</th>
        </tr>
      </thead>
      <!-- echo "<pre>"; print_r($form);die; -->
      <tbody>
        <?php   foreach ($form as $row) { ?>
          <tr>
            
            <td style="display:none;"><?php echo $row['emp_id']; ?><input type="hidden" name="emp_id[]" value="<?php echo $row['emp_id']; ?>"></td>
            <td><?php echo  $date = date('d-m-Y', strtotime($row['report_time'])); ?><input type="hidden" name="report_date[]" value="<?php echo $date = date('d-m-Y', strtotime($row['report_time'])); ?>"></td>
            
            <?php if ($emp == 0) {
        echo "<td>";
        if (isset($row['name'])) {
            echo $row['name'];
            ?><input type="hidden" name="name[]" value="<?php echo $row['name']; ?>"><?php
        }
        echo "</td>";
    } ?>

           
<?php if ($emp == 0) {
        echo "<td>";
        if (isset($row['team_name'])) {
            echo $row['team_name'];
            ?><input type="hidden" name="team[]" value="<?php echo $row['team_name']; ?>"><?php
        }
        echo "</td>";
    } ?>
           

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