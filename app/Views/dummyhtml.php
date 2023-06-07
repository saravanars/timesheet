<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet Form</title>
    <style>
      body {
        font-family: Arial, sans-serif;
      }
      .timesheet-form {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }
      .timesheet-table {
        width: 100%;
        border-collapse: collapse;
      }
      .timesheet-table th, .timesheet-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 14px;
      }
      .timesheet-table th {
        background-color: #f2f2f2;
        font-weight: bold;
      }
      .timesheet-table td input[type="text"], .timesheet-table td input[type="date"], .timesheet-table td input[type="number"], .timesheet-table td select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
      }
      .timesheet-table td select {
        cursor: pointer;
      }
      .timesheet-table td button {
        padding: 5px 10px;
        background-color: #FF0000;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
      }
      .timesheet-table td button:hover {
        background-color: #CC0000;
      }
      .add-entry-button {
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
      }
      .add-entry-button:hover {
        background-color: #45a049;
      }
      .submit-button {
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #008CBA;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
      }
      .submit-button:hover {
        background-color: #006380;
      }
      @media screen and (max-width: 600px) {
        .timesheet-table th, .timesheet-table td {
          font-size: 12px;
        }
        .add-entry-button, .submit-button {
          font-size: 14px;
        }
      }
    </style>
  </head>
  <body>
    <div class="timesheet-form">
      <table class="timesheet-table">
        <thead>
          <tr>
            <th>Project</th>
            <th>Module</th>
            <th>Description</th>
            <th>Status</th>
            <th>Date</th>
            <th>Hours Worked</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="timesheet-body">
          <tr>
          <td>
              <input type="text" name="project[]" placeholder="Project">
            </td>
            <td>
              <input type="text" name="module[]" placeholder="Module">
            </td>
            <td>
              <input type="text" name="description[]" placeholder="Description">
            </td>
            <td>
              <select name="status[]">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
              </select>
            </td>
            <td>
              <input type="date" name="date[]" placeholder="Date"  value="<?php print(date("Y-m-d")); ?>">
            </td>
            <td>
              <input type="number" name="hours[]" placeholder="Hours" min="1" max="2">
            </td>
            <td>
              <button class="delete-entry">-</button>
            </td>
          </tr>
        </tbody>
      </table>
      <button class="add-entry-button">Add Entry</button>
      <button class="submit-button">Submit</button>
    </div>

    <script>
   
   // Function to handle adding a new entry
function addEntry() {
  var timesheetBody = document.getElementById("timesheet-body");

  // Create a new entry row
  var entryRow = document.createElement("tr");

  // Create cells for the new entry
  var projectCell = createCell("text", "project[]", "Project");
  var moduleCell = createCell("text", "module[]", "Module");
  var descriptionCell = createCell("text", "description[]", "Description");
  var statusCell = createStatusCell();
  var dateCell = createCell("date", "date[]", "");
  var hoursCell = createCell("number", "hours[]", "Hours");
  var deleteCell = createDeleteCell(entryRow);

  // Append cells to the entry row
  entryRow.appendChild(projectCell);
  entryRow.appendChild(moduleCell);
  entryRow.appendChild(descriptionCell);
  entryRow.appendChild(statusCell);
  entryRow.appendChild(dateCell);
  entryRow.appendChild(hoursCell);
  entryRow.appendChild(deleteCell);

  // Add the new entry row to the timesheet body
  timesheetBody.appendChild(entryRow);
}

// Function to create a cell with an input field
function createCell(type, name, placeholder) {
  var cell = document.createElement("td");
  var input = document.createElement("input");
  input.type = type;
  input.name = name;
  input.placeholder = placeholder;
  input.className = "entry-input";
  cell.appendChild(input);
  return cell;
}


