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

$query = "SELECT * FROM gardeners WHERE gardener_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $gardener_id);
$stmt->execute();
$result = $stmt->get_result();
$gardener = $result->fetch_assoc();

if (!$gardener) {
    die("Gardener not found.");
}

$services = json_decode($gardener['services'], true);
ob_start();
?>
<h1 class="text-3xl font-bold text-center uppercase">Hire <?= htmlspecialchars($gardener['name']); ?></h1>

<div class="max-w-lg mx-auto bg-base-100 border border-base-content shadow-md rounded px-8 py-6 mt-6">
    <form action="../../server/user/process_hire.php" method="POST" class="space-y-4 flex flex-col w-full">
        <input type="hidden" name="customer_id" value="<?= $customer_id; ?>">
        <input type="hidden" name="gardener_id" value="<?= $gardener_id; ?>">

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Gardener Name:</span></div>
            <input type="text" value="<?= htmlspecialchars($gardener['name']); ?>" class="input input-bordered w-full"
                disabled>
        </label>

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Select Tasks:</span></div>
            <div class="grid grid-cols-1 gap-2">
                <?php foreach ($services as $task => $charge): ?>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="task-checkbox checkbox checkbox-primary" name="task[]"
                            value="<?= htmlspecialchars($task); ?>" data-charge="<?= $charge; ?>">
                        <span><?= htmlspecialchars($task); ?> (₹<?= number_format($charge, 2); ?>/day)</span>
                    </label>
                <?php endforeach; ?>
            </div>
        </label>

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Hire From:</span></div>
            <input type="date" id="hireFrom" name="hire_date_from" class="input input-bordered w-full" required>
        </label>

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Hire Upto:</span></div>
            <input type="date" id="hireTo" name="hire_date_to" class="input input-bordered w-full" required>
        </label>

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Duration (Days):</span></div>
            <input type="number" id="durationDays" name="duration_days" class="input input-bordered w-full" min="1"
                readonly required>
        </label>

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Total Amount:</span></div>
            <input type="text" id="totalAmount" name="total_amount" class="input input-bordered w-full" readonly>
        </label>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-full" disabled id="confirmButton">Confirm Hiring</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const hireFrom = document.getElementById("hireFrom");
        const hireTo = document.getElementById("hireTo");
        const durationDays = document.getElementById("durationDays");
        const totalAmount = document.getElementById("totalAmount");
        const confirmButton = document.getElementById("confirmButton");
        const checkboxes = document.querySelectorAll(".task-checkbox");

        const today = new Date().toISOString().split("T")[0];
        hireFrom.setAttribute("min", today);
        hireTo.setAttribute("min", today);

        function calculateCharges() {
            const fromDate = new Date(hireFrom.value);
            const toDate = new Date(hireTo.value);

            let totalPerDay = 0;

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    totalPerDay += parseFloat(cb.getAttribute("data-charge"));
                }
            });

            if (fromDate && toDate && toDate >= fromDate && totalPerDay > 0) {
                const duration = Math.ceil((toDate - fromDate) / (1000 * 60 * 60 * 24)) + 1;
                durationDays.value = duration;
                totalAmount.value = "₹" + (totalPerDay * duration).toFixed(2);
                confirmButton.removeAttribute("disabled");
            } else {
                durationDays.value = "";
                totalAmount.value = "";
                confirmButton.setAttribute("disabled", true);
            }
        }

        checkboxes.forEach(cb => cb.addEventListener("change", calculateCharges));
        hireFrom.addEventListener("change", function () {
            hireTo.setAttribute("min", hireFrom.value);
            calculateCharges();
        });
        hireTo.addEventListener("change", calculateCharges);
    });
</script>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>