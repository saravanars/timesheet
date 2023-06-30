<!DOCTYPE html>
<html>

<head>
  <title> Adding Project List </title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
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

  .add_project_btn {
    color: #ffffff;
    border-radius: 5px;
    margin-top: 1rem;
    width: 100%;
    padding: 1rem;
    height: auto;
    background-color: #171717;
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

  .update_project_btn {
    height: auto;
    background-color: #171717 !important;
    border: none !important;
    padding: 10px !important;
  }

  .close_pop {
    background-color: #fff;
    border: none !important;
    font-size: 25px;
    width: auto;
    outline: none !important;
  }

  .close_pop:hover {
    background-color: transparent !important;
    box-shadow: 0 0 0 0 #ffffff00 !important;
  }



  .response-message {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 10px 20px;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    font-size: 14px;
    color: #333;
  }

  .response-message.success {
    background-color: #dff0d8;
    border-color: #d6e9c6;
    color: #3c763d;
  }

  .response-message.error {
    background-color: #f2dede;
    border-color: #ebccd1;
    color: #a94442;
  }




  .box {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 200px;
    /* Adjust the width to your preference */
    height: 200px;
    /* Adjust the height to your preference */
    border: 1px solid black;
    /* Adjust the border style */
    text-align: center;
  }

  .success {
    background-color: green;
    /* Adjust the background color for success */
    color: white;
    /* Adjust the text color for success */
  }

  .error_msg {
    background-color: red;
    /* Adjust the background color for error */
    color: white;
    /* Adjust the text color for error */
  }


  .error {
    background-color: red;
    /* Adjust the background color for error */
    color: white;
    /* Adjust the text color for error */
  }

  .success_msg{
    display: none;
    background-color: #3bbf52;
    padding: 10px;
    font-size: 15px;
    text-align: center;
    margin-top: 10px;
    border-radius: 5px;
  }
</style>


<div id="wrapper">
  <div>
  </div>
  <?php include('Common/Admin/navbar.php') ?>
  <span id="responseContainer"></span>


  <div id="page-wrapper" class="container">
    <div class="project_card_section">
      <div class="project_card">
        <label for="project_name" class="h5">Project Name</label>
        <input type="text" name="project_name" id="project_name" class="form-control py-4" placeholder="Enter project name">
        <button id="add_project" class="add_project_btn">ADD</button>
        <p class="success_msg"></p>
        <p class="success_error"></p>
      </div>
    </div>
    <div class="container-fluid col-md-12">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 js-content">
          <div class="docs-table">
            <table id="documentsTable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Project ID</th>
                  <th>Project Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($projects_name as $row) : ?>
                  <tr>
                    <td><?php echo ucfirst($row['project_id']); ?></td>
                    <td><?php echo $row['project_name']; ?></td>
                    <td>
                      <label class="switch">
                        <input type="checkbox" <?php if ($row['status'] == 1) echo 'checked'; ?> name="accesskey" class="accesskey" id="accesskey" value="<?= $row['project_id'] ?>">
                        <span class="slider round"></span>
                      </label>
                    </td>
                    <td>
                      <a href="#" class="editBtn" data-project-id="<?= $row['project_id'] ?>">edit</a>
                    </td>
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

<div class="modal" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Project</h5>
        <button type="button" class="close_pop close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modalData">
          <input type="hidden" id="edit_project_id" name="edit_project_id" class="form-control">
          <input type="text" id="edit_project_name" name="edit_project_name" class="form-control py-4">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary update_project_btn" id="update_project">Update</button>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js"></script>
<script>
  var table;
  $(document).ready(function() {
        table = $('#documentsTable').DataTable({
          dom: 'Bfrtip',
          paging: true, // Enable pagination


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
              console.log(response, 'RESPONSE');
              // var response = {
              //   'status': 'success',
              //   'message': 'Project inserted successfully.'
              // };

              var data = JSON.parse(response);
              $('.success_msg').text(data.message);
              $('.success_msg').show();

              setTimeout(function() {
                $('.success_msg').fadeOut();
                $('.error_msg').fadeOut();
              }, 1000);
            },
            error: function(xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        });





        $('#documentsTable').on('change', '.accesskey', function() {
          var checkbox = $(this);
          var rowData = table.row($(this).closest('tr')).data();

          if (typeof rowData !== 'undefined') {
            var isChecked = checkbox.prop('checked') ? 1 : 0;
            rowData.check = isChecked;

            var dataToSend = {
              empId: checkbox.val(),
              check: isChecked
            };

            $.ajax({
              url: '<?php echo base_url("/project_active"); ?>',
              method: 'POST',
              data: dataToSend,
              success: function(response) {
                console.log(response);

              },
              error: function(xhr, status, error) {
                console.error(xhr.responseText);
              }
            });
          }
        });

        $(document).on('click', '.close_pop', function(event) {
          $('#editModal').modal('hide');
        });


        $(document).on('click', '.editBtn', function(event) {
          // e.preventDefault();

          var projectId = $(this).data('project-id');
          updateModalContent(projectId);
          // alert(projectId);
        });


        function updateModalContent(projectId) {
          $.ajax({
            url: '<?php echo base_url("project_edit"); ?>', // Replace with your server-side script to fetch project data
            method: 'POST',
            data: {
              project_id: projectId
            },
            success: function(response) {
              $('#edit_project_name').val(response.project_name);
              // console.log(d);
              $('#edit_project_id').val(response.project_id);
              $('#editModal').modal('show');
            },
            error: function(xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }









        $('#editModal').on('click', '#update_project', function() {
          var editedProjectName = $('#edit_project_name').val();
          var editedProject_id = $('#edit_project_id').val();
          // console.log(editedProjectName);
          // console.log(editedProject_id);
          // AJAX request to update the project name
          $.ajax({

            url: '<?php echo base_url("update_project_name"); ?>', // Replace with your server-side script to update the project name
            method: 'POST',
            data: {
              project_id: editedProject_id, // Retrieve the project ID from a variable or data attribute
              project_name: editedProjectName
            },
            success: function(response) {
              if (response.success) {
                // Update was successful
                // alert(response.message);
              
                $('#editModal').modal('hide');
                location.reload();
              } else {
                // Error occurred during the update
                if (response.refresh && response.error) {
                  // Refresh the page and display the error message
                  alert(response.message);
                }
              } // Added closing brace for the if statement block

            }, // Added closing brace for the success function
            error: function(xhr, status, error) {
              console.error(xhr.responseText);
            }

          });
          });
        });
</script>

</body>

</html>