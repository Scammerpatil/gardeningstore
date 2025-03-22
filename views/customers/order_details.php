<?php
session_start();
include "../../server/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["order_id"])) {
    header("Location: orders.php");
    exit();
}

$page_title = "Order Details";
$order_id = $_GET["order_id"];
$customer_id = $_SESSION["user_id"];
ob_start();
?>

<section class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center">Order Details (Order #<?= $order_id ?>)</h1>

    <?php
    // Fetch Order Details
    $query = "SELECT p.name, od.quantity, od.price, p.image
              FROM orderdetails od
              JOIN products p ON od.product_id = p.product_id
              JOIN orders o ON od.order_id = o.order_id
              WHERE o.order_id = ? AND o.customer_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $order_id, $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card bg-base-100 shadow-xl p-5">
                    <figure>
                        <img src="data:image/jpeg;base64,<?= base64_encode($row["image"]) ?>"
                            class="h-48 w-full object-contain">
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

    <div class="text-center mt-6">
        <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
    </div>

</section>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>