<?php
$current_page = basename($_SERVER['PHP_SELF']);
$user_type = $_SESSION['user_type'] ?? 'customer';
?>

<div class="drawer-side h-screen overflow-y-auto">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="menu h-full w-80 p-4" style="background-color:rgb(13, 65, 13); color: white;">
        <li class="text-2xl <?= ($current_page == 'index.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="index.php"><i class="fa-solid fa-store"></i> Shop</a>
        </li>
        <li class="text-2xl <?= ($current_page == 'cart.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="cart.php"><i class="fa-solid fa-shopping-cart"></i> Cart</a>
        </li>
        <li class="text-2xl <?= ($current_page == 'orders.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="orders.php"><i class="fa-solid fa-box"></i> My Orders</a>
        </li>
        <li class="text-2xl <?= ($current_page == 'hire_gardener.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="hire_gardener.php"><i class="fa-solid fa-user-tie"></i> Hire a Gardener</a>
        </li>
        <li class="text-2xl <?= ($current_page == 'hire_gardener_status.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="hire_gardener_status.php"><i class="fa-solid fa-user-tie"></i> Hire Gardener Status</a>
        </li>
        <li class="text-2xl <?= ($current_page == 'sellplant.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="sellplant.php"><i class="fa-solid fa-seedling"></i> Sell Plant</a>
        </li>
        <li class="text-2xl <?= ($current_page == 'sellplantstatus.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="sellplantstatus.php"><i class="fa-solid fa-seedling"></i> Sell Plant Status</a>
        </li>

        <li class="menu-title text-white">Account</li>
        <li class="text-2xl <?= ($current_page == 'profile.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
        </li>
    </ul>
</div>