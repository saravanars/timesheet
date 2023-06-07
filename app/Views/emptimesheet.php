
<!DOCTYPE html>
<html>

<head>
    <title>My Timesheets</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <style>



        /* Styles for the table */
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
        }

        .d {
            margin-top: 7px;
            margin-left: 60rem;
            position: absolute;
        }

        div#emp_wrapper {
            margin-top: 55px;
        }

        div#emp_wrapper {
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
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

        .dataTables_filter input {
            background-color: #FFF !important;
            border: none !important;
        }

        .dataTables_length select {
            background-color: #FFF !important;
            border: none !important;
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

        @media only screen and (max-width: 600px) {
            table {
                width: 100%;
            }

            th,
            td {
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
        <div class="d">





        <?php $report_date = date("Y-m-d");?>
     
          <?php 
          if($single_project[0]['date']== ($report_date))
          {

            ?>
                       <button class="btn btn-primary table__btn">
                Already  Added Timesheet
            </button>

        <?php }
          else
          {
           ?>
                     <button class="btn btn-primary table__btn" onclick="redirectToTimesheet()">
                Add timesheet
            </button>



         <?php }
         ?>












            <!-- <button class="btn btn-primary table__btn" onclick="redirectToTimesheet()">
                Add timesheet
            </button> -->
        </div>
    </header>
    <div class="table">
        <table id="emp" class="display">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Project</th>
                    <th>Module</th>
                    <th>Task</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($single_project as $project) : ?>
                    <tr>
                        <?php  $formatdate = date("d-m-Y", strtotime($project['date'] )); ?>
                        <td class="projectdate"><?= $formatdate    ?></td>
                        <td><?= $project['project_name'] ?></td>
                        <td><?= ucfirst($project['module']) ?></td>
                        <td class="task"><?= ucfirst(htmlspecialchars_decode($project['task'])) ?></td>
                        <td><?= $project['hours'] ?></td>
                        <td><?= ucfirst($project['status']) ?></td>
                        <td>              
                        <?php 
if ($project['date'] == $today_date || $company['access_key'] == 1) {
    echo '<button class="btn btn-primary table__btn" onclick="editTimesheet(\'' . $project['date'] . '\')">
        <i class="far fa-edit"></i>
    </button>';
    
} else {
    echo '<button class="btn btn-primary table__btn" style="display: none;"></button>';
}

?>
<?php
if ($project['date'] == $today_date || $company['access_key'] == 1) {
    echo '<button class="btn btn-primary table__btn" id="deleteButton" onclick="redirectToDelete(\'' . $project['id'] . '\')"> 
        <i class="far fa-trash-alt"></i>
    </button>';
} else {
    echo '<button class="btn btn-primary table__btn" style="display: none;"></button>';
}
?>
                         
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#emp').DataTable({
                order: 
          [0, 'desc'],
                "paging": true, // Enable pagination
                "searching": true // Enable search
            });
        });

        function editTimesheet(date) {
            var today = new Date(date);
            var url = "timesheet/edit/" + today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
            window.location.href = url;
        }

        function redirectToDelete(id) {
            var deleteConfirmed = confirm("Are you sure you want to delete today's timesheet details?");
            if (deleteConfirmed) {
                var url = "timesheet/delete/" + id;
                window.location.href = url;
            }
        }


//         function redirectToDelete(id) {
//     // Show a confirmation dialog to confirm the deletion
//     var deleteConfirmed = confirm("Are you sure you want to delete this timesheet entry?");

//     if (deleteConfirmed) {
//         // Send an AJAX request to the server to delete the timesheet entry
//         $.ajax({
//             url: "timesheet/delete/" + id,
//             type: "GET",
//             success: function(response) {
//                 // Handle the success response here
//                 // For example, you can show a success message or reload the timesheet table
//                 console.log("Timesheet entry deleted successfully");
//                 // Reload the page or update the timesheet table
//                 location.reload();
//             },
//             error: function(xhr, status, error) {
//                 // Handle the error response here
//                 console.log("Error deleting timesheet entry: " + error);
//                 // Display an error message to the user if needed
//             }
//         });
//     }
// }

        function redirectToTimesheet() {
            window.location.href = "<?= base_url('timesheet') ?>";
        }
    </script>
</body>

</html>







