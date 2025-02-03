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
$query = "SELECT name, category, subcategory, price, description, image FROM products";
$result = $conn->query($query);
?>

<section class="bg-base-300 py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-5xl font-bold text-center text-base-content uppercase">GARDENING STORE</h1>
        <p class="text-xl text-center my-2">Explore our Store</p>

        <!-- Category Filters -->
        <div class="flex flex-wrap justify-center gap-4 my-6">
            <?php
            $categories = [
                'Plants' => 'plants',
                'Gardening Tool' => 'gardening-tool',
                'Seeds' => 'seeds',
                'Bulb' => 'bulb',
                'Soil & Fertilizer' => 'soil-fertilizer',
                'Pebbles' => 'pebbles',
                'Accessories' => 'accessories'
            ];
            ?>
            <button class="tab text-lg hover:text-primary filter-btn" data-filter="*">All</button>
            <?php foreach ($categories as $categoryName => $categoryFilter): ?>
                <button class="tab text-lg hover:text-primary filter-btn"
                    data-filter=".<?= $categoryFilter; ?>"><?= $categoryName; ?></button>
            <?php endforeach; ?>
        </div>

        <!-- Subcategory Filters -->
        <div class="flex flex-wrap justify-center gap-2 my-4" id="subcategory-filters"></div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-5" id="product-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $categoryClass = strtolower(str_replace([' ', '&'], ['-', 'and'], $row['category']));
                $subcategoryClass = strtolower(str_replace([' ', '&'], ['-', 'and'], $row['subcategory']));
                $imageSrc = "data:image/jpeg;base64," . base64_encode($row['image']);
                ?>

                <!-- Product Card -->
                <div
                    class="card w-80 bg-base-100 shadow-xl single_product_item <?= $categoryClass . ' ' . $subcategoryClass; ?>">
                    <figure>
                        <img src="<?= $imageSrc; ?>" alt="<?= htmlspecialchars($row['name']); ?>"
                            class="h-48 w-full object-contain bg-blend-overlay" />
                    </figure>
                    <div class="card-body text-center">
                        <h2 class="card-title justify-center"><?= htmlspecialchars($row['name']); ?></h2>
                        <p><?= htmlspecialchars($row['description']); ?></p>
                        <h3 class="text-xl font-semibold text-primary">₹<?= number_format($row['price'], 2); ?></h3>
                        <div class="card-actions justify-center">
                            <a href="login.php" class="btn btn-secondary">
                                <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                            </a>
                            <a href="login.php" class="btn btn-primary">
                                <i class="fa-solid fa-bag-shopping"></i> Buy Now!
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const products = document.querySelectorAll(".single_product_item");
        const filterButtons = document.querySelectorAll(".filter-btn");
        const subcategoryContainer = document.getElementById("subcategory-filters");
        const subcategories = {
            "gardening-tool": ["Gardening Tools", "Watering Cans And Hoses", "Pest Control",
                "Garden Furniture", "Landscaping", "Garden Décor", "DIY Kits"],
            "plants": ["Indoor Plants", "Outdoor Plants", "Flowering Plants",
                "Succulents", "Bonsai", "Medicinal Plants", "Air Purifying Plants"],
            "seeds": ["Vegetable Seeds", "Herb Seeds", "Flower Seeds",
                "Organic Seeds", "Exotic Seeds", "Grass Seeds", "Fruit Seeds"],
            "bulb": ["Flower Bulbs", "Seasonal Bulbs", "Perennial Bulbs",
                "Exotic Bulbs", "Indoor Bulbs", "Outdoor Bulbs", "Decorative Bulbs"],
            "soil-fertilizer": ["Organic Fertilizer", "Potting Soil", "Coco Peat",
                "Vermicompost", "Nutrient Mixes", "Soil Amendments", "Specialty Fertilizers"],
            "pebbles": ["Decorative Pebbles", "Natural Stones", "River Rocks",
                "Colored Pebbles", "Aquarium Pebbles", "Garden Path Pebbles", "Gravel"],
            "accessories": ["Plant Stands", "Garden Lighting", "Labels & Markers",
                "Sprayers & Misters", "Hanging Hooks", "Trellises & Supports", "Garden Storage"]
        };

        // Filter function
        function filterProducts(filter) {
            products.forEach(product => {
                if (filter === "*" || product.classList.contains(filter.replace(".", ""))) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });
        }

        // Filter on button click
        filterButtons.forEach(button => {
            button.addEventListener("click", function () {
                filterButtons.forEach(btn => btn.classList.remove("btn-primary"));
                this.classList.add("btn-primary");
                const filter = this.getAttribute("data-filter");
                filterProducts(filter);

                // Show subcategories for selected category
                subcategoryContainer.innerHTML = "";
                if (filter !== "*") {
                    const categoryKey = filter.replace(".", "");
                    if (subcategories[categoryKey]) {
                        subcategories[categoryKey].forEach(sub => {
                            const subBtn = document.createElement("button");
                            subBtn.className = "btn btn-outline filter-btn";
                            subBtn.setAttribute("data-filter", "." + sub.toLowerCase().replace(/ /g, "-"));
                            subBtn.textContent = sub;
                            subBtn.addEventListener("click", function () {
                                filterProducts(this.getAttribute("data-filter"));
                            });
                            subcategoryContainer.appendChild(subBtn);
                        });
                    }
                }
            });
        });
    });
</script>

<?php $conn->close(); ?>