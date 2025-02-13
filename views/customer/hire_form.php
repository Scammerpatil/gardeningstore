<?php
session_start();
$page_title = "Hire Gardener";
include "../../server/database.php";

if (!isset($_SESSION['user_id'])) {
    die("You need to log in to hire a gardener.");
}

$customer_id = $_SESSION['user_id'];
$gardener_id = isset($_GET['gardener_id']) ? (int) $_GET['gardener_id'] : 0;

if (!$gardener_id) {
    die("Invalid gardener selected.");
}

// Fetch gardener details
$query = "SELECT * FROM gardeners WHERE gardener_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gardener_id);
$stmt->execute();
$result = $stmt->get_result();
$gardener = $result->fetch_assoc();

if (!$gardener) {
    die("Gardener not found.");
}
ob_start();
?>

<section class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center">Hire <?= htmlspecialchars($gardener['name']); ?></h1>

    <div class="max-w-lg mx-auto bg-base-100 border border-base-content shadow-md rounded px-8 py-6 mt-6">
        <form action="../../server/user/process_hire.php" method="POST"
            class="space-y-4 flex items-center flex-col w-full">
            <input type="hidden" name="customer_id" value="<?= $customer_id; ?>">
            <input type="hidden" name="gardener_id" value="<?= $gardener_id; ?>">
            <label class="form-control w-full font-bold">
                <div class="label">
                    <span class="text-base">Gardener Name:</span>
                </div>
                <input type="text" value="<?= htmlspecialchars($gardener['name']); ?>"
                    class="input input-bordered w-full" disabled>
            </label>

            <label class="form-control w-full font-bold">
                <div class="label">
                    <span class="text-base">Charges per Day:</span>
                </div>
                <input type="text" value="₹<?= number_format($gardener['charges'], 2); ?>"
                    class="input input-bordered w-full" disabled>
            </label>

            <label class="form-control w-full font-bold">
                <div class="label">
                    <span class="text-base">Duration (Days):</span>
                </div>
                <input type="number" name="duration_days" class="input input-bordered w-full" min="1" required>
            </label>

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-full">Confirm Hiring</button>
            </div>
        </form>
    </div>
</section>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>