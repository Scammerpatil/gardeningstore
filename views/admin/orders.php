<?php
session_start();
include "../../server/database.php";

// Ensure only admin can access this page
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "admin") {
    header("Location: ../../login.php");
    exit();
}

$page_title = "Manage Orders";
ob_start();

// Handle Order Actions (Accept or Reject)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["order_id"]) && isset($_POST["action"])) {
        $order_id = intval($_POST["order_id"]);
        $action = $_POST["action"];

        if ($action == "accept") {
            $status = "Completed";
        } elseif ($action == "reject") {
            $status = "Rejected";
        } else {
            $status = "Pending";
        }

        $update_query = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $status, $order_id);

        if ($stmt->execute()) {
            echo "<script>alert('Order updated successfully!'); window.location.href='orders.php';</script>";
        } else {
            echo "<script>alert('Failed to update order!');</script>";
        }
        $stmt->close();
    }
}

// Fetch Orders
$query = "SELECT o.order_id, c.name AS customer_name, o.order_date, o.total_amount, o.status 
          FROM orders o 
          JOIN customers c ON o.customer_id = c.customer_id
          ORDER BY o.order_date DESC";

$result = $conn->query($query);
?>

<section class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center">Manage Orders</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="overflow-x-auto mt-6">
            <table class="table-auto w-full border-collapse border border-base-content">
                <thead class="bg-base-200">
                    <tr>
                        <th class="border px-4 py-2">Order ID</th>
                        <th class="border px-4 py-2">Customer</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Total Amount</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="text-center">
                            <td class="border px-4 py-2"><?= $row["order_id"] ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($row["customer_name"]) ?></td>
                            <td class="border px-4 py-2"><?= $row["order_date"] ?></td>
                            <td class="border px-4 py-2">₹<?= number_format($row["total_amount"], 2) ?></td>
                            <td
                                class="border px-4 py-2 <?= ($row["status"] == 'Completed') ? 'text-green-500' : (($row["status"] == 'Rejected') ? 'text-red-500' : 'text-yellow-500') ?>">
                                <?= $row["status"] ?>
                            </td>
                            <td class="border px-4 py-2">
                                <form method="POST" class="inline-block">
                                    <input type="hidden" name="order_id" value="<?= $row["order_id"] ?>">
                                    <button type="submit" name="action" value="accept"
                                        class="btn btn-success btn-sm">Accept</button>
                                    <button type="submit" name="action" value="reject"
                                        class="btn btn-error btn-sm">Reject</button>
                                </form>
                                <a href="order_details.php?order_id=<?= $row["order_id"] ?>" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center text-lg mt-6">No orders found.</p>
    <?php endif; ?>

</section>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>