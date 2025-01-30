<!DOCTYPE html>
<html lang="en">
<?php include "./components/general/header.php" ?>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="img/core-img/leaf.png" alt="">
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <?php include "./components/general/navbar.php" ?>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center"
            style="background-image: url(img/bg-img/24.jpg);">
            <h2>Contact US</h2>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

    <!-- ##### Contact Area Info Start ##### -->
    <div class="contact-area-info section-padding-0-100">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <!-- Contact Thumbnail -->
                <div class="col-12 col-md-6">
                    <div class="contact--thumbnail">
                        <img src="img/bg-img/25.jpg" alt="">
                    </div>
                </div>

                <div class="col-12 col-md-5">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h2>CONTACT US</h2>
                        <p>We are improving our services to serve you better.</p>
                    </div>
                    <!-- Contact Information -->
                    <div class="contact-information">
                        <p><span>Address:</span> 505 Silk Rd, New York</p>
                        <p><span>Phone:</span> +1 234 122 122</p>
                        <p><span>Email:</span> info.deercreative@gmail.com</p>
                        <p><span>Open hours:</span> Mon - Sun: 8 AM to 9 PM</p>
                        <p><span>Happy hours:</span> Sat: 2 PM to 4 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Contact Area Info End ##### -->

    <!-- ##### Contact Area Start ##### -->
    <?php include "./components/general/contact.php" ?>
    <!-- ##### Contact Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <?php include "./components/general/footer.php" ?>
    <!-- ##### Footer Area End ##### -->

    <!-- Scripts -->
    <?php include "./components/general/scripts.php" ?>
</body>

</html>