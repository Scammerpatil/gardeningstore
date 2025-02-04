<?php
$page_title = "User Profile";
include '../../server/database.php';
// session_start();
$customer_id = $_SESSION['customer_id'] ?? null;

if (!$customer_id) {
    die("<div class='text-red-500 text-center p-4'>Invalid User</div>");
}

$stmt = $conn->prepare("SELECT name, email, phone_no, address FROM customers WHERE customer_id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("<div class='text-red-500 text-center p-4'>User not found</div>");
}
ob_start();
?>

<div class="flex justify-center items-center min-h-screen">
    <div class="card w-96 bg-base-200 shadow-xl p-6">
        <div class="card-body">
            <h2 class="card-title text-primary"><?= htmlspecialchars($user['name']) ?></h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone_no'] ?? 'N/A') ?></p>
            <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($user['address'] ?? 'N/A')) ?></p>
            <div class="card-actions justify-end">
                <a href="edit_profile.php?id=<?= $customer_id ?>" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$stmt->close();
$conn->close();
?>