// Function to create the status cell with a dropdown
function createStatusCell() {
  var cell = document.createElement("td");
  var select = document.createElement("select");
  select.name = "status[]";
  select.className = "entry-input";
  var statusOptions = ["Pending", "In Progress", "Completed"];
  for (var i = 0; i < statusOptions.length; i++) {
    var option = document.createElement("option");
    option.value = statusOptions[i];
    option.text = statusOptions[i];
    select.appendChild(option);
  }
  cell.appendChild(select);
  return cell;
}

// Function to create the delete cell with a delete button
function createDeleteCell(row) {
  var cell = document.createElement("td");
  var deleteButton = document.createElement("button");
  deleteButton.className = "delete-entry";
  deleteButton.innerText = "-";
  deleteButton.addEventListener("click", function() {
    row.remove();
  });
  cell.appendChild(deleteButton);
  return cell;
}

// Add event listener to the "Add Entry" button
document.querySelector(".add-entry-button").addEventListener("click", addEntry);

// Event delegation to handle delete button clicks
document.addEventListener("click", function(event) {
  if (event.target.classList.contains("delete-entry")) {
    var row = event.target.parentNode.parentNode;
    row.remove();
  }
});

// Add event listener to the "Submit" button (for demonstration purposes)
document.querySelector(".submit-button").addEventListener("click", function() {
  var formData = new FormData(document.querySelector("form"));
  for (var pair of formData.entries()) {
    console.log(pair[0] + ": " + pair[1]);
  }
});


      </script> 
<!DOCTYPE html>
<html>
<head>

  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/components/accordion.min.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/components/accordion.min.js"></script>

  <script>
    $(document).ready(function() {
      // Initialize Select2
      $(".js-example-basic-single").select2();

      // Initialize Semantic UI accordion
      $('.ui.accordion').accordion();
    });
    function addEntry() {
  var timesheetBody = document.getElementById("timesheet-body");

  // Create a new entry row
  var entryRow = document.createElement("tr");

  // Create cells for the new entry
  var projectCell = createCell("text", "project", "Project");
  var moduleCell = createCell("text", "module", "Module");
  var descriptionCell = createCell("text", "description", "Description");
  var statusCell = createStatusCell();
  var dateCell = createCell("date", "date[]", "");
  var hoursCell = createCell("number", "hours[]", "Hours");
  var deleteCell = createDeleteCell(entryRow);

  // Append cells to the entry row
  entryRow.appendChild(projectCell);
  entryRow.appendChild(moduleCell);
  entryRow.appendChild(descriptionCell);
  entryRow.appendChild(statusCell);
  entryRow.appendChild(dateCell);
  entryRow.appendChild(hoursCell);
  entryRow.appendChild(deleteCell);

  // Add the new entry row to the timesheet body
  timesheetBody.appendChild(entryRow);
}

// Function to create a cell with an input field
function createCell(type, name, placeholder) {
  var cell = document.createElement("td");
  var input = document.createElement("input");
  input.type = type;
  input.name = name;
  input.placeholder = placeholder;
  input.className = "entry-input";
  cell.appendChild(input);
  return cell;
}


// Function to create the status cell with a dropdown
function createStatusCell() {
  var cell = document.createElement("td");
  var select = document.createElement("select");
  select.name = "status[]";
  select.className = "entry-input";
  var statusOptions = ["Pending", "In Progress", "Completed"];
  for (var i = 0; i < statusOptions.length; i++) {
    var option = document.createElement("option");
    option.value = statusOptions[i];
    option.text = statusOptions[i];
    select.appendChild(option);
  }
  cell.appendChild(select);
  return cell;
}

// Function to create the delete cell with a delete button
function createDeleteCell(row) {
  var cell = document.createElement("td");
  var deleteButton = document.createElement("button");
  deleteButton.className = "delete-entry";
  deleteButton.innerText = "-";
  deleteButton.addEventListener("click", function() {
    row.remove();
  });
  cell.appendChild(deleteButton);
  return cell;
}

