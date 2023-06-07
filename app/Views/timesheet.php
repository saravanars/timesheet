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
    </style>
</head>


<body>

    <?= $navbar ?>
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



                    <input type="hidden" id="access_key" value="<?php echo session('access_key'); ?>">

                    <div id="abc">
                        </select>
                    </div>
                </div>
                <table class="table">
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
                        <tr>
                            <td>
                                <select name="project_id_1" id="project_id_1" class="form-control project_id_">

                                    <option value="">Select Project Name</option>

                                    <?php
                                    foreach ($projects_name as $row) {
                                        echo '<option value="' . $row["project_id"] . '">' . $row["project_name"] . '</option>';
                                    }
                                    ?>
                                </select>


                            </td>
                            <td><input type="text" class="form-control module" id="module_1" name="module_1"></td>
                            <td>
                                <textarea class="form-control task" name="task_1" id="task_1" class="form-control[required] task_1"></textarea>
                                <p id="taskError1" class="error"></p>
                            </td>
                            <td>
                                <select name="status_1" id="status_1" class="form-control status_1">

                                    <option value="In progress">In Progress</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>

                                </select>
                                <input type="hidden" id="counter" name="counter" value="">

                            </td>
                            <td><input type="number" name="hours_1" id="hours_1" class="form-control hours_1" min="1" max="2"></td>

                            <td><button class="btn btn-danger delete-btn">-</button></td>
                        </tr>
                    </tbody>
                </table>
                <div id="count"></div>
                <button type="button" class="btn btn-primary add-btn" id="btnAdd">Add Row</button>
                <button type="submit" id="submit" name="submit" class="btn btn-success">Submit</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script id="addChild">
        function addtinymce() {
            tinymce.init({
                selector: '.task',
                height: 250
            });
        };

        function validateEditorContent(i) {
            var editor = tinyMCE.get("task_" + i);
            console.log(editor);
            var content = editor.getContent();

            if (content.trim() === '') {
                $("#taskError" + i).text('The editor content cannot be empty.');
                return false;
            }

            return true;
        }


        $(document).ready(function() {
            addtinymce();

            var ii = 1;
            $('#counter').val(ii);
            // Delete Row Button
            $(document).on('click', '.delete-btn', function() {
                var row = $(this).closest('tr');

                if (confirm("Are you sure you want to delete this row?")) {
                    row.remove();
                }
            });



            $(".add-btn").click(function() {
                ++ii;
                var row = '<tr>' +
                    '<td><select name="project_id_' + ii + '"   id="project_id_' + ii + '" class="form-control dynamic-row project_id_' + ii + '">' +
                    '<option value="">Select Project Name</option>' +
                    '<?php foreach ($projects_name as $row) { ?>' +
                    '<option value="<?php echo $row["project_id"]; ?>"><?php echo $row["project_name"]; ?></option>' +
                    '<?php } ?>' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="text"  id="module_" name="module_' + ii + '" class="form-control dynamic-row module" ></td>' +
                    '<td><textarea class="form-control task dynamic-row task_' + ii + '"   id="task_' + ii + '" name="task_' + ii + '"></textarea><span id="taskError' + ii + '" class="error"></span></td>' +
                    '<td><select name="status_' + ii + '" id="status_' + ii + '" class="form-control dynamic-row status_' + ii + '">' +
                    '<option value="In progress">In Progress</option>' +
                    '<option value="pending">Pending</option>' +
                    '<option value="completed">Completed</option>' +
                    '</select></td>' +
                    '<td><input type="number"  id="hours_' + ii + '" name="hours_' + ii + '" min="1" max="2" class="form-control dynamic-row hours_' + ii + '"></td>' +
                    '<td><button class="btn btn-danger delete-btn">-</button></td>' +
                    '</tr>';

                $("#table-body").append(row);
                $('#counter').val(ii);

                addtinymce();
            });
            // Delete Row Button    

            var currentDate = new Date().toISOString().split("T")[0];
            document.getElementById("datepicker").setAttribute("max", currentDate);
            document.getElementById("datepicker").value = currentDate;



            $('#datepicker').on('change', function() {
                var selectedDate = new Date($(this).val());
                selectedDate.setHours(0, 0, 0, 0); // Set time to midnight

                var today = new Date();
                today.setHours(0, 0, 0, 0);

                var accessKey = parseInt($('#access_key').val());

                if (selectedDate < today) {
                    if (accessKey == 0) {
                        $("#submit").prop("disabled", true);
                        $('#message').text("You can't update the timesheet for the previous date, please contact admin!");
                    }
                } else {
                    // alert("cxngjh");
                    $("#submit").prop("disabled", false);
                    $('#message').text('');
                }


            });






            addtinymce();

            // Move validation and submit code inside document ready function
            $('form#timesheet_add').validate();

            $("#submit").click(function() {

                $("#timesheet_add").submit(function(event) {
                var fieldCount = ii;
                var isValid = true;

                for (var i = 1; i <= fieldCount; i++) {
                    if (!validateEditorContent(i)) {
                        isValid = false;
                    }
                }

                if (!isValid) {
                    event.preventDefault(); // Prevent form submission
                }
            });



                for (var i = 1; i <= ii; i++) {
                    validateEditorContent(ii);

                    // ...existing code..a
                    // Add validation rules for dynamically generated fields
                    $('#project_id_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Please select the project.',
                        },
                    });
                    $('#hours_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: "Use range between 1 to 2 hour use decimal point",
                        },
                    });
                    $('#task_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Fill the task is required',
                        },
                    });

                    $('#task').rules('add', {
                        required: true,
                        messages: {
                            required: 'The task cannot be empty.',
                        },
                    });

                    $('#status_' + i).rules('add', {
                        required: true,
                        messages: {
                            required: 'Select the status',
                        },
                    });
                }

            });


            //   ..existing code...
        });
        $('form').validate();
    </script>



    <script>




    </script>





</body>

</html>