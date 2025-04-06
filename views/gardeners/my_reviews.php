<?php
session_start();
include "../../server/database.php";

$gardener_id = $_SESSION["user_id"];
if (!isset($gardener_id)) {
    header("Location: /gardeningstore/login.php");
    exit();
}

$page_title = "My Reviews";
ob_start();
?>
<?php
$query = "SELECT gr.rating, gr.review, gr.posted_at, u.name AS customer_name
          FROM gardener_ratings gr
          JOIN customers u ON gr.customer_id = u.customer_id
          WHERE gr.gardener_id = ?
          ORDER BY gr.posted_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gardener_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-center mb-6">My Reviews</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card bg-base-100 shadow-xl border border-base-content">
                    <div class="card-body">
                        <h3 class="text-lg font-semibold text-primary"><?= htmlspecialchars($row['customer_name']) ?></h3>
                        <p class="text-warning text-xl"><?= str_repeat('⭐', intval($row['rating'])) ?> <span
                                class="text-base-content/50 text-sm">(<?= $row['rating'] ?>)</span></p>
                        <p class="text-base-content/70 mt-2"><?= htmlspecialchars($row['review']) ?></p>
                        <p class="text-xs text-base-content/80 mt-3"><?= date("F j, Y", strtotime($row['posted_at'])) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500 mt-6">No reviews received yet.</p>
    <?php endif; ?>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>