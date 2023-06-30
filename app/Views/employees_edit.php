<!DOCTYPE html>
<html>

<head>
  <title>Permission</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
      width: 50%;
      display: block;
      margin: 0 auto;
  }

  .submit_btn{
    color: #ffffff;
    border-radius: 5px;
    margin-top: 1rem;
    width: 100%;
    padding: 1rem;
    height: auto;
    background-color: #171717;
  }

  .emp__from{
    margin-top: 7rem;
  }
</style>


<body>

  <div id="wrapper">
    <?php include('Common/Admin/navbar.php') ?>
    <form action="<?php echo base_url('employees_update'); ?>" method="post" class="container emp__from">
    <div class="project_card_section">
      <div class="project_card">
     <?php foreach ($employees as $employee) : ?>
      <label for="employee_name">Employee Name</label>
      <input type="text" name="employee_name" class="form-control mb-4" id="employee_name" value="<?php echo $employee['name']; ?>">
      <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $employee['emp_id']; ?>">
     <span id="employee_name_error" class="error"></span>
    <label>Team Name</label>
    <select name="team_id" class="form-control mb-4" id="team_id">
      <option value="">Select Employee Name</option>
      <?php foreach ($team_master as $data) : ?>
        <option value="<?php echo $data['team_id']; ?>" <?php echo ($data['team_id'] == $employee['team_id']) ? 'selected' : ''; ?>><?php echo ucfirst($data['team_name']); ?></option>
      <?php endforeach; ?>
    </select>
    <span id="team_id_error" class="error"></span>

    <label>Email</label>
    <input type="email" name="employee_email" class="form-control mb-4" id="employee_email" value="<?php echo $employee['email']; ?>">
    <span id="employee_email_error" class="error"></span>

    <label>Role</label>
    <select name="role_id" class="form-control mb-4" id="role_id">
      <option value="1" <?php echo ($employee['role_id'] == 1) ? 'selected' : ''; ?>>Employee</option>
      <option value="2" <?php echo ($employee['role_id'] == 2) ? 'selected' : ''; ?>>Admin</option>
    </select>
    <span id="role_id_error" class="error"></span>

    <button type="submit" class="submit submit_btn" id="submit">Submit</button>

 <!-- Add a separator between each employee form -->
  <?php endforeach; ?>
      </div>
      </div>
</form>



<script>
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
