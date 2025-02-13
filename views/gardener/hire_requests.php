<?php
$page_title = "Manage Hire Requests";
include "../../server/database.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in as a gardener to view this page.");
}

$gardener_id = $_SESSION['user_id'];

// Handle request acceptance or rejection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hiring_id = $_POST['hiring_id'];
    $action = $_POST['action'];

    if ($action === "accept") {
        $status = "Accepted";
    } elseif ($action === "reject") {
        $status = "Rejected";
    } else {
        die("Invalid action.");
    }

    $stmt = $conn->prepare("UPDATE hire SET status = ? WHERE hiring_id = ? AND gardener_id = ?");
    $stmt->bind_param("sii", $status, $hiring_id, $gardener_id);

    if ($stmt->execute()) {
        echo "<script>alert('Request updated successfully!'); window.location.href='hire_requests.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch hire requests for the gardener
$query = "SELECT h.hiring_id, c.name AS customer_name, h.hire_date, h.duration_days, h.total_amount, h.status 
          FROM hire h 
          JOIN customers c ON h.customer_id = c.customer_id 
          WHERE h.gardener_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gardener_id);
$stmt->execute();
$result = $stmt->get_result();
ob_start();
?>

<section class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center">Manage Hire Requests</h1>
    <div class="overflow-x-auto mt-6">
        <table class="table w-full border-collapse border border-base-content">
            <thead>
                <tr class="bg-base-200 text-base text-center font-semibold">
                    <th class="border border-base-content p-3">Customer</th>
                    <th class="border border-base-content p-3">Hire Date</th>
                    <th class="border border-base-content p-3">Duration (Days)</th>
                    <th class="border border-base-content p-3">Total Amount</th>
                    <th class="border border-base-content p-3">Status</th>
                    <th class="border border-base-content p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center text-base">
                        <td class="p-3 border border-base-content"><?= htmlspecialchars($row['customer_name']); ?></td>
                        <td class="p-3 border border-base-content"><?= $row['hire_date']; ?></td>
                        <td class="p-3 border border-base-content"><?= $row['duration_days']; ?></td>
                        <td class="p-3 border border-base-content">₹<?= number_format($row['total_amount'], 2); ?></td>
                        <td class="p-3 border border-base-content font-bold"><?= $row['status']; ?></td>
                        <td class="p-3 border border-base-content">
                            <?php if ($row['status'] === "Pending"): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="hiring_id" value="<?= $row['hiring_id']; ?>">
                                    <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-error">Reject</button>
                                </form>
                            <?php else: ?>
                                <span class="text-base-content">No Actions</span>
                            <?php endif; ?>
                        </td>
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