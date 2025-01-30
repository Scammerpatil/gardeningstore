<section class="new-arrivals-products-area bg-gray section-padding-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Section Heading -->
                <div class="section-heading text-center">
                    <h2>NEW ARRIVALS</h2>
                    <p>We have the latest products, it must be exciting for you</p>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Single Product Area -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                    <!-- Product Image -->
                    <div class="product-img">
                        <a href="shop-details.html"><img src="img/bg-img/9.jpg" alt=""></a>
                        <!-- Product Tag -->
                        <div class="product-tag">
                            <a href="#">Hot</a>
                        </div>
                        <div class="product-meta d-flex">
                            <a href="#" class="wishlist-btn"><i class="icon_heart_alt"></i></a>
                            <a href="cart.html" class="add-to-cart-btn">Add to cart</a>
                            <a href="#" class="compare-btn"><i class="arrow_left-right_alt"></i></a>
                        </div>
                    </div>
                    <!-- Product Info -->
                    <div class="product-info mt-15 text-center">
                        <a href="shop-details.html">
                            <p>Cactus Flower</p>
                        </a>
                        <h6>$10.99</h6>
                    </div>
                </div>
            </div>

            <!-- Single Product Area -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="200ms">
                    <!-- Product Image -->
                    <div class="product-img">
                        <a href="shop-details.html"><img src="img/bg-img/10.jpg" alt=""></a>
                        <div class="product-meta d-flex">
                            <a href="#" class="wishlist-btn"><i class="icon_heart_alt"></i></a>
                            <a href="cart.html" class="add-to-cart-btn">Add to cart</a>
                            <a href="#" class="compare-btn"><i class="arrow_left-right_alt"></i></a>
                        </div>
                    </div>
                    <!-- Product Info -->
                    <div class="product-info mt-15 text-center">
                        <a href="shop-details.html">
                            <p>Cactus Flower</p>
                        </a>
                        <h6>$10.99</h6>
                    </div>
                </div>
            </div>

            <!-- Single Product Area -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="300ms">
                    <!-- Product Image -->
                    <div class="product-img">
                        <a href="shop-details.html"><img src="img/bg-img/11.jpg" alt=""></a>
                        <div class="product-meta d-flex">
                            <a href="#" class="wishlist-btn"><i class="icon_heart_alt"></i></a>
                            <a href="cart.html" class="add-to-cart-btn">Add to cart</a>
                            <a href="#" class="compare-btn"><i class="arrow_left-right_alt"></i></a>
                        </div>
                    </div>
                    <!-- Product Info -->
                    <div class="product-info mt-15 text-center">
                        <a href="shop-details.html">
                            <p>Cactus Flower</p>
                        </a>
                        <h6>$10.99</h6>
                    </div>
                </div>
            </div>

            <!-- Single Product Area -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="400ms">
                    <!-- Product Image -->
                    <div class="product-img">
                        <a href="shop-details.html"><img src="img/bg-img/12.jpg" alt=""></a>
                        <!-- Product Tag -->
                        <div class="product-tag sale-tag">
                            <a href="#">Hot</a>
                        </div>
                        <div class="product-meta d-flex">
                            <a href="#" class="wishlist-btn"><i class="icon_heart_alt"></i></a>
                            <a href="cart.html" class="add-to-cart-btn">Add to cart</a>
                            <a href="#" class="compare-btn"><i class="arrow_left-right_alt"></i></a>
                        </div>
                    </div>
                    <!-- Product Info -->
                    <div class="product-info mt-15 text-center">
                        <a href="shop-details.html">
                            <p>Cactus Flower</p>
                        </a>
                        <h6>$10.99</h6>
                    </div>
                </div>
            </div>

            <div class="col-12 text-center">
                <a href="#" class="btn alazea-btn">View All</a>
            </div>

        </div>
    </div>
</section>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gardeningstore";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$db_create_query = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($db_create_query)) {
    die("Database creation failed: " . $conn->error);
}
$conn->select_db($dbname);
$query = "SELECT product_id, name, category, price, image FROM products ORDER BY product_id DESC LIMIT 4";
$result = $conn->query($query);
?>

<section class="new-arrivals-products-area bg-gray section-padding-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Section Heading -->
                <div class="section-heading text-center">
                    <h2>NEW ARRIVALS</h2>
                    <p>We have the latest products, it must be exciting for you</p>
                </div>
            </div>
        </div>

        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
                        <div class="product-img">
                            <a href="shop-details.php?id=<?= $row['product_id']; ?>">
                                <img src="data:image/jpeg;base64,<?= base64_encode($row['image']); ?>"
                                    alt="<?= htmlspecialchars($row['name']); ?>">
                            </a>
                            <div class="product-meta d-flex">
                                <a href="#" class="wishlist-btn"><i class="icon_heart_alt"></i></a>
                                <a href="cart.php?add=<?= $row['product_id']; ?>" class="add-to-cart-btn">Add to cart</a>
                                <a href="#" class="compare-btn"><i class="arrow_left-right_alt"></i></a>
                            </div>
                        </div>
                        <!-- Product Info -->
                        <div class="product-info mt-15 text-center">
                            <a href="shop-details.php?id=<?= $row['product_id']; ?>">
                                <p><?= htmlspecialchars($row['name']); ?></p>
                            </a>
                            <h6>₹<?= number_format($row['price'], 2); ?></h6>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

            <div class="col-12 text-center">
                <a href="shop.php" class="btn alazea-btn">View All</a>
            </div>
        </div>
    </div>
</section>

<?php $conn->close(); ?>