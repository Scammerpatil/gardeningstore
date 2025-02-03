<?php
include '../../server/database.php';
$page_title = "Dashboard";

$query_users = "SELECT 
    (SELECT COUNT(*) FROM customers) AS customers, 
    (SELECT COUNT(*) FROM gardeners) AS gardeners, 
    (SELECT COUNT(*) FROM sellers) AS sellers";
$result_users = $conn->query($query_users);
$users_data = $result_users->fetch_assoc();
$total_users = $users_data['customers'] + $users_data['gardeners'] + $users_data['sellers'];

$query_orders = "SELECT COUNT(*) AS total_orders FROM orders";
$result_orders = $conn->query($query_orders);
$total_orders = $result_orders->fetch_assoc()['total_orders'];

$query_revenue = "SELECT SUM(total_amount) AS total_revenue FROM orders WHERE status = 'Completed'";
$result_revenue = $conn->query($query_revenue);
$total_revenue = $result_revenue->fetch_assoc()['total_revenue'] ?? 0;

$query_hire_requests = "SELECT COUNT(*) AS pending_requests FROM hiring WHERE status = 'Pending'";
$result_hire_requests = $conn->query($query_hire_requests);
$pending_hire_requests = $result_hire_requests->fetch_assoc()['pending_requests'];

$query_latest_orders = "SELECT o.order_id, c.name AS customer_name, o.total_amount, o.status 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.customer_id 
    LIMIT 5";
$result_latest_orders = $conn->query($query_latest_orders);

ob_start();
?>

<!-- Dashboard Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-5">

    <!-- Total Users -->
    <div class="card w-full bg-base-100 shadow-xl p-5">
        <h2 class="text-xl font-bold">Total Users</h2>
        <p class="text-3xl font-extrabold text-primary"><?= $total_users; ?></p>
        <p class="text-sm text-gray-500">
            Customers: <?= $users_data['customers']; ?>, Gardeners: <?= $users_data['gardeners']; ?>, Sellers:
            <?= $users_data['sellers']; ?>
        </p>
    </div>

    <!-- Total Orders -->
    <div class="card w-full bg-base-100 shadow-xl p-5">
        <h2 class="text-xl font-bold">Total Orders</h2>
        <p class="text-3xl font-extrabold text-primary"><?= $total_orders; ?></p>
    </div>

    <!-- Revenue -->
    <div class="card w-full bg-base-100 shadow-xl p-5">
        <h2 class="text-xl font-bold">Total Revenue</h2>
        <p class="text-3xl font-extrabold text-primary">₹<?= number_format($total_revenue, 2); ?></p>
    </div>

    <!-- Pending Hire Requests -->
    <div class="card w-full bg-base-100 shadow-xl p-5">
        <h2 class="text-xl font-bold">Pending Hire Requests</h2>
        <p class="text-3xl font-extrabold text-primary"><?= $pending_hire_requests; ?></p>
    </div>
</div>

<!-- Latest Orders -->
<div class="mt-8">
    <h2 class="text-2xl font-bold">Recent Orders</h2>
    <table class="table w-full mt-3 bg-base-100 shadow-md">
        <thead>
            <tr class="bg-base-300 text-lg">
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $result_latest_orders->fetch_assoc()): ?>
                <tr>
                    <td>#<?= $order['id']; ?></td>
                    <td><?= htmlspecialchars($order['customer_name']); ?></td>
                    <td>₹<?= number_format($order['total_price'], 2); ?></td>
                    <td class="<?= $order['status'] === 'Completed' ? 'text-green-500' : 'text-yellow-500'; ?>">
                        <?= $order['status']; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>