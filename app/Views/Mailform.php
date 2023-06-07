
    <script id="addChild">
        function addtinymce() {
            tinymce.init({
                selector: '.task',
                height: 250
            });
        };


        function validateEditorContent(i) {
            var editor = tinyMCE.activeEditor;
            var content = editor.getContent();

            // Check if the editor content is empty.
            if (content === '') {
                $("#taskError" + i).text('The editor content cannot be empty.');
                return false;
            }

            // Check if the editor content contains any invalid HTML.
            var isValidHTML = tinyMCE.isValid(content);
            if (!isValidHTML) {
                alert('The editor content contains invalid HTML.');
                return false;
            }

            // The editor content is valid.
            return true;
        }

        $(document).ready(function() {
            addtinymce();


            // Delete Row Button
            $(document).on('click', '.delete-btn', function() {
                var row = $(this).closest('tr');
                if (confirm("Are you sure you want to delete this row?")) {
                    row.remove();
                }
            });



            var ii = <?php echo count($timesheet); ?>; // Set initial value based on the existing rows

            $(".add-btn").click(function() {
                ++ii;
                var row = '<tr>' +
                    '<td><select name="project_id_' + ii + '" id="project_id_' + ii + '" class="form-control dynamic-row project_id_' + ii + '">' +
                    '<option value="">Select Project Name</option>' +
                    '<?php foreach ($projects_name as $row) { ?>' +
                    '<option value="<?php echo $row["project_id"]; ?>"><?php echo $row["project_name"]; ?></option>' +
                    '<?php } ?>' +
                    '</select>' +
                    '<p class="project-error red"></p>' +
                    '</td>' +
                    '<td><input type="text" id="module_" name="module_' + ii + '" class="form-control dynamic-row module" ></td>' +
                    '<td><textarea class="form-control task dynamic-row task_' + ii + '" id="task_' + ii + '" name="task_' + ii + '"></textarea><p id="taskError' + ii + '" class="error"></p></td>' +
                    '<td><select name="status_' + ii + '" id="status_' + ii + '" class="form-control dynamic-row status_' + ii + '">' +
                    '<option value="In progress">In Progress</option>' +
                    '<option value="pending">Pending</option>' +
                    '<option value="complete">Complete</option>' +
                    '</select><span id="statusError" class="error"></span></td>' +
                    '<td><input type="number" id="hours_' + ii + '" name="hours_' + ii + '" min="1" max="2" class="form-control dynamic-row hours_' + ii + '"></td>' +
                    '<td><button class="btn btn-danger delete-btn">-</button></td>' +
                    '</tr>';

                $("#table-body").append(row);
                $('#counter').val(ii);
                addtinymce();
            });




            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Add leading zero if needed
            var day = currentDate.getDate().toString().padStart(2,
                '0'); // Add leading zero if needed

            // Format the date as yyyy-MM-dd
            var formattedDate = year + '-' + month + '-' + day;

            // Set the formatted date to the date input field
            $('#datepicker').val(formattedDate);
            addtinymce();




            // Move validation and submit code inside document ready function
            //$('form#timesheet_add').validate();

            $("#submit").click(function() {
                validateEditorContent(ii);
                // ...existing code..a
                // Add validation rules for dynamically generated fields
                $('#project_id_' + ii).rules('add', {
                    required: true,
                    messages: {
                        required: 'Please select the project.',
                    },
                });
                $('#hours_' + ii).rules('add', {
                    required: true,
                    messages: {
                        required: 'Use range between 1 to 2 hour use decimal point ',
                    },
                });
                $('#task_' + ii).rules('add', {
                    required: true,
                    messages: {
                        required: 'Fill the task is required',
                    },
                });


                // Check if the content is empty




                $('#status_' + ii).rules('add', {
                    required: true,
                    messages: {
                        required: 'Select the status',
                    },
                });








            });
            $('form').validate();




             

            var formData = $('form').serialize(); // Serialize the form data
                    alert(dd);
                    $.ajax({
                        alert(ddd);
                        url: '<?= base_url('timesheet/update') ?>',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            // Handle the response from the controller
                        },
                        error: function(xhr, status, error) {
                            // Handle the error
                        }
                    });
                

            //   ..existing code...
        });
    </script>


