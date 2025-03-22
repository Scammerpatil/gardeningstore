<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="drawer-side h-screen overflow-y-auto">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="menu bg-base-200 text-base-content h-full w-80 p-4">
        <!-- Dashboard -->
        <li class="text-lg <?= ($current_page == 'index.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="index.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        </li>

        <!-- User Management -->
        <li class="menu-title">User Management</li>
        <li class="text-lg <?= ($current_page == 'customers.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="customers.php"><i class="fa-solid fa-users"></i> Customers</a>
        </li>
        <li class="text-lg <?= ($current_page == 'gardeners.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="gardeners.php"><i class="fa-solid fa-person-digging"></i> Gardeners</a>
        </li>
        <li class="text-lg <?= ($current_page == 'sellers.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="sellers.php"><i class="fa-solid fa-store"></i> Sellers</a>
        </li>

        <!-- Product & Store Management -->
        <li class="menu-title">Product Management</li>
        <li class="text-lg <?= ($current_page == 'product.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="product.php"><i class="fa-solid fa-seedling"></i> Products</a>
        </li>
        <li class="text-lg <?= ($current_page == 'orders.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="orders.php"><i class="fa-solid fa-box"></i> Orders</a>
        </li>

        <!-- Logout -->
        <li class="text-lg">
            <a href="../../server/logout.php" class="text-red-500"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</div>