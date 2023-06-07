<!DOCTYPE html>
<html>

<head>
    <title>Time Sheet</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        function addtinymce() {
            tinymce.init({
                selector: '.task'
            });
        }

        $(document).ready(function () {
            addtinymce();

            // Delete Row Button
            $(document).on('click', '.delete-btn', function () {
                var row = $(this).closest('tr');
                if (confirm("Are you sure you want to delete this row?")) {
                    row.remove();
                }
            });

            $(".add-btn").click(function () {
                var row = '<tr>' +
                    '<td><select name="project_name" class="form-control dynamic-row">' +
                    '<option value="">Select Project Name</option>' +
                    '<?php foreach ($projects_name as $row) { ?>' +
                    '<option value="<?php echo $row["project_id"]; ?>"><?php echo $row["project_name"]; ?></option>' +
                    '<?php } ?>' +
                    '</select>' +
                    '<p class="project-error red"></p>' +
                    '</td>' +
                    '<td><input type="text" class="form-control dynamic-row" name="module"></td>' +
                    '<td><textarea class="form-control task dynamic-row" name="task"></textarea></td>' +
                    '<td><select name="status" class="form-control dynamic-row">' +
                    '<option value="In progress">In Progress</option>' +
                    '<option value="pending">Pending</option>' +
                    '<option value="complete">Complete</option>' +
                    '</select></td>' +
                    '<td><input type="number" name="hours" min="1" max="2" class="form-control dynamic-row" maxlength="2"></td>' +
                    '<td><button class="btn btn-danger delete-btn">-</button></td>' +
                    '</tr>';

                $("#table-body").append(row);
                addValidationRules();
                addtinymce();
            });

            function addValidationRules() {
                // Select the dynamically added rows
                var dynamicRows = $('.dynamic-row');

                // Loop through each dynamically added row
                dynamicRows.each(function () {
                    var row = $(this);
                    // Add validation rules to each input/select element within the row
                    row.rules('add', {
                    required: true,
                    messages: {
                        required: "This field is required."
                    }
                    });
                });
            }

            var currentDate = new Date();
            var day = currentDate.getDate();
            var month = currentDate.getMonth() + 1;
            var year = currentDate.getFullYear();
            var dateString = year + "-" + month + "-" + day;
            $('#datepicker').val(dateString);

            // Initialize form validation\
            $("#form").validate({
                rules: {
                    project_name: {
                        required: true
                    },
                    module: {
                        required: true
                    },
                    task: {
                        required: true
                   
                    },
                    hours: {
                        required: true,
                        min: 1,
                        max: 2
                    }
                },
                messages: {
                    project_name: {
                        required: "Please select a project name."
                    },
                    module: {
                        required: "Please enter a module."
                    },
                    task: {
                        required: "Please enter a task."
                    },
                    hours: {
                        required: "Please enter the number of hours.",
                        min: "The minimum value is 1.",
                        max: "The maximum value is 2."
                    }
                },
                
                submitHandler: function (form) {
                    // Form submission code
                    form.submit();
                }
            });

            // Function to apply validation rules to dynamically added rows
            function addValidationRulesAdd() {
                $(".dynamic-row").each(function () {
                    $(this).rules("add", {
                        required: true
                    });
                });
            }
        });
    </script>

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
        }

        .red {
            color: red;
        }

        #project {
            color: red;
        }
    </style>

</head>

<body>
    <div class="container">
        <h1>Timesheet</h1>
        <form method="post" id="form" class="forms" action="">
            <div class="container">
                <div id="val">
                    <label>Report Date</label>
                    <input type="date" id="datepicker" class="calender" value="">
                </div>
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
                            <select name="project_name" id="project_name" class="form-control">
                                <option value="">Select Project Name</option>
                                <?php
                                foreach ($projects_name as $row) {
                                    echo '<option value="' . $row["project_id"] . '">' . $row["project_name"] . '</option>';
                                }
                                ?>
                            </select>
                            <p id="project" class="project-error red"></p>
                        </td>
                        <td><input type="text" class="form-control" id="module" name="module"></td>
                        <td><textarea class="form-control task" name="task"></textarea></td>
                        <td>
                            <select name="status" class="form-control">
                                <option value="In progress">In Progress</option>
                                <option value="pending">Pending</option>
                                <option value="complete">Complete</option>
                            </select>
                        </td>
                        <td><input type="number" name="hours" class="form-control" min="1" max="2"></td>
                       
                        <td><button class="btn btn-danger delete-btn">-</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary add-btn" id="added">Add Row</button>
            <button type="submit" id="submit" name="submit" class="btn btn-success">Submit</button>
        </form>
    </div>

</body>

</html>
<script>
    var ValidationList = [
    { name: "project_name", reg: "true", msg: "Please select a project name." },
    { name: "task", reg: "true", msg: "Please enter a task." },
    { name: "hours", reg: "true", msg: "Please enter the number of hours." }
];

</script>