// Add event listener to the "Add Entry" button
document.querySelector(".add-entry-button").addEventListener("click", addEntry);

// Event delegation to handle delete button clicks
document.addEventListener("click", function(event) {
  if (event.target.classList.contains("delete-entry")) {
    var row = event.target.parentNode.parentNode;
    row.remove();
  }
});

// Add event listener to the "Submit" button (for demonstration purposes)
document.querySelector(".submit-button").addEventListener("click", function() {
  var formData = new FormData(document.querySelector("form"));
  for (var pair of formData.entries()) {
    console.log(pair[0] + ": " + pair[1]);
  }
});

  </script>
    <style>
  /* Body styles */
body {
  font-family: 'Roboto', sans-serif;
  margin: 0;
  padding: 0;
}

/* Page title styles */
.maintitle {
  font-size: 24px;
  font-weight: 700;
  text-align: center;
}

/* Timesheet navigation styles */
.timesheet-navigation {
  margin-bottom: 20px;
}

.nav-tabs {
  border-bottom: none;
}

.nav-tabs > li > a {
  font-weight: 700;
  padding: 10px 20px;
}

.nav-tabs > li.active > a,
.nav-tabs > li.active > a:hover,
.nav-tabs > li.active > a:focus {
  background-color: #f5f5f5;
  border: none;
}

/* Timesheet buttons styles */
.timesheet-buttons {
  margin-bottom: 20px;
}

.today-timesheet {
  text-align: right;
  margin-bottom: 10px;
}

.newmsgb,
.add-task-timesheet {
  font-weight: 700;
  padding: 10px 20px;
  margin-left: 10px;
}

/* Picked day styles */
.picked-day {
  font-weight: 700;
  text-align: center;
}

/* Timesheet table styles */
.tab-title {
  margin-top: 20px;
}

.statustitle,
.projectnametitle,
.completiontitle,
.detailstitle {
  font-weight: 700;
  text-align: center;
}

.tsdelete-row {
  text-align: center;
  cursor: pointer;
}

.timesheet-task-row {
  border-top: 1px solid #ccc;
  margin-top: 10px;
  padding-top: 10px;
}

/* Add Task modal styles */
.modal-title {
  font-weight: 700;
  text-align: center;
}

.modal-body {
  padding: 20px;
}

.actionbutton {
  text-align: right;
}

.button-container {
  margin-top: 20px;
}

.user-aciton {
  font-weight: 700;
  padding: 10px 20px;
}

/* Select2 styles */
.select2-container {
  width: 100% !important;
}

.select2-selection {
  height: 34px !important;
}

.select2-selection__arrow {
  height: 34px !important;
}

.select2-selection__rendered {
  line-height: 34px !important;
}

