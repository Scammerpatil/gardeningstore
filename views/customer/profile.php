<?php
$page_title = "User Profile";
include '../../server/database.php';
session_start();
$customer_id = $_SESSION['user_id'] ?? null;

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
<h1 class="text-4xl font-bold text-center">Update Profile</h1>
<div class="max-w-lg mx-auto mt-6 p-6 bg-base-100 border border-base-content rounded-lg">
    <form method="POST">
        <div class="form-group mb-4">
            <label class="block text-lg font-semibold">Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"
                class="form-control w-full p-2 border rounded-lg" required>
        </div>

        <div class="form-group mb-4">
            <label class="block text-lg font-semibold">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                class="form-control w-full p-2 border rounded-lg" required>
        </div>

        <div class="form-group mb-4">
            <label class="block text-lg font-semibold">Phone Number</label>
            <input type="text" name="phone_no" value="<?= htmlspecialchars($user['phone_no'] ?? '') ?>"
                class="form-control w-full p-2 border rounded-lg">
        </div>

        <div class="form-group mb-4">
            <label class="block text-lg font-semibold">Address</label>
            <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>"
                class="form-control w-full p-2 border rounded-lg">
        </div>

        <div class="flex justify-between">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="gardener_dashboard.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$stmt->close();
$conn->close();
?>