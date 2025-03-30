<?php
session_start();
include "../../server/database.php";

$gardener_id = $_SESSION["user_id"];
if (!isset($gardener_id)) {
    header("Location: /gardeningstore/login.php");
    exit();
}

$page_title = "Update Profile";
ob_start();

$query = "SELECT name, email, phone_no, services FROM gardeners WHERE gardener_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gardener_id);
$stmt->execute();
$result = $stmt->get_result();
$gardener = $result->fetch_assoc();
$stmt->close();

$services = json_decode($gardener['services'], true) ?? [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone_no = trim($_POST["phone_no"]);

    $updated_services = json_encode([
        "Gardening" => $_POST["service_gardening"],
        "Lawn Mowing" => $_POST["service_lawn_mowing"],
        "Tree Trimming" => $_POST["service_tree_trimming"],
        "Weed Removal" => $_POST["service_weed_removal"],
        "Planting" => $_POST["service_planting"],
        "Other" => $_POST["service_other"]
    ]);

    if (empty($name) || empty($email) || empty($phone_no) || empty($updated_services)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        $update_query = "UPDATE gardeners SET name = ?, email = ?, phone_no = ?, services = ? WHERE gardener_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssssi", $name, $email, $phone_no, $updated_services, $gardener_id);

        if ($stmt->execute()) {
            echo "<script>alert('Profile updated successfully!'); window.location.href='/gardeningstore/views/gardeners/';</script>";
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
            <!-- Name -->
            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($gardener['name']) ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <!-- Email -->
            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($gardener['email']) ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <!-- Phone Number -->
            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Phone Number</label>
                <input type="text" name="phone_no" value="<?= htmlspecialchars($gardener['phone_no'] ?? '') ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <!-- Services Pricing -->
            <h2 class="text-xl font-bold text-center my-4">Service Pricing</h2>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Gardening (₹ per day)</label>
                <input type="number" name="service_gardening"
                    value="<?= htmlspecialchars($services['Gardening'] ?? '') ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Lawn Mowing (₹ per day)</label>
                <input type="number" name="service_lawn_mowing"
                    value="<?= htmlspecialchars($services['Lawn Mowing'] ?? '') ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Tree Trimming (₹ per day)</label>
                <input type="number" name="service_tree_trimming"
                    value="<?= htmlspecialchars($services['Tree Trimming'] ?? '') ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Weed Removal (₹ per day)</label>
                <input type="number" name="service_weed_removal"
                    value="<?= htmlspecialchars($services['Weed Removal'] ?? '') ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Planting (₹ per day)</label>
                <input type="number" name="service_planting"
                    value="<?= htmlspecialchars($services['Planting'] ?? '') ?>"
                    class="form-control w-full p-2 border rounded-lg" required>
            </div>

            <div class="form-group mb-4">
                <label class="block text-lg font-semibold">Other Services (₹ per day)</label>
                <input type="number" name="service_other" value="<?= htmlspecialchars($services['Other'] ?? '') ?>"
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