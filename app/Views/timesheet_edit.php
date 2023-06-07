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
    </style>
</head>


<body>
    <?= $navbar ?>
    <div class="container">



        <form method="post" id="timesheet_add" action="<?= base_url('timesheet/update') ?>">
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
                            //  print_r($timesheet);die;
                            $i = 1;
                            foreach ($timesheet as $index => $entry) :

                        ?>
                                <tr>
                                    <td>
                                        <input type="hidden" class="counter" name="counter" value="<?= $i ?>">
                                        <input type="hidden" name="row_id_<?= $i ?>" id="row_id" value="<?= $entry['id'] ?>">
                                        <select id="project_id_<?= $i ?>" name="project_id_<?= $i ?>" class="form-control project_id_">
                                            <option value="">Select Project Name</option>
                                            <?php foreach ($projects_name as $row) : ?>
                                                <option value="<?= $row['project_id'] ?>" <?= ($row['project_id'] == $entry['project_id']) ? 'selected' : '' ?>>
                                                    <?= $row['project_name'] ?>
                                                </option>

                                            <?php endforeach; ?>

                                        </select>
                                        <span class="error"></span>

                                    </td>

                                    <td>
                                        <input type="text" class="form-control module" name="module_<?= $i ?>" value="<?= $entry['module'] ?>">
                                    </td>
                                    <td>

                                        <textarea class="form-control task dynamic-row task_<?= $i ?>" id="task_<?= $i ?>" name="task_<?= $i ?>"><?= strip_tags($entry['task']) ?></textarea>
                                        <p id="taskError<?= $i ?>" class="error"></p>

                                    </td>

                                    <td>
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
                                    </td>

                                    <td>
                                        <input type="number" name="hours_<?= $i ?>" id="hours_<?= $i ?>" class="form-control hours_<?= $i ?>" min="1" max="2" value="<?= $entry['hours'] ?>">
                                        <span class="error"></span>

                                    </td>
                                    <td>
                                        <?php $next = $i; ?>

                                        <button type="button" class="btn btn-danger btn_delete" value="<?= $entry['id'] ?>">-</button>

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

        function addtinymce(i) {
            console.log(i)
            // alert(1);
            tinymce.init({
                selector: '.task',
                height: 250,

                // setup: function (editor) {
                //     editor.on('keyup', function () {
                //     // Handle the onchange event here
                //     var content = editor.getContent();

                //     // Perform actions based on the changed content
                //     if (content.trim() === '') {
                //         // Content is empty
                //         console.log("Editor content is empty.");
                //         $("#taskError" + i).text('The editor content cannot be empty.');
                //         $("#taskError" + i).show();
                //     } else {
                //         // Content has changed
                //         console.log("Editor content has changed.");
                //         $("#taskError" + i).hide();
                //     }
                //     });
                // }
            });
        };







        function validateEditorContent(i) {
            var editor = tinyMCE.get("task_" + i);
            console.log(editor);
            var content = editor.getContent();

            if (content.trim() === '') {
                $("#taskError" + i).text('The editor content cannot be empty.');
                return false;
            } else {

                $("#taskError" + i).hide();
                return true;

            }


        }





        //     function validateEditorContent(i) {

        //         var editor = tinyMCE.activeEditor;
        //         var content = editor.getContent();
        //         var text = $('#textEditor').val();
        // var wordToCheck = 'word';
        //         // Check if the editor content is empty.
        //         if (content === '') {
        //             console.log("dbj");
        //             $("#taskError" + i).text('The editor content cannot be empty.');
        //             return false;

        //             // var isValidHTML = tinyMCE.isValid(content);
        //             // if (!isValidHTML) {
        //             //     alert('The editor content contains invalid HTML.');
        //             //     return false;
        //             // }
        //         }


        //         return true;
        //     }

        $(document).ready(function() {

            $('.btn_delete').click(function() {
                var row = $(this).closest('tr');
                console.log(row);
                var vacc = $(this).closest('tr').find('td:first-child input').val();
                console.log(vacc);
                if (confirm("Are you sure you want to delete this row?") == true) {


                    $rows = row.remove('tr');

                    var deleteid = $('#deleted_row').val();
                    console.log(deleteid);
                    if (deleteid == '') var ccval = vacc;
                    else var ccval = deleteid + ',' + vacc;
                    $('#deleted_row').val(ccval);
                    console.log(ccval);

                    console.log("You  OK!");
                } else {


                    console.log("You canceled!");
                }

            });

            var ii = <?php echo count($timesheet); ?>; // Set initial value based on the existing rows
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
                addtinymce(ii);
                // alert(7);
                //addtinymce();
                // console.log(ii);
            });

            var task_id;
            $("#table-body").on("click", ".btn_delete1", function() {
                var row = $(this).closest('tr');
                var task_id = "#task_" + ii;
                // var value = row.attr(id);



                // var vacc = $(this).closest('tr').find('td:first-child input').val();
                // console.log(vacc);
                if (confirm("Are you sure you want to delete this row in add?") == true) {
                    row.remove();

                    console.log("You  OK!");
                    console.log("The row with id '" + task_id + "' is removed.");
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
            addtinymce(ii);

            // Initialize form validation
            $('#timesheet_add').validate();

            $("#timesheet_add").submit(function(event) {
                var fieldCount = ii;
                var isValid = true;

                for (var i = 1; i <= fieldCount; i++) {
                    if (!validateEditorContent(i)) {
                        isValid = false;
                        var rowId = "dele_row_" + i;
                        removeRow(rowId, task_id); // Pass the task_id to the removeRow function
                        fieldCount--;
                        i--;
                        $("#taskError" + i).hide();

                    }
                }

                if (!isValid) {

                    event.preventDefault(); // Prevent form submission
                }
            });

            console.log(ii);
            $("#submit").click(function() {

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
                            required: 'Use range between 1 to 2 hour use decimal point '
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




            // Get the value of the  delete button, row_id 
            $('.btn_delete').click(function() {
                var id = $(this).val();

                $.ajax({
                    url: '/timesheet/delete_row',
                    method: 'POST',
                    data: {
                        id: id
                    }, // Pass the ID as data in the AJAX request
                    success: function(response) {
                        // Handle the response from the server
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.log(error);
                    }
                });
            });


        });
    </script>
</body>

</html>