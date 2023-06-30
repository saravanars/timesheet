<!DOCTYPE html>
<html>

<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
</head>
<style>
  * {
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
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

  .beforeday_btn {
    width: 15% !important;
    margin: 0;
    margin-left: 94px;
    margin-right: -13px;
  }

  .success_msg {
    display: none;
    background-color: #3bbf52;
    padding: 0px;
    font-size: 10px;
    text-align: center;
    margin-top: 10px;
    border-radius: 5px;
  }
</style>

<body>
  <div id="wrapper">
    <?php include('Common/Admin/navbar.php') ?>
    <div id="page-wrapper">
      <div class="container-fluid">
        <div class="mb-4">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <h2>Reports</h2>

            </h3>
            <hr>
          </div>
        </div>
        <div class="fliter">
          <form id="searchForm" action="">
            <div class="container filter-form">
              <div class="form-group">
                <label>From Date</label>
                <input type="date" class="form-control date-range-filter" name="fromdate" id="fromdate" placeholder="From Date" value="">
              </div>
              <div class="form-group">
                <label>To Date</label>
                <input type="date" class="form-control date-range-filter" id="todate" name="todate" placeholder="To Date" value="">
              </div>
              <div class="form-group">
                <button type="submit" class="form-control" id="search">Search</button>
              </div>
              <div class="form-group">
                <label>Employee:</label>
                <select name="Employee" class="form-control" id="emps">
                  <option value="">Select Employee Name</option>
                  <?php foreach ($data as $data) : ?>
                    <?php if ($data['role_id'] == 1) : ?>
                      <option value="<?php echo $data['emp_id']; ?>"><?php echo ucfirst($data['name']); ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Project Name:</label>
                <select name="project_name" class="form-control" id="project_name">
                  <option value="">Select Project Name</option>
                  <?php foreach ($row as $row) : ?>
                    <option value="<?php echo $row['project_id']; ?>"><?php echo ucfirst($row['project_name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="form-control " id="pdf">Export PDF</button>
              </div>
              <div class="form-group">
                <button type="submit" class="form-control" id="csv">Export CSV</button>
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="form-control beforeday_btn" id="yesterday">
                <i class="fa fa-envelope"></i> Yesterday working hours reports
              </button>
              <p class="success_msg">Mail sented successfully.</p>
            </div>




            <div class="form-group">
              <button type="submit" class="form-control beforeday_btn" id="below_working_hours">
                <i class="fa fa-envelope"></i> below working hours
              </button>

          </form>
        </div>

        <div class="container">
          <div class="col-lg-12 col-md-12 col-xs-12 js-content">
            <div class="docs-table">
              <table id="documentsTable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Project</th>
                    <th>Team</th>
                    <th>Module</th>
                    <th>Task</th>
                    <th>Hours</th>
                    <th>Status</th>

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($employees_report_details as $employees_reports) :    ?>

                    <tr> <?php $date = date('d-m-Y', strtotime($employees_reports['report_time'])); ?>
                      <td><?php echo $date;   ?></td>
                      <td><?php echo ucfirst($employees_reports['name']); ?></td>
                      <td><?php echo $employees_reports['project_name']; ?></td>
                      <td><?php echo $employees_reports['team_name']; ?></td>
                      <td><?= ucfirst($employees_reports['module']) ?></td>
                      <td class="task"><?= ucfirst(htmlspecialchars_decode($employees_reports['task'])) ?></td>
                      <td><?= $employees_reports['hours'] ?></td>
                      <td><?= ucfirst($employees_reports['status']) ?></td>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


  <script>
    var table;

    $(document).ready(function() {
      table = $('#documentsTable').DataTable({
        dom: 'Bfrtip',
        order: [
          [0, 'desc']
        ]
      });

      $('#emps').on('change', function() {
        var empid = $('#emps option:selected').text();
        console.log(empid);

        if (empid == 'Select Employee Name') {
          table.column(1).search('').draw();
        } else {
          table.column(1).search(empid).draw();
        }
      });

      $('#project_name').on('change', function() {
        var terms = $('#project_name option:selected').text();
        console.log(terms);

        if (terms == 'Select Project Name') {
          location.reload();
        } else {
          table.column(2).search(terms).draw();
        }
      });

      $('#searchForm').on('submit', function(event) {
        event.preventDefault();
        var fromDate = $('#fromdate').val();
        var toDate = $('#todate').val();

        if (validateDates(fromDate, toDate)) {
          table.draw();
        } else {
          event.preventDefault();
        }
      });

      function validateDates(fromDate, toDate) {
        var fromDateObj = new Date(fromDate);
        var toDateObj = new Date(toDate);

        if (fromDateObj > toDateObj) {
          alert('From date must be before the To date.');
          return false;
        } else {
          return true;
        }
      }

      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var min = $('#fromdate').val();
        var max = $('#todate').val();
        var createdAt = data[0] || '';

        if ((min == '' || max == '') || (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))) {
          return true;
        }
        return false;
      });

      $('.date-range-filter').change(function() {
        table.draw();
      });






      $('#pdf').on('click', function() {
        var url = "<?php echo base_url(); ?>"
        var fromDate = ($('#fromdate').val() == '') ? 0 : $('#fromdate').val();
        var toDate = ($('#todate').val() == '') ? 0 : $('#todate').val();
        var Employee = ($('#emps').val() == '') ? 0 : $('#emps').val();
        var project_name = ($('#project_name').val() == '') ? 0 : $('#project_name').val();

        validateDates(fromDate, toDate);

        if (validateDates(fromDate, toDate)) {
          var url_ = url + 'admin/filter/' + fromDate + '/' + toDate + '/' + Employee + '/' + project_name;
          window.open(url_, "_blank");
        } else {

        }
      });


      $('#csv').on('click', function() {
        var url = "<?php echo base_url(); ?>"
        var fromDate = ($('#fromdate').val() == '') ? 0 : $('#fromdate').val();
        var toDate = ($('#todate').val() == '') ? 0 : $('#todate').val();
        var Employee = ($('#emps').val() == '') ? 0 : $('#emps').val();
        var project_name = ($('#project_name').val() == '') ? 0 : $('#project_name').val();

        validateDates(fromDate, toDate);

        if (validateDates(fromDate, toDate)) {
          var url_ = url + 'admin/csv/' + fromDate + '/' + toDate + '/' + Employee + '/' + project_name;
          window.open(url_, "_blank");
        } else {
          //     alert('hmk.');
        }
      });




      $('#yesterday').on('click', function() {
        var yesterday = 1;


        $.ajax({
          url: "<?php echo base_url("daily_working_hours"); ?>",
          method: 'GET',
          data: {
            yesterday: yesterday
          },
          success: function(response) {
            var response = {
              'status': 'success',
              'message': 'Project inserted successfully.'
            };

            var message = response.message;
            var responseElement = $("<div>").text(message);
            $("#page-wrapper").append(responseElement);

            // Add class based on response status


            $("body").append(responseElement);

            setTimeout(function() {
              $('.success_msg').fadeOut();
            }, 1000);

          },
          error: function(xhr, status, error) {
            // Handle AJAX error if needed
          }
        });





      })

    })


    $('#below_working_hours').on('click', function() {
      var yesterday = 2;


      $.ajax({
        url: "<?php echo base_url("below_hours"); ?>",
        method: 'GET',
        data: {
          yesterday: yesterday
        },
        success: function(response) {
          var response = {
            'status': 'success',
            'message': 'Project inserted successfully.'
          };

          var message = response.message;
          var responseElement = $("<div>").text(message);
          $("#page-wrapper").append(responseElement);

          // Add class based on response status


          $("body").append(responseElement);

          setTimeout(function() {
            $('.success_msg').fadeOut();
          }, 1000);

        },
        error: function(xhr, status, error) {
          // Handle AJAX error if needed
        }



      });


    });
  </script>
</body>

<script>
  function viewTodayData(date, empId, Id) {
    var today = date;
    var empId = empId;
    var Id = Id;
    window.location.href = "<?= site_url('adminview/') ?>" + today + "/" + empId + "/" + Id;
  }


  function logout() {

    window.location.href = "<?= base_url('/logout') ?>";
  }
</script>

</html>