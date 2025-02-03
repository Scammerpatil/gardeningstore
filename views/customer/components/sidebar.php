<?php
$current_page = basename($_SERVER['PHP_SELF']);
$user_type = $_SESSION['user_type'] ?? 'customer';
?>

<div class="drawer-side h-[calc(100vh-10rem)] overflow-y-auto">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="menu bg-base-200 text-base-content h-full w-80 p-4">
        <!-- Customer Sidebar -->
        <?php if ($user_type == 'customer'): ?>
            <li class="text-lg <?= ($current_page == 'index.php') ? 'bg-primary text-white' : ''; ?>">
                <a href="index.php"><i class="fa-solid fa-store"></i> Shop</a>
            </li>
            <li class="text-lg <?= ($current_page == 'cart.php') ? 'bg-primary text-white' : ''; ?>">
                <a href="cart.php"><i class="fa-solid fa-shopping-cart"></i> Cart</a>
            </li>
            <li class="text-lg <?= ($current_page == 'orders.php') ? 'bg-primary text-white' : ''; ?>">
                <a href="orders.php"><i class="fa-solid fa-box"></i> My Orders</a>
            </li>
            <li class="text-lg <?= ($current_page == 'hire_gardener.php') ? 'bg-primary text-white' : ''; ?>">
                <a href="hire_gardener.php"><i class="fa-solid fa-user-tie"></i> Hire a Gardener</a>
            </li>
            <li class="text-lg <?= ($current_page == 'sellplant.php') ? 'bg-primary text-white' : ''; ?>">
                <a href="sellplant.php"><i class="fa-solid fa-seedling"></i> Sell Plant</a>
            </li>
        <?php endif; ?>

        <li class="menu-title">Account</li>
        <li class="text-lg <?= ($current_page == 'profile.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
        </li>
        <li class="text-lg">
            <a href="../../server/logout.php" class="text-red-500"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</div>