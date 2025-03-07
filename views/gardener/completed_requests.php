<?php
session_start();
$page_title = "Completed Requests";
include "../../server/database.php";

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in as a gardener to view this page.");
}

$gardener_id = $_SESSION['user_id'];

// Fetch completed jobs
$query = "SELECT h.hiring_id, c.name AS customer_name, h.hire_date, h.duration_days, h.total_amount 
          FROM hire h 
          JOIN customers c ON h.customer_id = c.customer_id 
          WHERE h.gardener_id = ? AND h.status = 'Accepted'";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gardener_id);
$stmt->execute();
$result = $stmt->get_result();

ob_start();
?>

<section class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center">Completed Jobs</h1>
    <div class="overflow-x-auto mt-6">
        <table class="table w-full border-collapse border border-base-content">
            <thead>
                <tr class="bg-base-200 text-base text-center font-semibold">
                    <th class="border border-base-content p-3">Customer</th>
                    <th class="border border-base-content p-3">Hire Date</th>
                    <th class="border border-base-content p-3">Duration (Days)</th>
                    <th class="border border-base-content p-3">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="p-3 border border-base-content"><?= htmlspecialchars($row['customer_name']); ?></td>
                        <td class="p-3 border border-base-content"><?= $row['hire_date']; ?></td>
                        <td class="p-3 border border-base-content"><?= $row['duration_days']; ?></td>
                        <td class="p-3 border border-base-content">₹<?= number_format($row['total_amount'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>