.select2-container .select2-selection--single {
  border: none !important;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder {
  color: #999;
}

  </style>
</head>

<body>
  <div>
    <p class="maintitle">Timesheet</p>
  </div>

  <section class="timesheet-navigation">
    <div class="nav">
      <div class="container-fluid nopaddingmail">
        <div class="tabbable">
          <ul class="nav nav-tabs" data-tabs="tabs" id="myTab">
            <li class="active"><a data-toggle="tab" href="#incoming">Current</a></li>
            <li><a data-toggle="tab" href="#sentmsg">Previous</a></li>
            <li><a data-toggle="tab" href="#sentmsg">Not Sent</a></li>
            <li><a data-toggle="tab" href="#sentmsg">Wait for Accept</a></li>
            <li><a data-toggle="tab" href="#sentmsg">Accepted</a></li>
            <li><a data-toggle="tab" href="#sentmsg">Rejected</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="incoming">
              <!-- Tab content goes here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="timesheet-buttons">
    <input type="date" id="theDate">
    <div class="today-timesheet">
      <button type="button" class="newmsgb">Today</button>
      <button type="button" class="add-task-timesheet" data-toggle="modal" data-target="#addtask">Add New Task</button>
    </div>
  </section>

  <section style="margin-top: -40px">
    <p class="picked-day">2016-12-30</p>
  </section>

  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 tab-title">
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-1">
              <div class="statustitle">Project</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="projectnametitle">Task</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="completiontitle">Date</div>
            </div>
            <div class="col-md-2 col-sm-2 col
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="detailstitle">Start Date/End Date</div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
              <div class="detailstitle">Duration</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="detailstitle">Description</div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
              <div class="tsdelete-row"></div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </section>

  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="row timesheet-task-row">
            <div class="col-md-2 col-sm-2 col-xs-1">
              <div class="statustitle">Project 1</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="projectnametitle">Task 1</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="completiontitle">2016-12-12</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="detailstitle">12:00/13:00</div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
              <div class="detailstitle">1 Hr.</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="detailstitle">Really hard work.</div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
              <div class="tsdelete-row">x</div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </section>

  <!-- Modal -->
  <div id="addtask" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content timesheet">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Task</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <p>Project</p>
                  </div>
                  <div class="col-md-9">
                    <select class="js-example-basic-single">
                      <option>Project1</option>
                      <option>Project2</option>
                      <option>Project3</option>
                      <option>Project4</option>
                      <option>Project5</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>Status</p>
</div>
                  <div class="col-md-9">
                    <select class="js-example-basic-single" name="status[]"  >
                    <option value="Pending">None</option>
                    <option value="Pending">Analysis</option>
                      <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>Date</p>
                  </div>
                  <div class="col-md-9">
                    <input type="date">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>Hours</p>
                  </div>
                  <div class="col-md-9">
                    <input type="number" name="hours[]" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>End Time</p>
                  </div>
                  <div class="col-md-9">
                    <input type="time" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>Description</p>
                  </div>
                  <div class="col-md-9">
                    <input type="text" class="timesheet-description"/ name="description">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                  </div>
                  <div class="col-md-9">
                    <div clas="actionbutton">
                      <p class="button-container"><button class="user-aciton">Add Task</button></p>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
------------------------------
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">honme</a>
        <a class="navbar-brand" href="#">Dashboard</a>
        <a class="navbar-brand" href="#">Logout</a>
        <!-- <a class="navbar-brand" href="#">Timesheet</a> -->
      </div>
    </div>
  </nav>

  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <h3>Daily Timesheet</h3>
        <form id="timesheetForm">
          <div class="form-group">
        
            <label for="status"></label>
            <label for="status"></label>
            <select class="form-control" id="status">
            <select class="js-example-basic-single">
                      <option>Project1</option>
                      <option>Project2</option>
                      <option>Project3</option>
                      <option>Project4</option>
                      <option>Project5</option>
                    </select>
              <option value="pending">Pending</option>
              <option value="completed">Completed</option>
              <option value="in-progress">In Progress</option>
            </select>
          </div>
          <div class="form-group">
            <label for="theDate">Date:</label>
            <input type="date" class="form-control" id="theDate">
          </div>

          <div class="form-group">
            <label for="hours">Hours:</label>
            <input type="text" class="form-control" id="hours">
          </div>

          <div class="form-group">
            <label for="status"></label>
            <label for="status">Status:</label>
            <select class="form-control" id="status">
              <option value="pending">Pending</option>
              <option value="completed">Completed</option>
              <option value="in-progress">In Progress</option>
            </select>
          </div>

          <div class="form-group">
          <label for="story">Description:</label>

<textarea id="story"  class="form-control" name="story"id="description"
          rows="5" cols="33">
</textarea>

            <input type="textarea" class="form-control" id="description">
          </div>

          <button type="button" class="btn btn-primary" id="addTaskBtn">Add Task</button>
          <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3>Task List</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Project</th>
              <th>Task</th>
              <th>Date</th>
              <th>Start Time / End Time</th>
              <th>Duration</th>
              <th>Description</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="taskList">
            <!-- Task rows will be dynamically added here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Counter for generating unique task IDs
      let taskIdCounter = 0;

      // Event handler for add task button
      $("#addTaskBtn").click(function(e) {
        e.preventDefault();

        // Get input values
        const project = $("#project").val();
        const task = $("#task").val();
        const date = $("#theDate").val();
        const startTime = $("#startTime").val();
        const endTime = $("#endTime").val();
        const duration = $("#duration").val();
        const description = $("#description").val();

        // Generate unique task ID
        const taskId = "task" + taskIdCounter++;
        
        // Create new task row
        const newRow = `
          <tr id="${taskId}">
            <td>${project}</td>
            <td>${task}</td>
            <td>${date}</td>
            <td>${startTime} / ${endTime}</td>
            <td>${duration}</td>
            <td>${description}</td>
            <td>
              <button class="btn btn-danger btn-delete" data-taskid="${taskId}">Delete</button>
            </td>
          </tr>
        `;

        // Append new task row to the table
        $("#taskList").append(newRow);

        // Clear input fields
        $("#project").val("");
        $("#task").val("");
        $("#theDate").val("");
        $("#startTime").val("");
        $("#endTime").val("");
        $("#duration").val("");
        $("#description").val("");
      });

      // Event handler for delete task button
      $(document).on("click", ".btn-delete", function() {
        const taskId = $(this).data("taskid");
        $("#" + taskId).remove();
      });

      // Event handler for form submission
      $("#timesheetForm").submit(function(e) {
        e.preventDefault();

        // Get all task data
        const tasks = [];
        $("#taskList tr").each(function() {
          const taskId = $(this).attr("id");
          const project = $(this).find("td:nth-child(1)").text();
          const task = $(this). find("td:nth-child(2)").text();
          const date = $(this).find("td:nth-child(3)").text();
          const startTime = $(this).find("td:nth-child(4)").text().split(" / ")[0];
          const endTime = $(this).find("td:nth-child(4)").text().split(" / ")[1];
          const duration = $(this).find("td:nth-child(5)").text();
          const description = $(this).find("td:nth-child(6)").text();

          const taskData = {
            taskId: taskId,
            project: project,
            task: task,
            date: date,
            startTime: startTime,
            endTime: endTime,
            duration: duration,
            description: description
          };

          tasks.push(taskData);
        });

        // Perform further processing or submit the form data
        console.log(tasks);
        // Uncomment the following line to submit the form data
        // $("#timesheetForm").submit();
      });
    });
  </script>
