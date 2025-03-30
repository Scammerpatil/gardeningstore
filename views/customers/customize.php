<?php
session_start();
$page_title = "Customize Your Choice";
include "../../server/database.php";

$item_id = isset($_GET['item']) ? $_GET['item'] : null;
ob_start();

// Fetch Pots & Pebbles
$pots_query = "SELECT * FROM products WHERE category = 'Pots'";
$pebbles_query = "SELECT * FROM products WHERE category = 'Pebble'";

$pots = $conn->query($pots_query)->fetch_all(MYSQLI_ASSOC);
$pebbles = $conn->query($pebbles_query)->fetch_all(MYSQLI_ASSOC);
?>

<h1 class="text-3xl font-bold text-center uppercase">Customize Your Choice</h1>
<p class="text-center text-xl mt-3">Selected Product: <span id="product_name"></span></p>

<h2 class="text-2xl font-bold text-center mt-6">Select a Pot</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-5" id="pot-grid">
    <?php foreach ($pots as $pot): ?>
        <div class="card max-w-80 bg-base-300 shadow-xl p-5 text-center">
            <figure class="h-48">
                <img src="data:image/jpeg;base64,<?= base64_encode($pot['image']) ?>"
                    alt="<?= htmlspecialchars($pot['name']); ?>" class="h-32 w-full object-contain">
            </figure>
            <div class="card-body text-center">
                <h2 class="card-title justify-center"><?= htmlspecialchars($pot['name']); ?></h2>
                <p><?= htmlspecialchars($pot['shortdesc']); ?></p>
                <h3 class="text-xl font-semibold text-primary">₹<?= number_format($pot['price'], 2); ?></h3>
                <button class="btn btn-primary select-pot" data-id="<?= $pot['product_id']; ?>"
                    data-category="<?php echo htmlspecialchars($pot['category']); ?>"
                    data-name="<?= htmlspecialchars($pot['name']); ?>" data-price="<?= $pot['price']; ?>"
                    data-image="data:image/jpeg;base64,<?= base64_encode($pot['image']) ?>">
                    Select
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<h2 class="text-2xl font-bold text-center mt-6">Select Pebbles</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-5" id="pebble-grid">
    <?php foreach ($pebbles as $pebble): ?>
        <div class="card max-w-80 bg-base-300 shadow-xl p-5 text-center">
            <figure class="h-48">
                <img src="data:image/jpeg;base64,<?= base64_encode($pebble['image']) ?>"
                    alt="<?= htmlspecialchars($pebble['name']); ?>" class="h-32 w-full object-contain">
            </figure>
            <div class="card-body text-center">
                <h2 class="card-title justify-center"><?= htmlspecialchars($pebble['name']); ?></h2>
                <p><?= htmlspecialchars($pebble['shortdesc']); ?></p>
                <h3 class="text-xl font-semibold text-primary">₹<?= number_format($pebble['price'], 2); ?></h3>
                <button class="btn btn-primary select-pebble" data-id="<?= $pebble['product_id']; ?>"
                    data-category="<?php echo htmlspecialchars($pebble['category']); ?>"
                    data-name="<?= htmlspecialchars($pebble['name']); ?>" data-price="<?= $pebble['price']; ?>"
                    data-image="data:image/jpeg;base64,<?= base64_encode($pebble['image']) ?>">
                    Select
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="text-center mt-6">
    <button class="btn btn-success" onclick="window.location.href='cart.php?customize=true';">Confirm &
        Checkout</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const itemId = <?= json_encode($item_id) ?>;
        const product = cart[itemId];
        document.getElementById("product_name").textContent = product ? product.name : "Unknown Product";
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

        document.querySelectorAll(".select-pot").forEach(button => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                const productName = this.getAttribute("data-name");
                const productPrice = this.getAttribute("data-price");
                const productImage = this.getAttribute("data-image");
                const productCategory = this.getAttribute("data-category");

                alert(`${productName} added to cart!`);
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

        document.querySelectorAll(".select-pebble").forEach(button => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                const productName = this.getAttribute("data-name");
                const productPrice = this.getAttribute("data-price");
                const productImage = this.getAttribute("data-image");
                const productCategory = this.getAttribute("data-category");

                alert(`${productName} added to cart!`);
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

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>