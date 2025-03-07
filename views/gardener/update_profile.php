<?php
session_start();
include "../../server/database.php";

// Ensure the user is logged in and is a gardener
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "gardener") {
    header("Location: ../../login.php");
    exit();
}

$gardener_id = $_SESSION["user_id"];
if (!isset($gardener_id)) {
    header("Location: /gardeningstore/login.php");
    exit();
}
$page_title = "Update Profile";
ob_start();

// Fetch Gardener Details
$query = "SELECT name, email, phone_no, charges FROM gardeners WHERE gardener_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gardener_id);
$stmt->execute();
$result = $stmt->get_result();
$gardener = $result->fetch_assoc();
$stmt->close();

// Handle Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone_no = trim($_POST["phone_no"]);
    $charges = trim($_POST["charges"]);

    if (empty($name) || empty($email)) {
        echo "<script>alert('Name and Email are required!');</script>";
    } else {
        $update_query = "UPDATE gardeners SET name = ?, email = ?, phone_no = ?, charges = ? WHERE gardener_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssssi", $name, $email, $phone_no, $charges, $gardener_id);

        if ($stmt->execute()) {
            echo "<script>alert('Profile updated successfully!'); window.location.href='/gardeningstore/views/gardener/';</script>";
        } else {
            echo "<script>alert('Failed to update profile. Try again!');</script>";
        }
        $stmt->close();
    }
}

?>

<section class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center">Update Profile</h1>

    <div class="max-w-lg mx-auto mt-6 p-6 bg-base-100 border border-base-content rounded-lg">
        <form method="POST">
            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($gardener['name']) ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($gardener['email']) ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Phone Number</label>
                <input type="text" name="phone_no" value="<?= htmlspecialchars($gardener['phone_no'] ?? '') ?>"
                    class="form-control w-full p-2 border rounded-lg">
            </div>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Charges (₹ per hour)</label>
                <input type="number" name="charges" value="<?= htmlspecialchars($gardener['charges'] ?? '') ?>"
                    class="form-control w-full p-2 border rounded-lg">
            </div>

            <div class="flex justify-between">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="gardener_dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</section>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>