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

        .red {
            color: red;
        }



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

        #response-message {
            color: red;
        }

        #add {
            margin-left: 83%;
            background-color: #000;
        }

        .form-group {
            width: 100%;
        }

        .hours-input {
            width: 40%;
        }

        .action-btn {
            align-items: center;
            display: flex;
            gap: 10px;
        }

        #back {
            margin-left: 43px;
            background-color: #000;
            margin-top: -36px;

        }

        .top-next-btn {
            align-items: center;
            margin-top: 25px;
        }

        .w-80 {
            width: 80px;
        }
    </style>
</head>


<body>
    <?= $navbar ?>

    <div class="top-next-btn">
        <button class="btn btn-primary table__btn" id="add">
            Add timesheet
        </button>




        <button class="btn btn-primary table__btn" id="back" onclick="redirectback()">
            Back
        </button>

        <script>
            function redirectback() {
                window.location.href = "<?= base_url('mytimesheet') ?>";
            }
        </script>
    </div>
    <div class="container">
        <form method="post" id="timesheet_add" action="<?= base_url('timesheet/update') ?>">






    </div>
    <div class="container">
        <?php if (session()->has('errors')) : ?>
            <div class="error-box">
                <ul class="error-list">
                    <?php foreach (session('errors') as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div id="val">
            <label>Report Date</label>


            <input type="date" id="datepicker" name="date" value="<?php echo date('Y-m-d', strtotime($newDate)); ?>">
            <div id="abc">
                </select>
            </div>
        </div>
        <table id="table" class="table">
            <tbody id="table-body">
                <?php if ($timesheet !== null) :
                    //  print_r($timesheet);die;
                    $i = 1;
                    foreach ($timesheet as $index => $entry) :

                ?>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <input type="hidden" class="counter" name="counter" value="<?= $i ?>">
                                    <input type="hidden" name="row_id_<?= $i ?>" id="row_id" value="<?= $entry['id'] ?>">
                                    <label>Project Name<span class="red">*</span></label>
                                    <select id="project_id_<?= $i ?>" name="project_id_<?= $i ?>" class="form-control project_id_">
                                        <!-- <option value="">Select Project Name</option> -->
                                        <?php foreach ($projects_name as $row) : ?>
                                            <option value="<?= $row['project_id'] ?>" <?= ($row['project_id'] == $entry['project_id']) ? 'selected' : '' ?>>
                                                <?= $row['project_name'] ?>
                                            </option>

                                        <?php endforeach; ?>

                                    </select>
                                    <span class="error"></span>
                                </div>
                            </td>
                            <td>
                            <div class="form-group">
                                <label>Modules</label>
                                <input type="text" class="form-control module" name="module_<?= $i ?>" value="<?= $entry['module'] ?>">
                            </div>
                            </td>
                            <td>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status_<?= $i ?>" class="form-control status_<?= $i ?>">
                                    <option value="In progress" <?php if ($entry['status'] === 'In Progress') {
                                                                    echo 'selected="selected"';
                                                                } ?>>In Progress</option>
                                    <option value="pending" <?php if ($entry['status'] === 'pending') {
                                                                echo 'selected="selected"';
                                                            } ?>>Pending</option>
                                    <option value="completed" <?php if ($entry['status'] === 'completed') {
                                                                    echo 'selected="selected"';
                                                                } ?>>Completed</option>
                                </select>
                                <span class="error"></span>
                            </div>
                            </td>

                            <td class="w-80">
                                <div class="form-group">

                                    <label>Hours<span class="red">*</span></label>
                                    <input type="number" name="hours_<?= $i ?>" id="hours_<?= $i ?>" class="form-control " value="<?= $entry['hours'] ?>">
                                    <!-- <div id="responseContainer"></div> -->
                                    <div id="response-message<?= $i ?>" class="error-message"></div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label>Action</label>
                                    <div class='action-btn'>
                                        <?php $next = $i; ?>

                                        <button type="button" class="btn btn-danger btn_delete" value="<?= $entry['id'] ?>">-</button>
                                    </div>
                            </td>
                        </tr>
                        <tr class="tr__1">
                        <td colspan="5">
                        <div class="form-group">
                                    <label>Task<span class="red">*</span></label>
                                    <textarea class="form-control task dynamic-row task_<?= $i ?>" id="task_<?= $i ?>" name="task_<?= $i ?>"><?= strip_tags($entry['task']) ?></textarea>
                                    <p id="taskError<?= $i ?>" class="error"></p>
                                    <span id="task_error<?= $i ?>" class="error-message"></span>
                                    <div id="response_Container<?= $i ?>" class="error-message"></div>
                                </div>
                        </td>

                        </tr>
                    <?php

                        $i++;
                    endforeach;
                    ?>
                <?php endif; ?>

            </tbody>

            <input type="hidden" id="deleted_row" name="deleted_row">

        </table>
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

        function addtinymce(i) {

            //  alert(i);
            tinymce.init({
                selector: "#task_" + i,
                height: 250,
                plugins: 'lists', // Add the 'lists' plugin
                toolbar: 'undo redo | bullist numlist | bold italic underline',

            });
        };



        function validateEditorContent(i) {
            var editor = tinyMCE.get("task_" + i);

            var content = editor.getContent();

            if (content.trim() === '') {
                $("#taskError" + i).text('Task is required.');
                return false;
            }

            return true;
        }






        $(document).ready(function() {

            var ii = <?php echo count($timesheet); ?>; // Set initial value based on the existing rows
            for (var k = 1; k <= ii; k++) {
                addtinymce(k);
            }
            var rr = 1;
            $(".add-btn").click(function() {
                ++ii;
                //addtinymce();

                var row = '<tr>' +

                    '<td> <input type="hidden" name="row_id_' + ii + '" id="row_id" value="">' +
                    '<input type="hidden" id="counter" name="counter" value="' + ii + '">' +
                    '<select name="project_id_' + ii + '" id="project_id_' + ii + '" class="form-control dynamic-row project_id_' + ii + '">' +
                    '<option value="">Select Project Name</option>' +
                    '<?php foreach ($projects_name as $row) { ?>' +
                    '<option value="<?php echo $row["project_id"]; ?>"><?php echo $row["project_name"]; ?></option>' +
                    '<?php } ?>' +
                    '</select>' +
                    '<p class="project-error red"></p>' +
                    '</td>' +
                    '<td><input type="text" id="module_" name="module_' + ii + '" class="form-control dynamic-row module" ></td>' +
                    '<td><textarea class="form-control task dynamic-row task_' + ii + '" id="task_' + ii + '" name="task_' + ii + '"></textarea><p id="taskError' + ii + '" class="error"><div id="response_Container' + ii + '"></p></td>' +
                    '<td><select name="status_' + ii + '" id="status_' + ii + '" class="form-control dynamic-row status_' + ii + '">' +
                    '<option value="In progress">In Progress</option>' +
                    '<option value="pending">Pending</option>' +
                    '<option value="completed">Completed</option>' +
                    '</select><span id="statusError" class="error"></span></td>' +
                    '<td><input type="number" id="hours_' + ii + '" name="hours_' + ii + '" class="form-control "></span><div id="response-message' + ii + '"></div></td>' +
                    '<td><button type="button" id="dele_row_' + ii + '" class="btn btn-danger btn_delete1">-</button></td>' +
                    '</tr>';


                $("#table-body").append(row);
                $('#counter').val(ii);
                // alert(8);
                // addtinymce(ii);
                // initializeTinyMCEOnAllRows();
                tinymce.init({
                    selector: "#task_" + ii,
                    height: 250,
                    plugins: 'lists', // Add the 'lists' plugin
                    toolbar: 'undo redo | bullist numlist | bold italic underline',
                });

            });

            // var row1 = ' class="tr__1';
          
            $("#table-body").on("click", ".btn_delete1", function() {
                var row = $(this).closest('tr');
                var row1 = row.next();

                var task_id = "#task_" + ii;
                // var task_id = $(task_id).val();


                // ii = ii-1;
                // var vacc = $(this).closest('tr').find('td:first-child input').val();
                // console.log(vacc);
                if (confirm("Are you sure you want to delete this row in add?") == true) {
                    row.remove();
                    row1.remove();
                    console.log("You  OK!");
                    console.log("The row with id '" + task_id + "' is removed.");
                    //updateRowIdsAndNames();
                    initializeTinyMCEOnAllRows();

                } else {
                    console.log("You canceled!");
                }
            });

            // Function to update the row ids and names after deletion
            function updateRowIdsAndNames() {
                var rows = $("#table-body tr");

                rows.each(function(index) {
                    var row = $(this);
                    var rowIndex = index + 1;

                    row.find('.dynamic-row').each(function() {
                        var element = $(this);
                        var name = element.attr('name');
                        var newName = name.replace(/_\d+$/, '_' + rowIndex);
                        element.attr('name', newName);

                        var id = element.attr('id');
                        var newId = id.replace(/_\d+$/, '_' + rowIndex);
                        element.attr('id', newId);
                    });

                    row.find('.btn_delete1').attr('id', 'dele_row_' + rowIndex);
                });

                ii = rows.length;
            }

            function initializeTinyMCEOnAllRows() {
                var rows = $("#table-body tr");

                rows.each(function() {
                    var rowId = $(this).find('.task').attr('id').split('_').pop();
                    console.log(rowId);
                    addtinymce(rowId);
                });
            }


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



            // Move validation and submit code inside document ready function
            $('form#timesheet_add').validate();
            $("#submit").click(function() {
                for (var i = 1; i <= ii; i++) {
                    // var task_id = "#task_" + i;
                    var task_id = $("#task_" + i);
                    // console.log(task_id[0]);
                    if (task_id[0] != null) {
                        var a = validateEditorContent(i);
                        //alert(a);
                        if (a == false) {
                            event.preventDefault();
                        }
                    }




                    $('#project_id_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Project Name is required.'
                        },
                    });
                    $('#hours_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Working hours is required.'
                        },
                    });


                    // $('#status_' + i).rules('add', {
                    //     required: true,
                    //     messages: {
                    //         required: 'Select the status'
                    //     },
                    // });

                    // Validate the form
                    var isValid = $('form').valid();
                }
            });


            $('#add').click(function() {
                window.location.href = "<?= base_url('timesheet') ?>";
            });


            // function redirectToTimesheet() {

            // }


            function redirectback() {
                window.location.href = "<?= base_url('mytimesheet') ?>";
            }




            // Get the value of the  delete button, row_id 
            $('.btn_delete').click(function() {
                var id = $(this).val();
                var row = $(this).closest('tr');
                var row1=  $(".tr__1");
                // Display a confirmation dialog
                var confirmed = confirm("Are you sure you want to delete this row?");
                if (confirmed) {
                    row.remove();
                    row1.remove();
                    $.ajax({

                        url: '/timesheet/delete_row',
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            // Handle the response from the server
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.log(error);
                        }
                    });
                    //updateRowIdsAndNames();
                    initializeTinyMCEOnAllRows();
                } else {
                    // The user clicked "No," do nothing
                    console.log("Deletion canceled.");
                }
            });


            $(document).on('input', 'input[id^="hours_"]', function() {
                var rowId = $(this).attr('id').split('_')[1];
                var hourss = $(this).val();

                var $responseMessage = $('#response-message' + rowId); // Select the corresponding response message element

                $.ajax({
                    url: '<?php echo base_url("timesheet/ajaxvalidation"); ?>',
                    method: 'POST',
                    data: {
                        rowId: rowId,
                        hourss: hourss
                    },
                    success: function(response) {
                        var parsedResponse = JSON.parse(response);

                        // Clear previous error messages
                        $responseMessage.empty();

                        if (parsedResponse.hasOwnProperty('missing')) {
                            var error = ' ' + parsedResponse.missing;
                            $responseMessage.text(error).addClass('error');
                            $("#submit").prop("disabled", true);
                            console.log(error);
                        } else if (parsedResponse.hasOwnProperty('error')) {
                            var error = '' + parsedResponse.error;
                            $responseMessage.text(error).addClass('error');
                            $("#submit").prop("disabled", true);
                            console.log(error);
                        } else if (parsedResponse.hasOwnProperty('pass')) {
                            $("#submit").prop("disabled", false);
                            console.log(parsedResponse.pass); // Assuming 'success' is the response message
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $responseMessage.text("Ajax error: " + textStatus + " " + errorThrown).addClass('error');
                    }
                });
            });
            // Get the textarea value

            $('#submit').click(function() {
                var emptyFields = [];

                // // Iterate through each textarea with id starting with 'task_'
                // $('textarea[id^="task_"]').each(function() {
                //     var textareaId = $(this).attr('id');
                //     var content = tinymce.get(textareaId).getContent();

                //     // Check if the content is empty
                //     if (content.trim() === '') {
                //         emptyFields.push(textareaId);
                //     }
                // });

                // If there are empty fields, display the error message
                if (emptyFields.length > 0) {
                    // Perform Ajax request to display the error message
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url("timesheet/ajaxvalidation_task"); ?>', // Replace with your validation endpoint
                        data: {
                            fields: emptyFields
                        },
                        success: function(response) {
                            // Clear previous error messages
                            if (Object.keys(errorMessages).length > 0) {
                                $("#submit").prop("disabled", true);
                            } else {
                                $("#submit").prop("disabled", false);
                            }
                        }
                    });
                }
            });


        });
    </script>

</body>

</html>