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

// Fetch products from the database
$query = "SELECT name, category, subcategory, price, description, image FROM products";
$result = $conn->query($query);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="alazea-portfolio-filter">
                <div class="portfolio-filter">
                    <button class="btn active classynav" data-filter="*">All</button>
                    <button class="btn" data-filter=".plants">Plant</button>
                    <button class="btn" data-filter=".gardening-tool">Gardening Tool</button>
                    <button class="btn" data-filter=".seed">Seeds</button>
                    <button class="btn" data-filter=".bulb">Bulbs</button>
                    <button class="btn" data-filter=".soil-fertilizer">Soil & Fertilizer</button>
                    <button class="btn" data-filter=".pebble">Pebbles</button>
                    <button class="btn" data-filter=".accessory">Accessories</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row alazea-portfolio">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = htmlspecialchars($row['name']);
                $category = strtolower(str_replace(' ', '-', htmlspecialchars($row['category'])));
                $subcategory = strtolower(str_replace(' ', '-', htmlspecialchars($row['subcategory'])));
                $description = htmlspecialchars($row['description']);
                $price = number_format($row['price'], 2);
                $imageData = base64_encode($row['image']);
                $imageSrc = "data:image/jpeg;base64," . $imageData;
                ?>

                <!-- Dynamically Generated Portfolio Item -->
                <div class="col-12 col-sm-6 col-lg-3 single_portfolio_item <?php echo $category; ?> wow fadeInUp">
                    <div class="portfolio-thumbnail bg-img" style="background-image: url('<?php echo $imageSrc; ?>'); background-position: center;
                        background-size: contain;"></div>
                    <div class="portfolio-hover-overlay">
                        <a href="<?php echo $imageSrc; ?>"
                            class="portfolio-img d-flex align-items-center justify-content-center" title="<?php echo $name; ?>">
                            <div class="port-hover-text">
                                <h3><?php echo $name; ?></h3>
                                <h5><?php echo $description; ?></h5>
                                <h6>Price: ₹<?php echo $price; ?></h6>
                            </div>
                        </a>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "<p class='text-center w-100'>No products found.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>