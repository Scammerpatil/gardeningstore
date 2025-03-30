<?php
$page_title = "Dashboard";
ob_start();
?>
<?php
include "../../server/database.php";
$query = "SELECT product_id, name, category, subcategory, price, shortdesc, longdesc, size, image FROM products";
$result = $conn->query($query);
?>
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
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-6 p-5" id="product-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            $categoryClass = strtolower(str_replace([' ', '&'], ['-', 'and'], $row['category']));
            $subcategoryClass = strtolower(str_replace([' ', '&'], ['-', 'and'], $row['subcategory']));
            $imageSrc = "data:image/jpeg;base64," . base64_encode($row['image']);
            ?>
            <div
                class="card max-w-80 bg-base-300 shadow-xl single_product_item <?= $categoryClass . ' ' . $subcategoryClass; ?>">
                <figure onclick="window.location.href='product.php?id=<?= $row['product_id']; ?>';" style="cursor:pointer;"
                    class="h-48">
                    <img src="<?= $imageSrc; ?>" alt="<?= htmlspecialchars($row['name']); ?>" class="" />
                </figure>
                <div class="card-body text-center">
                    <h2 class="card-title justify-center"><?= htmlspecialchars($row['name']); ?></h2>
                    <p><?= htmlspecialchars($row['shortdesc']); ?></p>
                    <p><?= htmlspecialchars($row['longdesc']); ?></p>
                    <h3 class="text-xl font-semibold text-primary">₹<?= number_format($row['price'], 2); ?></h3>
                    <div class="card-actions justify-center">
                        <button class="btn btn-secondary add-to-cart" data-id="<?= $row['product_id']; ?>"
                            data-category="<?php echo htmlspecialchars($row['category']); ?>"
                            data-name="<?= htmlspecialchars($row['name']); ?>" data-price="<?= $row['price']; ?>"
                            data-image="<?= $imageSrc; ?>">
                            <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                        </button>
                        <button class="btn btn-primary buy_now" data-id="<?= $row['product_id']; ?>"
                            data-category="<?php echo htmlspecialchars($row['category']); ?>"
                            data-name="<?= htmlspecialchars($row['name']); ?>" data-price="<?= $row['price']; ?>"
                            data-image="<?= $imageSrc; ?>" onclick="window.location.href='cart.php';">
                            <i class="fa-solid fa-bag-shopping"></i> Buy Now!
                        </button>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>
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

        function filterProducts(filter) {
            products.forEach(product => {
                if (filter === "*" || product.classList.contains(filter.replace(".", ""))) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });
        }

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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];

        function updateCartCount() {
            document.getElementById("cart-count").innerText = cart.length;
        }

        function saveCart() {
            localStorage.setItem("cart", JSON.stringify(cart));
            updateCartCount();
            alert("Cart updated!");
        }

        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                const productName = this.getAttribute("data-name");
                alert(`${productName} added to cart!`);
                const productPrice = this.getAttribute("data-price");
                const productImage = this.getAttribute("data-image");
                const productCategory = this.getAttribute("data-category");

                const existingItem = cart.find(item => item.id === productId);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: parseFloat(productPrice),
                        image: productImage,
                        category: productCategory,
                        quantity: 1
                    });
                }

                saveCart();
                console.log(cart);
            });
        });

        updateCartCount();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];

        function updateCartCount() {
            document.getElementById("cart-count").innerText = cart.length;
        }

        function saveCart() {
            localStorage.setItem("cart", JSON.stringify(cart));
            updateCartCount();
        }

        document.querySelectorAll(".buy_now").forEach(button => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                const productName = this.getAttribute("data-name");
                const productPrice = this.getAttribute("data-price");
                const productImage = this.getAttribute("data-image");
                const productCategory = this.getAttribute("data-category");
                const existingItem = cart.find(item => item.id === productId);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: parseFloat(productPrice),
                        image: productImage,
                        category: productCategory,
                        quantity: 1
                    });
                }
                saveCart();
                alert(`${productName} added to cart!`);
                window.location.href = "cart.php";
            });
        });

        updateCartCount();
    });

</script>
<?php $conn->close(); ?>
<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>