<?php
include "./server/database.php";

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

$imageSrc = "data:image/jpeg;base64," . base64_encode($product['image']);
?>
<!DOCTYPE html>
<html lang="en" data-theme="lemonade">
<?php include "./components/general/Header.php"; ?>

<body style="font-family: Dosis, sans-serif;">
    <?php include "./components/general/Navbar.php"; ?>
    <?php include './components/general/Hero.php' ?>
    <section class="relative px-10 py-10">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mx-auto max-md:px-2 ">
                <div class="img">
                    <div class="img-box h-full max-lg:mx-auto ">
                        <img src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                            class="max-lg:mx-auto lg:ml-auto h-full object-contain">
                    </div>
                </div>
                <div
                    class="data w-full lg:pr-8 pr-0 xl:justify-start justify-center flex items-center max-lg:pb-10 xl:my-2 lg:my-5 my-0">
                    <div class="data w-full max-w-xl">
                        <p class="text-lg font-medium leading-8 text-primary mb-4">
                            <?= htmlspecialchars($product['category']) ?>&nbsp; /&nbsp;
                            <?= htmlspecialchars($product['subcategory']) ?>
                        </p>
                        <h2 class="font-manrope font-bold text-3xl leading-10 text-base-content mb-2 capitalize">
                            <?= htmlspecialchars($product['name']) ?>
                        </h2>
                        <div class="flex flex-col sm:flex-row sm:items-center mb-6">
                            <h6
                                class="font-manrope font-semibold text-2xl leading-9 text-base-content pr-5 sm:border-r border-base-content/50 mr-5">
                                ₹<?= htmlspecialchars($product['price']) ?></h6>
                            <div class="flex items-center gap-2">
                                <!-- Rating Section Here -->
                                <span class="pl-2 font-normal leading-7 text-base-content text-sm ">1624 review</span>
                            </div>
                        </div>
                        <p class="text-base-content/50 text-base font-normal mb-5">
                            <?= htmlspecialchars($product['shortdesc']) ?>
                            <!-- Add a link to toggle long description -->
                            <a href="#" class="text-primary" id="more-link">More....</a>
                        </p>

                        <!-- Hidden Long Description (Initially Hidden) -->
                        <p id="longdesc" class="text-base-content text-base font-normal mb-5" style="display: none;">
                            <?= htmlspecialchars($product['longdesc']) ?>
                        </p>

                        <p class="text-base-content text-lg leading-8 font-medium mb-4">Size</p>
                        <div class="w-full pb-8 border-b border-baes-content flex-wrap">
                            <?= htmlspecialchars($product['size']) ?>
                        </div>

                        <div class="flex items-center gap-3">
                            <a class="btn btn-primary w-full rounded-3xl font-semibold text-lg" href="login.php">
                                Buy Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript to handle the "More" link toggle -->
    <script>
        document.getElementById('more-link').addEventListener('click', function (event) {
            event.preventDefault();
            var longDesc = document.getElementById('longdesc');
            if (longDesc.style.display === "none") {
                longDesc.style.display = "block";
                this.textContent = "Less...";
            } else {
                longDesc.style.display = "none";
                this.textContent = "More....";
            }
        });
    </script>
</body>

</html>