<!DOCTYPE html>
<html>

<head>
  <title>Add Employees list</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
</head>
<style>
  * {
    font-family: 'Montserrat', sans-serif;
  }



  #searchForm button[type="submit"] {
    padding: 5px 10px;
    background-color: #337ab7;
    color: #fff;
    border: none;
    cursor: pointer;
  }

  #searchForm button[type="submit"]:hover {
    background-color: #286090;
  }

  .fliter {
    margin-bottom: 20px;
  }

  #searchForm {
    margin-bottom: 10px;
  }

  #searchForm input,
  #searchForm select {
    margin-right: 10px;
  }

  #pdf,
  #csv {
    margin-left: 10px;
  }

  .table__btn {
    margin-right: 5px;
    height: 32px;
  }

  .filter-form {
    display: flex;
    padding: 5rem 0;
    align-items: end;
    justify-content: space-between;
  }

  .logout {
    color: #fff;
    float: right;
  }

  button {
    font-family: monospace;
    background-color: #f3f7fe;
    color: #3b82f6;
    border: none;
    border-radius: 8px;
    width: 100px;
    height: 45px;
    transition: .3s;

  }

  button:hover {
    background-color: #3b82f6;
    box-shadow: 0 0 0 5px #3b83f65f;
    color: #fff;


  }

  .logout {
    margin-left: 100px;
  }

  .btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
    border-radius: 50px;
  }

  .logo {
    height: 60px;
  }



  button.btn.btn-primary.table__btn.logout {
    margin-bottom: 2px;
    margin-top: 6px;
    padding: 6px;
    width: 88px;
    height: 39px;
  }

  #btn_view {
    background-color: #337ab7;

  }

  body {

    font-size: 12px
  }


  .switch {
    position: relative;
    display: inline-block;
    width: 49px;
    height: 21px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: 4px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .2s;
    transition: .2s;
  }

  input:checked+.slider {
    background-color: #337ab7;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }

  .switch input:checked+.slider:before {
    content: "On";
    width: fit-content;
    left: 1px;
    color: #337ab7;
  }

  .return {
    margin-top: -31px;
    margin-left: 110rem;
    margin-bottom: 25px;
  }

  .mb-4 {
    font-weight: bold;
    font-size: 13px;
  }

  .project_card_section {
    background-color: #337ab7;
    border-radius: 5px;
    padding: 2rem;
    color: #ffffff;
    margin-bottom: 2rem;
  }

  .project_card {
    width: 30%;
    display: block;
    margin: 0 auto;
  }

  .submit_emp_btn {
    color: #ffffff;
    border-radius: 5px;
    margin-top: 1rem;
    width: 100%;
    padding: 1rem;
    height: auto;
    background-color: #171717;
  }

  .editBtn {
    background-color: #171717;
    color: #ffffff;
    text-decoration: none;
    padding: 1rem 2rem;
    border-radius: 5px;
    text-transform: capitalize;
  }

  .editBtn:hover {
    text-decoration: none;
    color: #ffffff;
  }


  .success-message {
    background-color: #3bbf52;
    padding: 0;
    font-size: 10px;
    text-align: center;
    margin-top: 10px;
    border-radius: 5px;

}











/* 
  .success-message{
    display: none;
    background-color: #3bbf52;
    padding: 0px;
    font-size: 10px;
    text-align: center;
    margin-top: 10px;
    border-radius: 5px;
  }*/


  .error-message{
    display: none;
    background-color: red;
    padding: 0px;
    font-size: 10px;
    text-align: center;
    margin-top: 10px;
    border-radius: 5px;
  } 

  .access_box {
    position: absolute;
  }

</style>


<body>

  <div id="wrapper">

    <?php include('Common/Admin/navbar.php') ?>

 






    <form action="<?php echo base_url('employees_adding'); ?>" method="post" onsubmit="return validateForm()" class="container">
      <div class="project_card_section">
        <div class="project_card">
          <label for="employee_name">Employee Name</label>
          <input type="text" name="employee_name" id="employee_name" class="form-control">
          <span id="employee_name_error" class="error"></span>

          <label>Team Name</label>
          <select name="team_id" class="form-control" id="team_id">
            <option value="">Select Employee Name</option>
            <?php foreach ($team_master as $data) : ?>
              <option value="<?php echo $data['team_id']; ?>"><?php echo ucfirst($data['team_name']); ?></option>
            <?php endforeach; ?>
          </select>
          <span id="team_id_error" class="error"></span>

          <label>Email</label>
          <input type="email" name="employee_email" id="employee_email" class="form-control">
          <span id="employee_email_error" class="error"></span>

          <label>Role</label>
          <select name="role_id" class="form-control" id="role_id">
            <option value="">Select Employee Name</option>
            <option value="1">Employee</option>
            <option value="2">Admin</option>
          </select>
          <span id="role_id_error" class="error"></span>

          <button type="submit" class="submit submit_emp_btn" id="submit">Submit</button>
        </div>
      </div>
    </form>

    <script>$
    function validateForm() {
        // Get form inputs
        var employeeName = document.getElementById("employee_name").value;
        var teamId = document.getElementById("team_id").value;
        var employeeEmail = document.getElementById("employee_email").value;
        var roleId = document.getElementById("role_id").value;

        // Reset error messages
        document.getElementById("employee_name_error").textContent = "";
        document.getElementById("team_id_error").textContent = "";
        document.getElementById("employee_email_error").textContent = "";
        document.getElementById("role_id_error").textContent = "";

        // Check if inputs are empty
        if (employeeName === "") {
          document.getElementById("employee_name_error").textContent = "Please enter an employee name";
          return false;
        }

        if (teamId === "") {
          document.getElementById("team_id_error").textContent = "Please select a team";
          return false;
        }

        if (employeeEmail === "") {
          document.getElementById("employee_email_error").textContent = "Please enter an email";
          return false;
        }

        if (roleId === "") {
          document.getElementById("role_id_error").textContent = "Please select a role";
          return false;
        }
        return true;
      }

      </script>

    <style>
      .error {
        color: red;
      }
    </style>


<?php
$successMessage = $session->getFlashdata('successful');
$errorMessage = $session->getFlashdata('error_message');

if (!empty($successMessage)) {
    echo '<div class="success-message">' . $successMessage . '</div>';
    echo '<script>';
    echo '$(document).ready(function() {';
    echo '    setTimeout(function() {';
    echo '        $(".success-message").fadeOut("slow");';
    echo '    }, 1000);';
    echo '});';
    echo '</script>';
} elseif (!empty($errorMessage)) {
    echo '<div class="error-message">' . $errorMessage . '</div>';
    echo '<script>';
    echo '$(document).ready(function() {';
    echo '    setTimeout(function() {';
    echo '        $(".error-message").fadeOut("slow");';
    echo '    }, 1000);';
    echo '});';
    echo '</script>';
}

?>
    <div id="page-wrapper">
      <div class="container">
        <!-- <div class="mb-4">
        Timesheet Access permission setting
        </div> -->

        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 js-content">
            <div class="access_box">
              <label for="">Access for All</label>
                <label class="switch">
                  <input type="checkbox" name="accesskey" class="accesskey_all" id="accesskey">
                  <span class="slider round"></span>
                </label> 
            </div>
            <div class="docs-table">
              <table id="documentsTable" class="table table-striped table-bordered">
                <thead>
                  <tr>

                    <th>Employee ID </th>
                    <th>Employee Name</th>
                    <th>Team Name </th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>accesskey</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($employees as $row) :    ?>

                    <tr>
                      <td><?php echo ucfirst($row['emp_id']); ?></td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['team_name']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td> <label class="switch">

                          <input type="checkbox" <?php if ($row['status'] == 1) echo 'checked'; ?> name="status" class="status" id="status" value="('<?= $row['emp_id'] ?>')">
                          <span class="slider round"></span>
                        </label></td>


                      <td> <label class="switch">

                          <input type="checkbox" <?php if ($row['access_key'] == 1) echo 'checked'; ?> name="accesskey" class="accesskey" id="accesskey" value="('<?= $row['emp_id'] ?>')">
                          <span class="slider round"></span>
                        </label></td>
                      <td>
                        <a href="#" class="editBtn" onclick="edit_employees('<?php echo $row['emp_id']; ?>')">edit</a>
                      </td>








                      <script>
                        function edit_employees(emp_id) {
                          var emp_id = (emp_id);
                          // var edit = 
                          var url = "employees/edit/" + emp_id;
                          window.location.href = url;
                        }
                      </script>





                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js"></script>
  <script>
    var table;
    $(document).ready(function() {
      table = $('#documentsTable').DataTable({
        dom: 'Bfrtip',
        order: [
          [0, 'desc']
        
        ],
        pageLength: 25 
      });



      $("#add_project").on('click', function() {
        var project_name = $("input[name='project_name']").val();
        console.log(project_name);
        $.ajax({
          url: "<?php echo base_url("project_adding"); ?>",
          method: 'POST',
          data: {
            project: project_name
          },
          success: function(response) {
            console.log(response);
          },
          error: function(xhr, status, error) {
            // Handle AJAX error if needed
          }
        });
      });





      function pass(empId) {
        if (document.getElementsByClassName('status')[0].checked) {
          // Do something with the empId value
          console.log(empId);
        }
      }


      var table = $('#documentsTable').DataTable();
      $('#documentsTable').on('click', '.status', function() {
        var checkbox = $(this);
        var rowData = table.row($(this).closest('tr')).data();
        // console.log(checkbox);
        if (typeof rowData !== 'undefined') {
          var isChecked = checkbox.prop('checked') ? 1 : 0;
          rowData.check = isChecked;

          var dataToSend = {
            empId: checkbox.val(),
            check: isChecked
          };

          var emp = '<?php echo base_url("/employee_active"); ?>';
          $.ajax({
            url: emp,
            method: 'POST',
            data: dataToSend,
            success: function(response) {
              console.log(response);
            },
            error: function(xhr, status, error) {
              // Handle AJAX error if needed
            }
          });
        }



      })




      $(".accesskey_all").on('click', function() {
        // alert('fgh');
        var emp_id = [];
        var check = $(this);
        var isChecked = check.prop('checked') ? 1 : 0;
        // alert(isChecked);


        var ele = document.getElementsByName('accesskey');
        // alert(ele);
        if (isChecked == 1) {
          for (var i = 0; i < ele.length; i++) {

            if (ele[i].type == 'checkbox')
              ele[i].checked = true;
          }
          table.rows().every(function(rowIdx) {
            var firstVal = $(this.node()).first().find('input').val();
            emp_id.push(firstVal);
            // console.log( emp_id);
            // console.log( 'Row ' + (rowIdx+1)  + ' first value: ' + firstVal );
          });

          var check = 1;
          // alert(dataToSend);
          $.ajax({

            url: "<?php echo base_url("action_group"); ?>",
            method: 'POST',
            data: {
              emp_id: emp_id,
              check: check
            },
            success: function(response) {
              console.log(response);
            },
            error: function(xhr, status, error) {
              // Handle AJAX error if needed
            }
          });
        } else {

          for (var i = 0; i < ele.length; i++) {

            if (ele[i].type == 'checkbox')
              ele[i].checked = false;
          }
          table.rows().every(function(rowIdx) {
            var firstVal = $(this.node()).first().find('input').val();
            emp_id.push(firstVal);
            // console.log( emp_id);
            // console.log( 'Row ' + (rowIdx+1)  + ' first value: ' + firstVal );
          });

          var check = 0;
          // alert(dataToSend);
          $.ajax({

            url: "<?php echo base_url("action_group"); ?>",
            method: 'POST',
            data: {
              emp_id: emp_id,
              check: check
            },
            success: function(response) {
              console.log(response);
            },
            error: function(xhr, status, error) {
              // Handle AJAX error if needed
            }
          });
        }



      });

      function pass(empId) {
        if (document.getElementsByClassName('accesskey')[0].checked) {
          // Do something with the empId value
          console.log(empId);
        }
      }


      var table = $('#documentsTable').DataTable();
      $('#documentsTable').on('click', '.accesskey', function() {
        var checkbox = $(this);
        var rowData = table.row($(this).closest('tr')).data();

        if (typeof rowData !== 'undefined') {
          var isChecked = checkbox.prop('checked') ? 1 : 0;
          rowData.check = isChecked;

          var dataToSend = {
            empId: checkbox.val(),
            check: isChecked
          };
          var sd = "<?php echo base_url("/action_key"); ?>"

          $.ajax({
            url: sd,
            method: 'POST',
            data: dataToSend,
            success: function(response) {
              console.log(response);
            },
            error: function(xhr, status, error) {
              // Handle AJAX error if needed
            }
          });
        }


      })


    });
  </script>

</body>

</html>