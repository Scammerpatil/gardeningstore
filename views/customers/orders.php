<?php
include "../../server/database.php";
session_start();
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$page_title = "My Orders";
$customer_id = $_SESSION["user_id"];
ob_start();

$keyId = 'rzp_test_cXJvckaWoN0JQx';
$keySecret = 'NuVVc8bnNeu4YA2bZ7Eymf39';
$api = new Api($keyId, $keySecret);

// Handle Payment Initialization
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"])) {
    $order_id = $_POST["order_id"];
    $amount = $_POST["amt"];

    // Fetch order details
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $order_id, $customer_id);
    $stmt->execute();
    $order_result = $stmt->get_result();
    $order = $order_result->fetch_assoc();

    // Fetch user details
    $stmt = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();

    if ($order) {
        $orderData = [
            'receipt' => $order_id,
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
        ];

        try {
            $response = $api->order->create($orderData);
            $razorpayOrderId = $response['id'];

            $_SESSION['razorpay_order_id'] = $razorpayOrderId;
            $_SESSION['razorpay_order_amount'] = $amount;
            $_SESSION['razorpay_order_id_ref'] = $order_id;

            echo "<script src='https://checkout.razorpay.com/v1/checkout.js'></script>";
            echo "<script>
                    var options = {
                        key: '$keyId',
                        amount: " . ($amount * 100) . ",
                        currency: 'INR',
                        name: '" . $user['name'] . "',
                        description: 'Payment for Order #{$order_id}',
                        image: 'https://png.pngtree.com/png-vector/20240310/ourmid/pngtree-fallen-green-leaf-element-png-image_11926275.png',
                        order_id: '$razorpayOrderId',
                        handler: function (response) {
                            // AJAX Request to Update Payment Status
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', '', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    window.location.href = 'orders.php';
                                }
                            };
                            xhr.send('razorpay_payment_id=' + response.razorpay_payment_id + '&razorpay_order_id=' + response.razorpay_order_id);
                        },
                        theme: { color: '#F37254' },
                        modal: { ondismiss: function () { window.location.href = 'my_orders.php'; } }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                </script>";
            exit;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    } else {
        echo "Order not found!";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["razorpay_payment_id"]) && isset($_SESSION['razorpay_order_id'])) {
    $razorpay_payment_id = $_POST["razorpay_payment_id"];
    $razorpay_order_id = $_POST["razorpay_order_id"];
    $order_id = $_SESSION['razorpay_order_id_ref'];

    $update_query = "UPDATE orders SET payment_status = 1 WHERE order_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ii", $order_id, $customer_id);
    $stmt->execute();

    unset($_SESSION['razorpay_order_id'], $_SESSION['razorpay_order_amount'], $_SESSION['razorpay_order_id_ref']);

    echo "Payment successful!";
    exit();
}

// Fetch Orders
$query = "SELECT order_id, order_date, delivery_status, total_amount, status, payment_status FROM orders WHERE customer_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2 class="text-3xl font-bold text-center uppercase">My Orders</h2>

<?php if ($result->num_rows > 0): ?>
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
                    <th class="border px-4 py-2">Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="border px-4 py-2"><?= htmlspecialchars($row["order_id"]) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row["order_date"]) ?></td>
                        <td class="border px-4 py-2">₹<?= number_format($row["total_amount"], 2) ?></td>
                        <td
                            class="border px-4 py-2 <?= ($row["status"] == 'Completed') ? 'text-green-500' : 'text-yellow-500' ?>">
                            <?= htmlspecialchars($row["status"]) ?>
                        </td>
                        <td
                            class="border px-4 py-2 <?= ($row["delivery_status"] == 'Delivered') ? 'text-green-500' : 'text-yellow-500' ?>">
                            <?= htmlspecialchars($row["delivery_status"]) ?>
                        </td>
                        <td class="border px-4 py-2">
                            <a href="order_details.php?order_id=<?= urlencode($row["order_id"]) ?>"
                                class="btn btn-primary btn-sm">
                                View Details
                            </a>
                        </td>
                        <td class="border px-4 py-2 <?= ($row["payment_status"] == 1) ? 'text-green-500' : 'text-red-500' ?>">
                            <?php if ($row["payment_status"] == 1): ?>
                                Paid
                            <?php else: ?>
                                <form action="" method="post">
                                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($row["order_id"]) ?>">
                                    <input type="hidden" name="amt" value="<?= htmlspecialchars($row["total_amount"]) ?>">
                                    <button class="btn btn-error" type="submit">Pay Now</button>
                                </form>
                            <?php endif; ?>
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