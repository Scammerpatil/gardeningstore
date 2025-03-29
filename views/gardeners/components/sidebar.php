<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="drawer-side h-screen overflow-y-auto">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="menu bg-base-200 text-base-content h-full w-80 p-4">

        <!-- Gardener Dashboard -->
        <li class="text-lg <?= ($current_page == 'index.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="index.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        </li>

        <!-- Hire Requests -->
        <li class="menu-title">Hire Requests</li>
        <li class="text-lg <?= ($current_page == 'hire_requests.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="hire_requests.php"><i class="fa-solid fa-clipboard-check"></i> My Hire Requests</a>
        </li>
        <li class="text-lg <?= ($current_page == 'completed_requests.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="completed_requests.php"><i class="fa-solid fa-check-circle"></i> Completed Jobs</a>
        </li>

        <!-- Profile & Settings -->
        <li class="menu-title">Profile Management</li>
        <li class="text-lg <?= ($current_page == 'update_profile.php') ? 'bg-primary text-white' : ''; ?>">
            <a href="update_profile.php"><i class="fa-solid fa-user-edit"></i> Update Profile</a>
        </li>

    
    </ul>
</div>