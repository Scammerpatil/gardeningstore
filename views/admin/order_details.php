<?php
session_start();
include "../../server/database.php";

if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "admin") {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET["order_id"])) {
    header("Location: admin_orders.php");
    exit();
}

$page_title = "Order Details";
$order_id = $_GET["order_id"];
ob_start();
?>
<h2 class="text-3xl font-bold text-center uppercase">Order Details (Order #<?= $order_id ?>) </h2>

<?php
// Fetch order details including customization information
$order_query = "SELECT o.customizing
                FROM orders o
                WHERE o.order_id = ?";
$order_stmt = $conn->prepare($order_query);
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
    $customizing = $order["customizing"];
} else {
    $customizing = "";
}

$order_stmt->close();

// Fetch the products in the order
$query = "SELECT p.name, od.quantity, od.price, p.image
              FROM orderdetails od
              JOIN products p ON od.product_id = p.product_id
              WHERE od.order_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0):
    ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card bg-base-100 shadow-xl p-5">
                <figure>
                    <img src="data:image/jpeg;base64,<?= base64_encode($row["image"]) ?>" class="h-48 w-full object-contain">
                </figure>
                <div class="card-body text-center">
                    <h3 class="card-title"><?= htmlspecialchars($row["name"]) ?></h3>
                    <p class="text-lg">Quantity: <?= $row["quantity"] ?></p>
                    <p class="text-lg font-semibold text-primary">₹<?= number_format($row["price"], 2) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p class="text-center text-lg mt-6">No items found for this order.</p>
<?php endif; ?>

<?php if (!empty($customizing)): ?>
    <!-- Customization Details Section -->
    <div class="mt-6 p-4 bg-yellow-100 border border-yellow-400 rounded">
        <h3 class="text-2xl font-semibold">Customization Details</h3>
        <p class="mt-2"><?= nl2br(htmlspecialchars($customizing)) ?></p>
    </div>
<?php else: ?>
    <p class="text-center text-lg mt-6 text-gray-500">No customization details for this order.</p>
<?php endif; ?>

<div class="text-center mt-6">
    <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>
