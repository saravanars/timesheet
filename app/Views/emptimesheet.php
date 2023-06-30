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

            #more {
                display: none;
            }



            .error-box {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffdddd;
            color: #ff0000;
            padding: 10px;
            margin-bottom: 10px;
        }

        .error-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .error-list li {
            margin-bottom: 5px;
        }
        }
    </style>
</head>

<body>
    <header>
    <?php if (session()->has('errors')) : ?>
            <div class="error-box">
                <ul class="error-list">
                    <?php foreach (session('errors') as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= $navbar ?>
        <div class="d">

            <button class="btn btn-primary table__btn" onclick="redirectToTimesheet()">
                Add timesheet
            </button>

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
                <?php $taskId = 1;
                foreach ($myemployee as  $employee_timesheets) :
                ?>
                    <tr>

                        <?php $date_formats = date('d-m-Y', strtotime($employee_timesheets['report_time']));; ?>
                        <td class="projectdate"><?= $date_formats    ?></td>
                        <td><?= $employee_timesheets['project_name'] ?></td>
                        <td><?= ucfirst($employee_timesheets['module']) ?></td>
                        <td class="task">
                            <?php
                            $task = $employee_timesheets['task'];
                            $tasks = htmlspecialchars_decode($task, ENT_NOQUOTES);
                            $tasksWithoutTags = strip_tags($tasks);         // $tasks_details = preg_split('/\s+/', $tasks);
                            $decodedTasks = html_entity_decode($tasksWithoutTags);
                            $wordCount = str_word_count($decodedTasks);

                            if ($wordCount > 10) {
                                $shortText = implode(' ', array_slice(str_word_count($decodedTasks, 1), 0, 10));
                                $remainingText = implode(' ', array_slice(str_word_count($decodedTasks, 1), 10));

                                echo $shortText;
                                echo '<span id="dots_' . $taskId . '">...</span>';
                                echo '<span id="more_' . $taskId . '" style="display:none;">' . $remainingText . '</span>';
                                echo '<button onclick="myFunction(' . $taskId . ')" id="myBtn_' . $taskId . '">Read more</button>';
                            } else {
                                echo "<span> $tasks </span>";
                            }

                            $taskId++;
                            ?>
                        </td>

                        <script>
                            var taskId = <?php echo $taskId; ?>;

                            function myFunction(taskId) {
                                var dots = document.getElementById("dots_" + taskId);
                                var moreText = document.getElementById("more_" + taskId);
                                var btnText = document.getElementById("myBtn_" + taskId);

                                if (dots.style.display === "none") {
                                    dots.style.display = "inline";
                                    btnText.innerHTML = "Read more";
                                    moreText.style.display = "none";
                                } else {
                                    dots.style.display = "none";
                                    btnText.innerHTML = "Read less";
                                    moreText.style.display = "inline";
                                }
                            }
                        </script>
                        </td>




                        <td><?= $employee_timesheets['hours'] ?></td>
                        <td><?= ucfirst($employee_timesheets['status']) ?></td>
                        <td>
                            <?php
                            if (date('Y-m-d', strtotime($employee_timesheets['report_time'])) == $today_date || $company['access_key'] == 1) {
                                echo '<button class="btn btn-primary table__btn" onclick="editTimesheet(\'' . $employee_timesheets['id'] . '\')">
                                 <i class="far fa-edit"></i>
                                   </button>';
                            } else {
                                echo '<button class="btn btn-primary table__btn" style="display: none;"></button>';
                            }

                            ?>
                            <?php
                            if (date('Y-m-d', strtotime($employee_timesheets['report_time'])) == $today_date || $company['access_key'] == 1) {
                                echo '<button class="btn btn-primary table__btn" id="deleteButton" onclick="redirectToDelete(\'' .  $employee_timesheets['id'] . '\')"> 
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
                "paging": true, // Enable pagination
                "searching": true,
                "order": false // Enable search
            });
        });

        function editTimesheet(id) {
            var id = (id);
            // var edit = 
            var url = "timesheet/edit/" + id;
            window.location.href = url;
        }

        function redirectToDelete(id) {
            var deleteConfirmed = confirm("Are you sure you want to delete today's timesheet details?");
            if (deleteConfirmed) {
                var url = "timesheet/delete/" + id;
                window.location.href = url;
            }
        }



        function redirectToTimesheet() {
            window.location.href = "<?= base_url('timesheet') ?>";
        }
    </script>
</body>

</html>