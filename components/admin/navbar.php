<header class="header-area">
  <!-- ***** Navbar Area ***** -->
  <div class="alazea-main-menu fixed-top">
    <div class="classy-nav-container breakpoint-off">
      <div class="container">
        <!-- Menu -->
        <nav class="classy-navbar justify-content-between" id="alazeaNav">

          <!-- Nav Brand -->
          <a href="/" class="nav-brand"><span class="green">GREEN</span><span class="white">WORLD</span></a>

          <!-- Navbar Toggler -->
          <div class="classy-navbar-toggler">
            <span class="navbarToggler"><span></span><span></span><span></span></span>
          </div>

          <!-- Menu -->
          <div class="classy-menu">

            <!-- Close Button -->
            <div class="classycloseIcon">
              <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
            </div>

            <!-- Navbar Start -->
            <div class="classynav">
              <ul>
                <li><a href="">Home</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="products.php">Products</a></li>
                <?php if ($_SESSION['user_type'] === 'admin') { ?>
                  <li class="dropdown">
                    <a href="#">Admin Panel</a>
                    <ul class="dropdown-menu">
                      <li><a href="">Dashboard</a></li>
                      <li><a href="manage_users.php">Manage Users</a></li>
                      <li><a href="manage_products.php">Manage Products</a></li>
                      <li><a href="manage_orders.php">Manage Orders</a></li>
                      <li><a href="inventory.php">Inventory</a></li>
                      <li><a href="analytics.php">Reports & Analytics</a></li>
                      <li><a href="settings.php">Settings</a></li>
                    </ul>
                  </li>
                  <li><a href="logout.php">Logout</a></li>
                <?php } ?>
              </ul>
            </div>
            <!-- Navbar End -->
          </div>
        </nav>
      </div>
    </div>
  </div>
</header>

<style>
  /* Fixed Navbar */
  .alazea-main-menu {
      background-color: black !important;
      width: 100%;
      top: 0;
      left: 0;
      z-index: 1000;
      position: fixed;
  }

  .nav-brand {
      font-weight: bold;
  }

  .classynav ul li a {
      color: white !important;
  }

  .classynav ul li a:hover {
      color: #28a745 !important; /* Green color on hover */
  }

  .dropdown-menu {
      background-color: black;
  }

  .dropdown-menu li a {
      color: white !important;
  }

  .dropdown-menu li a:hover {
      background-color: #343a40;
  }

  /* Adjust body to prevent overlap with fixed navbar */
  body {
      padding-top: 60px; /* Adjust according to navbar height */
  }
</style>