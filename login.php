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
    <!-- Navbar -->
    <?php include "./components/general/navbar.php" ?>
    
    <!-- Form -->
    <section class="hero-area">
        <div class="hero-post-slides owl-carousel">

            <!-- Single Hero Post -->
            <div class="single-hero-post bg-overlay" style="background-color: skyblue;">
                <div class="container h-75">
                    <div class="row h-75 align-items-center">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h2>Welcome Back, Login to Access Your Account</h2>
                                <p>Enter your credentials to continue.</p>
                                <!-- Signup Form -->
                                <div class="contact-form-area mb-100">
                                    <form action="./server/auth/login.php" method="post">
                                        <div class="row">
                                            <!-- Username -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="Email" required>
                                                </div>
                                            </div>
                                            <!-- Password -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Password" required>
                                                </div>
                                            </div>
                                            <!-- User Type Dropdown -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <select class="form-control" name="user_type" required>
                                                        <option value="" disabled selected>Select User Type</option>
                                                        <option value="customer">Customer</option>
                                                        <option value="gardener">Gardener</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Submit Button -->
                                            <div class="col-12">
                                                <button type="submit" class="btn alazea-btn mt-15">Login</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- End Signup Form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Scripts -->
    <?php include "./components/general/scripts.php" ?>
</body>

</html>