<!DOCTYPE html>

<html>



<head>

    <title>Time Sheet</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://cdn.tiny.cloud/1/vv570pfxb8s951gnplopgsczx07c90fknwtwuyolrft4kxph/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <style type="text/css">
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

            margin-top: 25px;

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



        .date_err {

            color: red;

        }





        * {

            font-family: 'Montserrat', sans-serif;

        }



        .red {

            color: #ff0000;

        }



        .w-80 {

            width: 80px;

        }
    </style>

</head>





<body>



    <?php include('common/user/layout/navbar.php') ?>



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

        <form method="post" id="timesheet_add" action="<?php echo base_url(); ?>timesheet/save">

            <div class="container">

                <div id="val">

                    <label>Report Date</label>

                    <input type="date" id="datepicker" name="date" class="calender">

                    <p id="message" class="date_err"></p>



                    <input type="hidden" id="empId" value="<?php echo session('emp_id'); ?>">



                    <input type="hidden" name="access_key" id="access_key">



                    <!--<div id="abc">-->

                    <!--    </select>-->

                    <!--</div>-->

                </div>

                <table class="table">

                    <tbody id="table-body">

                        <tr>

                            <td>

                                <div class="form-group">

                                    <label>Project Name<span class="red">*</span></label>

                                    <select name="project_id_1" id="project_id_1" class="form-control project_id_">



                                        <option value="">Select Project Name</option>



                                        <?php

                                        foreach ($projects_name as $row) {

                                            echo '<option value="' . $row["project_id"] . '">' . $row["project_name"] . '</option>';
                                        }

                                        ?>

                                    </select>

                                    <p id="projectError1" class="error"></p>

                                </div>

                            </td>

                            <td>

                                <div class="form-group">

                                    <label>Module</label>

                                    <input type="text" class="form-control module" id="module_1" name="module_1">

                                </div>

                            </td>

                            <td>

                                <div class="form-group">

                                    <label>Status</label>

                                    <select name="status_1" id="status_1" class="form-control status_1">

                                        <option value="In progress">In Progress</option>

                                        <option value="pending">Pending</option>

                                        <option value="completed">Completed</option>

                                    </select>

                                </div>

                            </td>

                            <td class="w-80">

                                <div class="form-group">

                                    <label>Hours<span class="red">*</span></label>

                                    <input type="number" name="hours_1" id="hours_1" class="form-control hours_1">

                                    <p id="hoursError1" class="error"></p>

                                    <div id="response-message1"></div>

                                </div>

                            </td>

                            <td>

                                <div class="form-group">

                                    <label>Action</label>

                                    <div class='action-btn'>

                                        <button type="button" class="btn btn-primary add-btn" id="btnAdd">+</button>
                            </td>

            </div>

    </div>

    </td>

    </tr>

    <tr>



        <td colspan="5">

            <div class="form-group">

                <label>Task<span class="red">*</span></label>

                <textarea class="form-control task" name="task_1" id="task_1" class="form-control[required] task_1"></textarea>

                <p id="taskError1" class="error"></p>

            </div>

        </td>



    </tr>

    </tbody>

    </table>

    <div id="count"></div>

    <input type="hidden" id="counter" name="counter" value="">

    <button type="submit" id="submit" name="submit" class="btn btn-success">Submit</button>

    </form>

    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script id="addChild">
        function addtinymce(i) {

            tinymce.init({

                selector: '#task_' + i,

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





        // function validateproject(i) {

        //     var project = get("project_id_" + i);

        //     console.log(project);

        //     if (project.trim() === '') {

        //         $("#projectError" + i).text('project is required.');

        //         return false;

        //     }



        //     return true;



        // }



        $(document).ready(function() {



            var ii = 1;

            addtinymce(ii);

            $('#counter').val(ii);

            // Delete Row Button

            $(document).on('click', '.delete-btn', function() {

                var row = $(this).closest('tr');

                var row1 = row.next();

                if (confirm("Are you sure you want to delete this row?")) {

                    row1.remove();

                    row.remove();

                } else {

                    event.preventDefault();

                }

            });





            $(document).on('click', '.add-btn', function() {

                // $(this).remove();

                ++ii;

                var row = '<tr class="tr__' + ii + '">' +

                    '<td> <div class="form-group">   <label>Project Name<span class="red">*</span></label><select name="project_id_' + ii + '"   id="project_id_' + ii + '" class="form-control dynamic-row project_id_' + ii + '">' +

                    '<option value="">Select Project Name</option>' +

                    '<?php foreach ($projects_name as $row) { ?>' +

                    '<option value="<?php echo $row["project_id"]; ?>"><?php echo $row["project_name"]; ?></option>' +

                    '<?php } ?>' +

                    '</select>' +

                    '<p id="projectError' + ii + '" class="error"></p></div>' +

                    '<td>' +

                    '<div class="form-group"><label>Module</label><input type="text"  id="module_" name="module_' + ii + '" class="form-control dynamic-row module" ></div></td>' + '<td><div class="form-group"><label>Status</label><select name="status_' + ii + '" id="status_' + ii + '" class="form-control dynamic-row status_' + ii + '">' +

                    '<option value="In progress">In Progress</option>' +

                    '<option value="pending">Pending</option>' +

                    '<option value="completed">Completed</option>' +

                    '</select><span id="statusError" class="error"></span></div>' +

                    '</td>' +

                    '<td class="w-80"><div class="form-group">  <label>Hours<span class="red">*</span></label><input type="number"  id="hours_' + ii + '" name="hours_' + ii + '"  class="form-control dynamic-row hours_' + ii + '"><div id="response-message' + ii + '"></div><p id="hoursError' + ii + '" class="error"></p></div></td>' +

                    '<td><div class="form-group"><label>Action</label><div class="action-btn"><button class="btn btn-danger delete-btn">-</button><button type="button" class="btn btn-primary add-btn" id="btnAdd">+</button></div></div></td>' +

                    '</tr>';

                var row1 = '<tr class="tr__' + ii + '">' +

                    '<td colspan="5"><div class="form-group"><label>Task<span class="red">*</span></label><textarea class="form-control task dynamic-row task_' + ii + '"   id="task_' + ii + '" name="task_' + ii + '"></textarea><p id="taskError' + ii + '" class="error"></p></div></td>'

                '</tr>';



                $("#table-body").append(row);

                $("#table-body").append(row1);

                $('#counter').val(ii);





                tinymce.init({

                    selector: "#task_" + ii,

                    height: 250,

                    plugins: 'lists', // Add the 'lists' plugin

                    toolbar: 'undo redo | bullist numlist | bold italic underline',

                });



                addtinymce(ii);

            });

            // Delete Row Button    



            var currentDate = new Date().toISOString().split("T")[0];

            document.getElementById("datepicker").setAttribute("max", currentDate);

            document.getElementById("datepicker").value = currentDate;





            //             $('#datepicker').on('change', function() {
            //   var selectedDate = new Date($(this).val());

            //   // Set the target time to next day 7 pm
            //   var targetTime = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate() + 1, 19, 0, 0);

            //   var currentTime = new Date(); // Get the current time

            //   if (currentTime > targetTime) {
            //     console.log("Submission time has passed.");
            //     // Your code for handling the case when the submission time has passed
            //   } else {
            //     console.log("Submission time is still valid.");
            //     // Your code for handling the case when the submission time is still valid
            //   }
            // });






            $('#datepicker').on('change', function() {

                var selectedDate = new Date($(this).val());

                // Set the target time to next day 7 pm
                var targetTime = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate() + 1, 11, 0, 0);

                var currentTime = new Date(); // Get the current time

                if (currentTime > targetTime) {

                    // console.log(accessKey);

                    var accessKey = parseInt($('#access_key').val());

                    if (accessKey == 0) {

                        $("#submit").css("display", 'none');
                        $('#message').text("You can't update the timesheet for the previous date, please contact admin!");

                    }

                } else {

                    $("#submit").css("display", '');
                    $('#message').text('');

                }





            });













            addtinymce(ii);



            // Move validation and submit code inside document ready function

            $('form#timesheet_add').validate();

            $("#submit").click(function(event) {

                var valid = false;

                for (var i = 1; i <= ii; i++) {

                    // var project =$('#project_id_' + i);

                    //  console.log(project[0]);

                    // if(project[0] !=null){

                    var project = jQuery('#project_id_' + i).get(0);

                    //  alert(project);

                    if (project !== undefined) {

                        // console.log($('#project_id_' + i)[0]);

                        var project_id = $('#project_id_' + i).val();

                        if (project_id == '') {

                            $('#projectError' + i).text(" Project is required ");

                            valid = false;

                        } else {

                            $('#projectError' + i).text('');

                            //valid=true;

                        }

                        var hours = $('#hours_' + i).val();

                        if (hours == '' && hours == 0) {

                            $('#hoursError' + i).text("Working Hours is Required");

                            valid = false;

                        } else {

                            $('#hoursError' + i).text('');

                            //valid=true;

                        }





                        var editor = tinyMCE.get("task_" + i);



                        var content = editor.getContent();



                        if (content.trim() === '') {

                            $("#taskError" + i).text('Task is required.');

                            valid = false;

                        } else {

                            $("#taskError" + i).text('');

                            //valid=true;

                        }

                        if (project_id != '' && hours != '' && hours != 0 && content.trim() != '') {

                            valid = true;

                        }

                    } else {

                        valid = true;

                    }

                }



                if (!valid) {

                    event.preventDefault();

                }





            });





            var empId = $('#empId').val();

            // var rowId = $(this).attr('id').split('_')[1];

            //     var hourss = $(this).val();

            console.log(empId);

            // Send the emp_id to the server-side code using AJAX

            $.ajax({

                type: 'post',

                url: 'access_key', // Replace 'your_server_url' with the actual URL

                data: {

                    emp_id: empId

                },

                success: function(response) {

                    $('#access_key').val(response);

                },

                error: function(xhr, status, error) {

                    // Handle the error, if any

                    console.error(error);

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

            //   ..existing code...

        });
    </script>

</body>

</html>