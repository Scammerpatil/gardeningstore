<!DOCTYPE html>
<html lang="en" data-theme="lemonade">
<?php include '../../components/customer/Header.php'; ?>

<body style="font-family: Dosis, sans-serif;">
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <?php include '../../components/admin/Navbar.php'; ?>

            <!-- Header Image -->
            <div class="hero h-80 relative bg-overlay z-10 overflow-hidden"
                style="background-image: url(../../img/bg-img/24.jpg);">
                <div class="hero-content text-center">
                    <h1 class="text-4xl font-semibold text-white uppercase"><?= $page_title; ?></h1>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="drawer drawer-open">
                <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content px-10 py-3 overflow-y-scroll">
                    <div class="breadcrumbs text-base font-semibold">
                        <ul>
                            <li><a href="dashboard.php">Home</a></li>
                            <li><?= $page_title; ?></li>
                        </ul>
                    </div>
                    <!-- Dynamic Page Content -->
                    <div class="mt-4 overflow-y-scroll h-[calc(100vh-10rem)]"><?= $page_content; ?></div>
                </div>

                <!-- Sidebar -->
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
</body>

</html>