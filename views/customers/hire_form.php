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
        <input type="hidden" id="serviceCharges" value='<?= json_encode($services); ?>'>

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Gardener Name:</span></div>
            <input type="text" value="<?= htmlspecialchars($gardener['name']); ?>" class="input input-bordered w-full"
                disabled>
        </label>

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Select Task:</span></div>
            <select id="taskSelect" name="task" class="select select-bordered w-full" required>
                <option value="">Select Task</option>
                <?php foreach ($services as $task => $charge): ?>
                    <option value="<?= htmlspecialchars($task); ?>" data-charge="<?= $charge; ?>">
                        <?= htmlspecialchars($task); ?> (₹<?= number_format($charge, 2); ?>/day)
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label class="form-control w-full font-bold">
            <div class="label"><span class="text-base">Charges Per Day:</span></div>
            <input type="text" id="chargesPerDay" class="input input-bordered w-full" disabled>
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
            <input type="text" id="totalAmount" class="input input-bordered w-full" readonly>
        </label>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-full" disabled id="confirmButton">Confirm Hiring</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let hireFrom = document.getElementById("hireFrom");
        let hireTo = document.getElementById("hireTo");
        let durationDays = document.getElementById("durationDays");
        let totalAmount = document.getElementById("totalAmount");
        let chargesPerDay = document.getElementById("chargesPerDay");
        let taskSelect = document.getElementById("taskSelect");
        let confirmButton = document.getElementById("confirmButton");

        let today = new Date().toISOString().split("T")[0];
        hireFrom.setAttribute("min", today);
        hireTo.setAttribute("min", today);

        function updateTotalAmount() {
            let fromDate = new Date(hireFrom.value);
            let toDate = new Date(hireTo.value);
            let selectedTask = taskSelect.value;
            let chargePerDay = parseFloat(taskSelect.options[taskSelect.selectedIndex].getAttribute("data-charge"));

            if (fromDate && toDate && toDate >= fromDate && !isNaN(chargePerDay)) {
                let duration = Math.ceil((toDate - fromDate) / (1000 * 60 * 60 * 24)) + 1;
                durationDays.value = duration;
                totalAmount.value = "₹" + (duration * chargePerDay).toFixed(2);
                confirmButton.removeAttribute("disabled");
            } else {
                durationDays.value = "";
                totalAmount.value = "";
                confirmButton.setAttribute("disabled", "true");
            }
        }

        taskSelect.addEventListener("change", function () {
            let selectedTask = taskSelect.value;
            let chargePerDay = taskSelect.options[taskSelect.selectedIndex].getAttribute("data-charge");

            if (chargePerDay) {
                chargesPerDay.value = "₹" + parseFloat(chargePerDay).toFixed(2);
            } else {
                chargesPerDay.value = "";
            }
            updateTotalAmount();
        });

        hireFrom.addEventListener("change", function () {
            hireTo.setAttribute("min", hireFrom.value);
            updateTotalAmount();
        });

        hireTo.addEventListener("change", updateTotalAmount);
    });
</script>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>