<header class="header-area">
  <!-- ***** Navbar Area ***** -->
  <div class="alazea-main-menu">
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