<!DOCTYPE html>
<html>
<head>
  <title>My Timesheets</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <style>
 body {
    margin: 0;
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

        th, td {
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
  <script>
    $(document).ready(function() {
      var table = $('#emp').DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "searching": true, // Enable search bar
        "columnDefs": [{
          "orderable": false,
          "targets": [6]
        }]
      });
    });
  </script>
</head>
<body>
  <header>
    <?= $navbar ?>
  </header>
  <div class="emp">
    <table id="emp" class="display">
      <thead>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Project</th>
          <th>Module</th>
          <th>Task</th>
          <th>Hours</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($timesheet as $row): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['project_name'] ?></td>
            <td><?= $row['module'] ?></td>
            <td><?= htmlspecialchars_decode($row['task']) ?></td>
            <td><?= $row['hours'] ?></td>
            <td><?= $row['status'] ?></td>
           
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
---------------$_COOKIE
<!DOCTYPE html>
<html>

<head>
    <title>Time Sheet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/vv570pfxb8s951gnplopgsczx07c90fknwtwuyolrft4kxph/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style type="text/css">
        .add-btn {
            margin-top: 10px;
        }

        h1 {
            text-align: center;
        }

        .table {
            padding-top: 100px;
        }

        #abc,
        #val {
            text-align: center;
            color: #000;
        }

        /* .red {
            color: red;
        } */



        .error {
            color: red;
        }


        .tox-editor-container {

            height: 100px;
        }


        .container {
            margin-top: 20px;
        }


        th {
            border-radius: 12px;
            border-block-color: #000;
            color: #000;
        }
    </style>
</head>