</body>
</html>
------------------------------
<!DOCTYPE html>
<html>
<head>

  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/components/accordion.min.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/components/accordion.min.js"></script>


    <style>
  /* Body styles */
body {
  font-family: 'Roboto', sans-serif;
  margin: 0;
  padding: 0;
}

/* Page title styles */
.maintitle {
  font-size: 24px;
  font-weight: 700;
  text-align: center;
}

/* Timesheet navigation styles */
.timesheet-navigation {
  margin-bottom: 20px;
}

.nav-tabs {
  border-bottom: none;
}

.nav-tabs > li > a {
  font-weight: 700;
  padding: 10px 20px;
}

.nav-tabs > li.active > a,
.nav-tabs > li.active > a:hover,
.nav-tabs > li.active > a:focus {
  background-color: #f5f5f5;
  border: none;
}

/* Timesheet buttons styles */
.timesheet-buttons {
  margin-bottom: 20px;
}

.today-timesheet {
  text-align: right;
  margin-bottom: 10px;
}

.newmsgb,
.add-task-timesheet {
  font-weight: 700;
  padding: 10px 20px;
  margin-left: 10px;
}

/* Picked day styles */
.picked-day {
  font-weight: 700;
  text-align: center;
}

/* Timesheet table styles */
.tab-title {
  margin-top: 20px;
}

