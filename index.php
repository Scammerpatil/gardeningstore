<!DOCTYPE html>
<html lang="en">
<?php
include './components/general/header.php';
?>

<body>
    <!-- <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="img/core-img/leaf.png" alt="">
        </div>
    </div> -->
    <?php
    include './components/general/navbar.php';
    ?>
    <section class="hero-area">
        <div class="hero-post-slides owl-carousel">

            <!-- Single Hero Post -->
            <?php
            $slides = [
                ["img/bg-img/1.jpg", "Plants exist in the weather and light rays that surround them"],
                ["img/bg-img/2.jpg", "Plants exist in the weather and light rays that surround them"]
            ];
            ?>
            <?php foreach ($slides as $slide): ?>
                <div class="single-hero-post bg-overlay">
                    <div class="slide-img bg-img" style="background-image: url(<?php echo $slide[0]; ?>);"></div>
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12">
                                <div class="hero-slides-content text-center">
                                    <h2><?php echo $slide[1]; ?></h2>
                                    <div class="welcome-btn-group">
                                        <a href="login.php" class="btn alazea-btn mr-30">GET STARTED</a>
                                        <a href="contact.php" class="btn alazea-btn active">CONTACT US</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Service Area Start ##### -->
    <section class="our-services-area bg-gray section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2>OUR SERVICES</h2>
                        <p>We provide the perfect service for you.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between">
                <div class="col-12 col-lg-5">
                    <div class="alazea-service-area mb-100">
                        <?php
                        $services = [
                            ["img/core-img/s1.png", "Become a Seller", "Sell your own plants and gardening accessories on our platform. Connect with buyers easily!", "100ms"],
                            ["img/core-img/s2.png", "Hire a Gardener", "Need professional help? Hire expert gardeners for maintenance, landscaping, and more!", "300ms"],
                            ["img/core-img/s3.png", "Best-Selling Plants", "Explore our top-selling plants, chosen by customers for their beauty and benefits.", "500ms"]
                        ];
                        ?>

                        <?php foreach ($services as $service): ?>
                            <div class="single-service-area d-flex align-items-center wow fadeInUp"
                                data-wow-delay="<?php echo $service[3]; ?>">
                                <!-- Icon -->
                                <div class="service-icon mr-30">
                                    <img src="<?php echo $service[0]; ?>" alt="">
                                </div>
                                <!-- Content -->
                                <div class="service-content">
                                    <h5><?php echo $service[1]; ?></h5>
                                    <p><?php echo $service[2]; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="alazea-video-area mb-100">
                        <img src="img/bg-img/23.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Service Area End ##### -->

    <!-- ##### Portfolio Area Start ##### -->
    <section class="alazea-portfolio-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2>OUR STORE</h2>
                        <p>Explore our store</p>
                    </div>
                </div>
            </div>
        </div>
        <?php include "./components/general/portfolio.php" ?>
    </section>
    <!-- ##### Portfolio Area End ##### -->

    <!-- ##### Testimonial Area Start ##### -->
    <section class="testimonial-area section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="testimonials-slides owl-carousel">
                        <?php
                        $owner = [
                            [
                                "img/bg-img/13.jpg",
                                "STORE OWNER",
                                "Some kind words from clients about Alazea",
                                "“Alazea is a pleasure to work with. Their ideas are creative, they came up with imaginative solutions to some tricky issues, their landscaping and planting contacts are equally excellent we have a beautiful but also manageable garden as a result. Thank you!”",
                                "Ms. Krutika Deepak Patil",
                                "Founder of GreenWorld"
                            ],
                            [
                                "img/bg-img/14.jpg",
                                "TESTIMONIAL",
                                "Some kind words from clients about Alazea",
                                "“Alazea is a pleasure to work with. Their ideas are creative, they came up with imaginative solutions to some tricky issues, their landscaping and planting contacts are equally excellent we have a beautiful but also manageable garden as a result. Thank you!”",
                                "Mr. Nazrul Islam",
                                "CEO of NAVATECH"
                            ],
                            [
                                "img/bg-img/15.jpg",
                                "TESTIMONIAL",
                                "Some kind words from clients about Alazea",
                                "“Alazea is a pleasure to work with. Their ideas are creative, they came up with imaginative solutions to some tricky issues, their landscaping and planting contacts are equally excellent we have a beautiful but also manageable garden as a result. Thank you!”",
                                "Mr. Jonas Nick",
                                "CEO of NAVATECH"
                            ]
                        ]
                            ?>
                        <?php foreach ($owner as $testimonial): ?>
                            <div class="single-testimonial-slide">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-6">
                                        <div class="testimonial-thumb">
                                            <img src=<?php echo $testimonial[0] ?> alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="testimonial-content">
                                            <!-- Section Heading -->
                                            <div class="section-heading">
                                                <h2><?php echo $testimonial[1] ?></h2>
                                                <p><?php echo $testimonial[2] ?></p>
                                            </div>
                                            <p><?php echo $testimonial[3] ?></p>
                                            <div class="testimonial-author-info">
                                                <h6><?php echo $testimonial[4] ?></h6>
                                                <p><?php echo $testimonial[5] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Testimonial Area End ##### -->

    <!-- ##### Product Area Start ##### -->
    <?php include "./components/general/lastest_arrival.php" ?>
    <!-- ##### Product Area End ##### -->

    <!-- ##### Contact Area Start ##### -->
    <?php include "./components/general/contact.php" ?>
    <!-- ##### Contact Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <?php include "./components/general/footer.php" ?>
    <!-- ##### Footer Area End ##### -->

    <!-- ##### All Javascript Files ##### -->
    <?php include "./components/general/scripts.php" ?>
</body>

</html>