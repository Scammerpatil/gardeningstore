<!DOCTYPE html>
<html lang="en">
<?php include "../../components/admin/header.php" ?>

<?php
session_start();
?>

<body>
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="../../img/core-img/leaf.png" alt="">
        </div>
    </div>
    <?php include "../../components/admin/navbar.php" ?>
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center"
            style="background-image: url(../../img/bg-img/24.jpg);">
            <h2>DASHBOARD</h2>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href=""><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Portfolio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Single Portfolio</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <form action=""></form>
        </div>
    </div>

    <!-- Scripts -->
    <?php include "../../components/admin/scripts.php" ?>
</body>

</html>