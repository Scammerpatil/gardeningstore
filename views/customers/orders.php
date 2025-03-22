<?php
include "../../server/database.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$page_title = "My Orders";
$customer_id = $_SESSION["user_id"];
ob_start();
?>
<h2 class="text-3xl font-bold text-center uppercase">My Orders</h2>

<?php
// Fetch Orders
$query = "SELECT order_id, order_date, delivery_status, total_amount, status FROM orders WHERE customer_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0):
    ?>
    <div class="overflow-x-auto mt-6">
        <table class="table-auto w-full border-collapse border border-base-content">
            <thead class="bg-base-200">
                <tr>
                    <th class="border px-4 py-2">Order ID</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Total Amount</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Delivery Status</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="border px-4 py-2"><?= $row["order_id"] ?></td>
                        <td class="border px-4 py-2"><?= $row["order_date"] ?></td>
                        <td class="border px-4 py-2">₹<?= number_format($row["total_amount"], 2) ?></td>
                        <td
                            class="border px-4 py-2 <?= ($row["status"] == 'Completed') ? 'text-green-500' : 'text-yellow-500' ?>">
                            <?= $row["status"] ?>
                        </td>
                        <td
                            class="border px-4 py-2 <?= ($row["delivery_status"] == 'Delivered') ? 'text-green-500' : 'text-yellow-500' ?>">
                            <?= $row["delivery_status"] ?>
                        <td class="border px-4 py-2">
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


<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>