.statustitle,
.projectnametitle,
.completiontitle,
.detailstitle {
  font-weight: 700;
  text-align: center;
}

.tsdelete-row {
  text-align: center;
  cursor: pointer;
}

.timesheet-task-row {
  border-top: 1px solid #ccc;
  margin-top: 10px;
  padding-top: 10px;
}

/* Add Task modal styles */
.modal-title {
  font-weight: 700;
  text-align: center;
}

.modal-body {
  padding: 20px;
}

.actionbutton {
  text-align: right;
}

.button-container {
  margin-top: 20px;
}

.user-aciton {
  font-weight: 700;
  padding: 10px 20px;
}

/* Select2 styles */
.select2-container {
  width: 100% !important;
}

.select2-selection {
  height: 34px !important;
}

.select2-selection__arrow {
  height: 34px !important;
}

.select2-selection__rendered {
  line-height: 34px !important;
}

.select2-container .select2-selection--single {
  border: none !important;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder {
  color: #999;
}

  </style>
</head>

<body>
  <div>
    <p class="maintitle">Timesheet</p>
  </div>

  

  <section class="timesheet-buttons">
    <input type="date" id="theDate">
    <div class="today-timesheet">
      <button type="button" class="newmsgb">Today</button>
      <button type="button" class="add-task-timesheet" data-toggle="modal" data-target="#addtask">Add New Task</button>
    </div>
  </section>

  <section style="margin-top: -40px">
  </section>

  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 tab-title">
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-1">
              <div class="statustitle">Project</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="projectnametitle">Task</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="completiontitle">Date</div>
            </div>
            <div class="col-md-2 col-sm-2 col
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="detailstitle">Start Date/End Date</div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
              <div class="detailstitle">Duration</div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="detailstitle">Description</div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
              <div class="tsdelete-row"></div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </section>

  

  <!-- Modal -->
  <div id="addtask" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content timesheet">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Task</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <p>Project</p>
                  </div>
                  <div class="col-md-9">
                    <select class="js-example-basic-single">
                      <option>Project1</option>
                      <option>Project2</option>
                      <option>Project3</option>
                      <option>Project4</option>
                      <option>Project5</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>Status</p>
</div>
                  <div class="col-md-9">
                    <select class="js-example-basic-single" name="status[]"  >
                    <option value="Pending">None</option>
                    <option value="Pending">Analysis</option>
                      <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>Date</p>
                  </div>
                  <div class="col-md-9">
                    <input type="date" name="data" value="<?php print(date("Y-m-d")); ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>Hours</p>
                  </div>
                  <div class="col-md-9">
                    <input type="number" name="hours[]" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p></p>
                  </div>
                  <div class="col-md-9">
                    <input type="time" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <p>Description</p>
                  </div>
                  <div class="col-md-9">
                    <input type="text" class="timesheet-description" name="description[]">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                  </div>
                  <div class="col-md-9">
                    <div clas="actionbutton">
                      <p class="button-container"><button class="user-aciton">Add Task</button></p>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/components/accordion.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize Select2
    $(".js-example-basic-single").select2();

    // Initialize Semantic UI accordion
    $('.ui.accordion').accordion();
  });


  // ...

  // Add event listener to the "Add Task" button in the modal
  document.querySelector(".user-aciton").addEventListener("click", function() {
    addEntry();
    // Clear the modal inputs
    clearModalInputs();
    // Close the modal
    document.getElementById("addtask").style.display = "none";
  });

  // Function to clear the modal inputs after adding a task
  function clearModalInputs() {
    document.querySelector(".js-example-basic-single").value = "";
    document.querySelector(".js-example-basic-single[name='status[]']").value = "Pending";
    document.querySelector("input[name='date']").value = "";
    document.querySelector("input[name='hours[]']").value = "";
    document.querySelector("input[type='time'[]").value = "";
    document.querySelector(".timesheet-description").value = "";
  }

  // ...
</script>
