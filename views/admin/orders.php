<?php
session_start();
include "../../server/database.php";

if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "admin") {
    header("Location: ../../login.php");
    exit();
}

$page_title = "Manage Orders";
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handling order status updates (accept/reject)
    if (isset($_POST["order_id"]) && isset($_POST["action"])) {
        $order_id = intval($_POST["order_id"]);
        $action = $_POST["action"];

        if ($action == "accept") {
            $status = "Completed";
            $delivery_status = "Pending";
        } elseif ($action == "reject") {
            $status = "Rejected";
            $delivery_status = null;
        } else {
            $status = "Pending";
            $delivery_status = null;
        }

        $update_query = "UPDATE orders SET status = ?, delivery_status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $status, $delivery_status, $order_id);

        if ($stmt->execute()) {
            echo "<script>alert('Order updated successfully!'); window.location.href='orders.php';</script>";
        } else {
            echo "<script>alert('Failed to update order!');</script>";
        }
        $stmt->close();
    }

    // Handling Delivery Status Updates
    if (isset($_POST["order_id"]) && isset($_POST["delivery_status"])) {
        $order_id = intval($_POST["order_id"]);
        $delivery_status = $_POST["delivery_status"];

        $update_query = "UPDATE orders SET delivery_status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $delivery_status, $order_id);

        if ($stmt->execute()) {
            echo "<script>alert('Delivery status updated successfully!'); window.location.href='orders.php';</script>";
        } else {
            echo "<script>alert('Failed to update delivery status!');</script>";
        }
        $stmt->close();
    }
}

$query = "SELECT o.order_id, c.name AS customer_name, c.address AS address, o.order_date, o.customizing, o.delivery_status, o.total_amount, o.status, o.payment_status
          FROM orders o 
          JOIN customers c ON o.customer_id = c.customer_id
          ORDER BY o.order_date DESC";

$result = $conn->query($query);
?>

<h2 class="text-3xl font-bold text-center uppercase">Manage Orders</h2>

<?php if ($result->num_rows > 0): ?>
    <div class="overflow-x-auto mt-6">
        <table class="table-auto w-full border-collapse border border-base-content">
            <thead class="bg-base-200">
                <tr>
                    <th class="border px-4 py-2">Order ID</th>
                    <th class="border px-4 py-2">Customer</th>
                    <th class="border px-4 py-2">Customer Address</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Customizing</th>
                    <th class="border px-4 py-2">Total Amount</th>
                    <th class="border px-4 py-2">Status</th>
                    <!-- <th class="border px-4 py-2">Payment Status</th> -->
                    <th class="border px-4 py-2">Delivery Status</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="border px-4 py-2"><?= $row["order_id"] ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row["customer_name"]) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row["address"]) ?></td>
                        <td class="border px-4 py-2"><?= $row["order_date"] ?></td>
                        <!-- Display a simple indicator if this order has customization details -->
                        <td class="border px-4 py-2">
                            <?php if (!empty($row["customizing"])): ?>
                                <span class="text-orange-600 font-bold">Custom Item</span>
                            <?php else: ?>
                                None
                            <?php endif; ?>
                        </td>
                        <td class="border px-4 py-2">₹<?= number_format($row["total_amount"], 2) ?></td>

                        <td class="border px-4 py-2 
                            <?= ($row["status"] == 'Completed') ? 'text-green-500' : (($row["status"] == 'Rejected') ? 'text-red-500' : 'text-yellow-500') ?>">
                            <?= $row["status"] ?>
                        </td>

                        <!-- <td class="border px-4 py-2 <?= ($row["payment_status"] == 1) ? 'text-green-500' : 'text-red-500' ?>">
                            <?= ($row["payment_status"] == 1) ? 'Paid' : 'Unpaid' ?>
                        </td> -->

                        <!-- Delivery Status -->
                        <td class="border px-4 py-2">
                            <?php if ($row["status"] == "Pending"): ?>
                                <span class="text-yellow-500">Pending</span>
                            <?php else: ?>
                                <?php if ($row["delivery_status"] == "Delivered"): ?>
                                    <span class="text-green-500">Delivered</span>
                                <?php else: ?>
                                    <form action="orders.php" method="POST">
                                        <input type="hidden" name="order_id" value="<?= $row["order_id"] ?>">
                                        <select name="delivery_status" class="select select-bordered">
                                            <option value="Pending" <?= ($row["delivery_status"] == "Pending") ? "selected" : "" ?>>Pending</option>
                                            <option value="Dispatched" <?= ($row["delivery_status"] == "Dispatched") ? "selected" : "" ?>>Dispatched</option>
                                            <option value="Out for Delivery" <?= ($row["delivery_status"] == "Out for Delivery") ? "selected" : "" ?>>Out for Delivery</option>
                                            <option value="Delivered" <?= ($row["delivery_status"] == "Delivered") ? "selected" : "" ?>>Delivered</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>

                        <!-- Action Buttons -->
                        <td class="border px-4 py-2">
                            <?php if ($row["status"] == "Pending"): ?>
                                <form action="orders.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?= $row["order_id"] ?>">
                                    <button type="submit" name="action" value="accept" class="btn btn-success btn-sm">Accept</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            <?php endif; ?>
                            <!-- The View Details link now goes to order_details.php -->
                            <a href="order_details.php?order_id=<?= $row["order_id"] ?>" class="btn btn-primary btn-sm">View Details</a>
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