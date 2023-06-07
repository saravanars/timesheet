<style>

@import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap");

:root {
          --bg:#ebf0f7;
          --header:#fbf4f6;
        }





  body {
    width: 100%;
    height: 100vh;
    font-family: "proxima-nova", sans-serif;
    font-size: 12px;
    background-color: var(--bg);
    color:#000;

}


a.nav-link.nav-item {
    text-decoration: none;
}

a.nav-link.n.av-item {
    text-decoration: none;
}

    .nav-wrapper {
        display: flex;
 
        position: relative;

    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: space-between;
    margin: auto;
    width: 90%;
    height: 80px;
    border-radius: 15px;
    padding: 0 25px;
    z-index: 2;
    background: #fff;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    /* margin-bottom: 100px; */
    top: 3%;
    left: -2%;
    }

    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo {
        height: 60px;
    }

    .nav-tabs {
        display: flex;
        font-weight: 600;
        font-size: 18px;
        list-style: none;
    }

    .nav-tab:not(:last-child) {
        padding: 10px 25px;
        margin: 0;
        border-right: 1px solid #eee;
    }

    .nav-tab:last-child {
        padding: 10px 0 0 25px;
    }

    .nav-tab,
    .menu-btn {
        cursor: pointer;
    }

    .hidden {
        display: none;
    }

    @media screen and (max-width: 800px) {
        .nav-container {
            position: fixed;
            display: none;
            overflow-y: auto;
            z-index: -1;
            top: 0;
            right: 0;
            width: 280px;
            height: 100%;
            background: #fff;
            box-shadow: -1px 0 2px rgba(0, 0, 0, 0.2);
        }

        .nav-tabs {
            flex-direction: column;
            align-items: flex-end;
            margin-top: 80px;
            width: 100%;
        }

        .nav-tab:not(:last-child) {
            padding: 20px 25px;
            margin: 0;
            border-right: unset;
            border-bottom: 1px solid #f5f5f5;
        }

        .nav-tab:last-child {
            padding: 15px 25px;
        }
        
  

    }
</style>


<header>

        <div class="nav-wrapper">
            <div class="logo-container">
                
           
                <img class="logo" src="https://www.itflexsolutions.com/wp-content/uploads/2020/01/New-Project-3.png" alt="Logo">
            </div>
            <nav>
                <input class="hidden" type="checkbox" id="menuToggle">
                <label class="menu-btn" for="menuToggle">
                    <div class="menu"></div>
                    <div class="menu"></div>
                    <div class="menu"></div>
                </label>
                <div class="nav-container">
                    <ul class="nav-tabs">
 
                     

                    <li class="nav-tab hidden-tab" href=""><a class="nav-link nav-item"  href="<?= base_url('/user_dashbaord') ?>">Dashboard</a></li>

                        <li class="nav-tab"href=""><a class="nav-link nav-item" href="<?= base_url('mytimesheet') ?>">Mytimesheets</a></li>
                        <li class="nav-tab" href=""><a class="nav-link n  av-item" href="<?= base_url('/logout') ?>">Logout</a></li>
                     
                    </ul>
                </div>
            </nav>
        </div>
    </header>