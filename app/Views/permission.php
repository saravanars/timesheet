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
  .switch input:checked + .slider:before {
    content: "On";
    width: fit-content;
    left: 1px;
}



.return {
  margin-top: -31px;
    margin-left: 110rem;
    margin-bottom: 25px;
}

.mb-4{
  font-weight: bold;
    font-size: 13px;
}
</style>


<body>

  <div id="wrapper">

  <div>
        
  </div>
    <?php include('Common/Admin/navbar.php') ?>

<label for="">Access for All</label>
    <label class="switch">
      
      <input type="checkbox" name="accesskey" class="accesskey_all" id="accesskey">
      <span class="slider round"></span>
    </label>


    <div class="return">
        <button class="btn btn-secondary" id="btn_name" type="button"       onclick="window.location.href='<?php echo base_url();?>/admin'"  data-bs-toggle="dropdown" aria-expanded="false" >
       Main page
      </button>
        </div>
    <div id="page-wrapper">
      <div class="container-fluid">
        <div class="mb-4">
        Timesheet Access permission setting
        </div>
   
        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 js-content">
            <div class="docs-table">
              <table id="documentsTable" class="table table-striped table-bordered">
                <thead>
                  <tr>

                    <th>Name</th>
                    <th>Team</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($employees as $row) :    ?>

                    <tr>
                      <td><?php echo ucfirst($row['name']); ?></td>
                      <td><?php echo $row['team_name']; ?></td>
                      <td> <label class="switch">
                        
                          <input type="checkbox" <?php if($row['access_key']==1) echo 'checked' ; ?> name="accesskey" class="accesskey" id="accesskey" value="('<?= $row['emp_id'] ?>')">
                          <span class="slider round"></span>
                        </label></td>

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
          [1, 'desc']
        ],
      });



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