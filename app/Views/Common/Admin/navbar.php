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

  .navbar::before,
  .navbar::after {
    content: "";
    display: none;
  }



  button.btn.btn-primary.table__btn.logout {
    margin-bottom: 2px;
    margin-top: 6px;
    padding: 6px;
    width: 88px;
    height: 39px;
  }


  .navbar {
    position: fixed;
    top: 0;
    width: 100%;
    background-color: #000;
    z-index: 1;
  }

  #btn_name {
    border-radius: 50px;
    font-size: 77%;
    color: #fff;
    background-color: #337ab7;

    width: 101px;
    padding: 8px;
    height: 36px;
  }

  .nav-last{
    display: flex;
    gap: 1rem;
    align-items: center;
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
<header>
  <nav class="navbar navbar-inverse navbar-fixed-top px-5" role="navigation">
    <img class="logo" src="https://www.itflexsolutions.com/wp-content/uploads/2020/01/New-Project-3.png" alt="Logo">
  

    <div class="nav-last">
    <div class="logout">

      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" id="btn_name"  data-bs-toggle="dropdown" aria-expanded="false">
        Menu
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" onclick="access()" href="#">Accesskey</a></li>
          
          <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
        </ul>
      </div>
    </div>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" id="btn_name" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php date_default_timezone_set("Asia/Kolkata");
          $h = date('G');

          if ($h >= 5 && $h <= 11) {
            echo "Good morning, ";
          } else if ($h >= 12 && $h <= 15) {
            echo "Good <br> afternoon,";
          } else {
            echo "Good evening,";
          }
          echo ucfirst($_SESSION['name']); ?>
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" onclick="logout()" href="#">Logout</a></li>
          <li><a class="dropdown-item" href="#">Another action</a></li>
          <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
        </ul>
      </div>
    </div>
  </nav>





</header>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

<script>
  function toggleLogoutList() {
    var logoutList = document.getElementById('logoutList');
    logoutList.classList.toggle('show');
  }

  function logout(){

window.location.href = "<?= base_url('/logout') ?>";
}

function access(){

window.location.href = "<?= base_url('employees_dt') ?>";
}
</script>