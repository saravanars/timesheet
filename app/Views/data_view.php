<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <title>My Timesheets</title>
  <style>
    *{
      font-family: 'Montserrat', sans-serif;
    }

    body {
      margin: 0;
    }



    #emp {
    padding-top: 15px;
    margin-top: 30px;
    color: #000;
    }



    div#emp_wrapper {
      color: #000;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: center;
      border-bottom: 1px solid #ddd;
      border-color: #999;
      border-width: 1px;
    }

    th {
      background-color: #f2f2f2;
    }

    .theader {
      background-color: #2596be;
      background: #2596be;
    }

    #emp thead tr th {
      background-color: #707cc0;
      color: #FFFFFF;
    }

    .table {
      width: 95%;
      margin: 0 auto;
    }

    #emp {
      padding-top: 15px;
    }

    .table__btn {
      background-color: #171717;
      border: none;
      color: #FFF;
      padding: 10px;
      border-radius: 3px;
      cursor: pointer;
    }

    /* Decrease the width of the module column */
    td.module {
      width: 15%;
    }

    /* Adjust the width of the task cell */
    td.task {
      width: 40%;
      white-space: pre-wrap;
      word-wrap: break-word;
    }

    @media only screen and (max-width: 600px) {
      table {
        width: 100%;
      }

      th, td {
        display: block;
        width: 100%;
      }

      td {
        text-align: left;
        border-bottom: none;
      }

      td:before {
        content: attr(data-label);
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 5px;
        display: block;
      }
    }
  </style>
</head>
<body>
  <header>
    <?= $navbar ?>
  </header>
  <div class="emp">
    <table id="emp" class="display">
      <thead>
        <tr>
         
          <th>Date</th>
          <th>Project</th>
          <th>Module</th>
          <th>Task</th>
          <th>Hours</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $prevDate = null; ?>
        <?php foreach ($timesheet as $row): ?>
          <tr>
            <td>
              <?php if ($row['date'] !== $prevDate): ?>
                <?= $row['date'] ?>
                <?php $prevDate = $row['date']; ?>
              <?php endif; ?>
            </td>
            <td><?= $row['project_name'] ?></td>
            <td><?= ucfirst($row['module']) ?></td>
            <td class="task"><?= ucfirst(htmlspecialchars_decode($row['task'])) ?></td>
            <td><?= $row['hours'] ?></td>
            <td><?= ucfirst($row['status']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