<body>

    <?= $navbar ?>
    <div class="container">

        <form method="post" id="timesheet_add" action="<?= base_url('timesheet/update') ?>">
            <div class="container">
                <div id="val">
                    <label>Report Date</label>

                    <input type="date" id="datepicker" name="date" value="<?php echo date('Y-m-d', strtotime($newDate)); ?>">



                    <div id="abc">
                        </select>
                    </div>
                </div>
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>Project Name<span class="red">*<small></small></span></th>
                            <th>Module</th>
                            <th>Task<span class="red">*<small></small></span></th>
                            <th>Status<span class="red"><small></small></span></th>
                            <th>Hours<span class="red">*<small></small></span></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php if ($timesheet !== null) :
                            $i = 1;
                            foreach ($timesheet as $index => $entry) :
                        ?>
                                <tr>
                                    <td>
                                        <select name="project_id_<?= $i ?>" class="form-control project_id_">
                                            <?php foreach ($projects_name as $row) : ?>
                                                <option value="<?= $row['project_id'] ?>" <?= ($row['project_id'] == $entry['project_id']) ? 'selected' : '' ?>>
                                                    <?= $row['project_name'] ?>
                                                </option>

                                            <?php endforeach; ?>

                                        </select>
                                        <span class="error"></span>
                                        <input type="hidden" name="row_id" id="row_id" value="<?= $entry['id'] ?>">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control module" name="module_<?= $i ?>" value="<?= $entry['module'] ?>">
                                    </td>
                                    <td>

                                        <textarea class="form-control task" name="task_<?= $i ?>"><?= strip_tags($entry['task']) ?></textarea>

                                        <span class="error"></span>
                                    </td>
                                    <td>
                                        <select name="status_<?= $i ?>" class="form-control status_<?= $i ?>">
                                            <option value="In progress" <?= ($entry['status'] == 'In progress') ? 'selected' : '' ?>>In Progress</option>
                                            <option value="pending" <?= ($entry['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                            <option value="completed" <?= ($entry['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                                        </select>
                                        <span class="error"></span>
                                    </td>
                                    <td>
                                        <input type="number" name="hours_<?= $i ?>" class="form-control hours_<?= $i ?>" min="1" max="2" value="<?= $entry['hours'] ?>">
                                        <span class="error"></span>
                                    </td>
                                    <td>

                                        <button type="button" class="btn btn-danger btn_delete">-</button>

                                    </td>
                                </tr>
                            <?php
                                $i++;
                            endforeach;
                            ?>
                        <?php endif; ?>

                    </tbody>
                    <input type="hidden" id="counter" name="counter" value="<?= $i ?>">
                    <input type="hidden" id="deleted_row" name="deleted_row">

                </table>

                <button type="button" class="btn btn-primary add-btn" id="btnAdd">Add Row</button>
                <button type="submit" id="submit" name="submit" class="btn btn-success">Update</button>
            </div>
        </form>

    </div>
    <script src="https://cdn.tiny.cloud/1/vv570pfxb8s951gnplopgsczx07c90fknwtwuyolrft4kxph/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script id="addChild">
        var tinyMCEInstances = [];

        function addtinymce() {
            // alert(1);
            tinymce.init({
                selector: '.task',
                height: 250
            });
        };





        function validateEditorContent(i) {

            var editor = tinyMCE.activeEditor;
            var content = editor.getContent();

            // Check if the editor content is empty.
            if (content === '') {
                $("#taskError" + i).text('The editor content cannot be empty.');
                return false;
             
            }

            // Check if the editor content contains any invalid HTML.

            // The editor content is valid.
            return true;
        }

        $(document).ready(function() {
            // console.log('Hello world!');
            //addtinymce();

            // $('#btn_delete').click(function() {
            //     $("#Table").find("tr:gt(0)").remove();
            // });
            // Delete Row Button

            $('.btn_delete').click(function() {
                var row = $(this).closest('tr');
                console.log(row);
                var vacc = $(this).closest('tr').find('td:first-child input').val();
                console.log(vacc);
                if (confirm("Are you sure you want to delete this row?") == true) {


                    row.remove('tr');
                    var deleteid = $('#deleted_row').val();
                    if (deleteid == '') var ccval = vacc;
                    else var ccval = deleteid + ',' + vacc;
                    $('#deleted_row').val(ccval);
                    console.log(ccval)
                    console.log("You pressed OK!");
                } else {


                    console.log("You canceled!");
                }

            });





            var ii = <?php echo count($timesheet); ?>; // Set initial value based on the existing rows

            $(".add-btn").click(function() {
                ++ii;
                //addtinymce();

                var row = '<tr>' +
                    '<td><select name="project_id_' + ii + '" id="project_id_' + ii + '" class="form-control dynamic-row project_id_' + ii + '">' +
                    '<option value="">Select Project Name</option>' +
                    '<?php foreach ($projects_name as $row) { ?>' +
                    '<option value="<?php echo $row["project_id"]; ?>"><?php echo $row["project_name"]; ?></option>' +
                    '<?php } ?>' +
                    '</select>' +
                    '<p class="project-error red"></p>' +
                    '</td>' +
                    '<td><input type="text" id="module_" name="module_' + ii + '" class="form-control dynamic-row module" ></td>' +
                    '<td><textarea class="form-control task dynamic-row task_' + ii + '" id="task_' + ii + '" name="task_' + ii + '"></textarea><p id="taskError' + ii + '" class="error"></p></td>' +
                    '<td><select name="status_' + ii + '" id="status_' + ii + '" class="form-control dynamic-row status_' + ii + '">' +
                    '<option value="In progress">In Progress</option>' +
                    '<option value="pending">Pending</option>' +
                    '<option value="completed">Completed</option>' +
                    '</select><span id="statusError" class="error"></span></td>' +
                    '<td><input type="number" id="hours_' + ii + '" name="hours_' + ii + '" min="1" max="2" class="form-control dynamic-row hours_' + ii + '"> <span class="error"></span></td>' +
                    '<td><button type="button" id="dele_row_' + ii + '" class="btn btn-danger btn_delete1">-</button></td>' +
                    '</tr>';


                $("#table-body").append(row);
                $('#counter').val(ii);
                // alert(8);
                addtinymce();
                // alert(7);
                //addtinymce();
                console.log(ii);
            });

            $("#table-body").on("click", ".btn_delete1", function() {
                var row = $(this).closest('tr');
                if (confirm("Are you sure you want to delete this row in add?") == true) {
                    row.remove();
                    console.log("You pressed OK!");
                } else {
                    console.log("You canceled!");
                }
            });


            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            var day = currentDate.getDate().toString().padStart(2, '0');
            var formattedDate = year + '-' + month + '-' + day;

            $('#datepicker').val(formattedDate);
            $('#datepicker').attr('min', formattedDate);
            $('#datepicker').attr('max', formattedDate);

            // Disable options for dates between 1-3
            var datePickerInput = document.getElementById('datepicker');
            datePickerInput.addEventListener('change', function() {
                var selectedDate = new Date(datePickerInput.value);
                var selectedDay = selectedDate.getDate();

                if (selectedDay >= 1 && selectedDay <= 3) {
                    datePickerInput.value = formattedDate;
                }
            });

            // Set the formatted date to the date input field
            $('#datepicker').val(formattedDate);
            addtinymce();

        

            // Initialize form validation
            // $('#timesheet_add').validate();
            console.log(ii);
            $("#submit").click(function() {
             
                for (var i = 1; i <= ii; i++) {
                    validateEditorContent(i);
                    // ...existing code...

                    // Add validation rules for dynamically generated fields
                    console.log('#project_id_' + i);
                    $('#project_id_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Please select the project.'
                        },
                    });

                    console.log('#hours_' + i);
                    $('#hours_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Use range between 1 to 2 hour use decimal point '
                        },
                    });

                    $('#task_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Fill the task is required'
                        },
                    });

                    $('#status_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Select the status'
                        },
                    });

                    var isValid = $('#timesheet_add').valid();
                    
                    if (!isValid) {
                        console.log('isValid'); 
                        return; 
                        }
                    }

                    $('#timesheet_add').submit();
            });




        });
    </script>
