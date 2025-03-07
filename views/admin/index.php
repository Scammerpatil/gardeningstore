<?php
include '../../server/database.php';
$page_title = "Dashboard";

$query_users = "SELECT 
    (SELECT COUNT(*) FROM customers) AS customers, 
    (SELECT COUNT(*) FROM gardeners) AS gardeners";
$result_users = $conn->query($query_users);
$users_data = $result_users->fetch_assoc();
$total_users = $users_data['customers'] + $users_data['gardeners'];

$query_orders = "SELECT COUNT(*) AS total_orders FROM orders";
$result_orders = $conn->query($query_orders);
$total_orders = $result_orders->fetch_assoc()['total_orders'];

$query_revenue = "SELECT SUM(total_amount) AS total_revenue FROM orders WHERE status = 'Completed'";
$result_revenue = $conn->query($query_revenue);
$total_revenue = $result_revenue->fetch_assoc()['total_revenue'] ?? 0;

$query_hire_requests = "SELECT COUNT(*) AS pending_requests FROM hire WHERE status = 'Pending'";
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
        <p class="text-sm text-base-content/80">
            Customers: <?= $users_data['customers']; ?>,<br> Gardeners: <?= $users_data['gardeners']; ?>
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
            <tr class="bg-base-200 text-base text-center font-semibold">
                <th class="text-base border border-base-content">Order ID</th>
                <th class="text-base border border-base-content">Customer</th>
                <th class="text-base border border-base-content">Total Amount</th>
                <th class="text-base border border-base-content">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $result_latest_orders->fetch_assoc()): ?>
                <tr class="text-center">
                    <td class="text-base border border-base-content">#<?= $order['order_id']; ?></td>
                    <td class="text-base border border-base-content"><?= htmlspecialchars($order['customer_name']); ?></td>
                    <td class="text-base border border-base-content">₹<?= number_format($order['total_amount'], 2); ?></td>
                    <td
                        class="text-base border border-base-content <?= $order['status'] === 'Completed' ? 'text-green-500' : 'text-yellow-500'; ?>">
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