</body>

</html>
<script id="addChild">
        var tinyMCEInstances = [];

        function addtinymce() {
            // alert(1);
            tinymce.init({
                selector: '.task',
                height: 250
            });
        };





        function validateEditorContent(i) {

            var editor = tinyMCE.activeEditor;
            var content = editor.getContent();

            // Check if the editor content is empty.
            if (content === '') {
                $("#taskError" + i).text('The editor content cannot be empty.');
                return false;
                var isValidHTML = tinyMCE.isValid(content);
                if (!isValidHTML) {
                    alert('The editor content contains invalid HTML.');
                    return false;
                }
            }

            // Check if the editor content contains any invalid HTML.

            // The editor content is valid.
            return true;
        }

        $(document).ready(function() {
            // console.log('Hello world!');
            //addtinymce();

            // $('#btn_delete').click(function() {
            //     $("#Table").find("tr:gt(0)").remove();
            // });
            // Delete Row Button

            $('.btn_delete').click(function() {
                var row = $(this).closest('tr');
                console.log(row);
                var vacc = $(this).closest('tr').find('td:first-child input').val();
                console.log(vacc);
                if (confirm("Are you sure you want to delete this row?") == true) {


                    row.remove('tr');
                    var deleteid = $('#deleted_row').val();
                    if (deleteid == '') var ccval = vacc;
                    else var ccval = deleteid + ',' + vacc;
                    $('#deleted_row').val(ccval);
                    console.log(ccval)
                    console.log("You pressed OK!");
                } else {


                    console.log("You canceled!");
                }

            });





            var ii = <?php echo count($timesheet); ?>; // Set initial value based on the existing rows

            $(".add-btn").click(function() {
                ++ii;
                //addtinymce();

                var row = '<tr>' +
                    '<td><select name="project_id_' + ii + '" id="project_id_' + ii + '" class="form-control dynamic-row project_id_' + ii + '">' +
                    '<option value="">Select Project Name</option>' +
                    '<?php foreach ($projects_name as $row) { ?>' +
                    '<option value="<?php echo $row["project_id"]; ?>"><?php echo $row["project_name"]; ?></option>' +
                    '<?php } ?>' +
                    '</select>' +
                    '<p class="project-error red"></p>' +
                    '</td>' +
                    '<td><input type="text" id="module_" name="module_' + ii + '" class="form-control dynamic-row module" ></td>' +
                    '<td><textarea class="form-control task dynamic-row task_' + ii + '" id="task_' + ii + '" name="task_' + ii + '"></textarea><p id="taskError' + ii + '" class="error"></p></td>' +
                    '<td><select name="status_' + ii + '" id="status_' + ii + '" class="form-control dynamic-row status_' + ii + '">' +
                    '<option value="In progress">In Progress</option>' +
                    '<option value="pending">Pending</option>' +
                    '<option value="completed">Completed</option>' +
                    '</select><span id="statusError" class="error"></span></td>' +
                    '<td><input type="number" id="hours_' + ii + '" name="hours_' + ii + '" min="1" max="2" class="form-control dynamic-row hours_' + ii + '"> <span class="error"></span></td>' +
                    '<td><button type="button" id="dele_row_' + ii + '" class="btn btn-danger btn_delete1">-</button></td>' +
                    '</tr>';


                $("#table-body").append(row);
                $('#counter').val(ii);
                // alert(8);
                addtinymce();
                // alert(7);
                //addtinymce();
                console.log(ii);
            });

            $("#table-body").on("click", ".btn_delete1", function() {
                var row = $(this).closest('tr');
                if (confirm("Are you sure you want to delete this row in add?") == true) {
                    row.remove();
                    console.log("You pressed OK!");
                } else {
                    console.log("You canceled!");
                }
            });


            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            var day = currentDate.getDate().toString().padStart(2, '0');
            var formattedDate = year + '-' + month + '-' + day;

            $('#datepicker').val(formattedDate);
            $('#datepicker').attr('min', formattedDate);
            $('#datepicker').attr('max', formattedDate);

            // Disable options for dates between 1-3
            var datePickerInput = document.getElementById('datepicker');
            datePickerInput.addEventListener('change', function() {
                var selectedDate = new Date(datePickerInput.value);
                var selectedDay = selectedDate.getDate();

                if (selectedDay >= 1 && selectedDay <= 3) {
                    datePickerInput.value = formattedDate;
                }
            });

            // Set the formatted date to the date input field
            $('#datepicker').val(formattedDate);
            addtinymce();

        

            // Initialize form validation
            $('#timesheet_add').validate();
            console.log(ii);
            $("#submit").click(function() {
                // e.preventDefault();
                for (var i = 1; i <= ii; i++) {
                    validateEditorContent(i);
                    // ...existing code...

                    // Add validation rules for dynamically generated fields
                    $('#project_id_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Please select the project.'
                        },
                    });

                    console.log('#hours_' + i);
                    $('#hours_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Use range between 1 to 2 hour use decimal point '
                        },
                    });

                    $('#task_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Fill the task is required'
                        },
                    });

                    $('#status_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Select the status'
                        },
                    });

                    // Validate the form
                    var isValid = $('form').valid();
                }
            });




        });
    </script>


//         $(document).ready(function() {
        //     $('#datepicker').on('change', function() {
        //         var selectedDate = new Date($(this).val());
        //         var today = new Date();
        //         var accessKey = parseInt($('#access_key').val());

        //         // Perform validation on the selected date
        //         if (selectedDate < today) {
        //             if (accessKey <= 0) {
        //                 alert('Access key count should be greater than zero!');
        //             } else {
        //                 alert("djh");
        //             }
        //         }
        //     });
        // });
        $('#datepicker').on('change', function() {
                var selectedDate = new Date($(this).val());
                var today = new Date();

                // Get the empid value
                var empid = $('#empid').val();

                // Call the function to check access_key
                checkAccessKey(empid);
            });

            function checkAccessKey(empid) {
                var sd = "<?php echo base_url("accesskey/"); ?>";
                var url = sd + empid; // Construct the URL with empid

                $.ajax({
                    url: url,
                    method: 'POST',

                    success: function(response) {
                        if (response.access_key == 1) {
                            console.log(response);
                            $('#message').text('Access granted.');
                        } else {
                            console.log(response);
                            $('#message').text('Access denied.');
                        }
                    },
                    error: function() {
                        // Handle the error case
                        $('#message').text('Error occurred while checking access key.');
                    }
                });
            }