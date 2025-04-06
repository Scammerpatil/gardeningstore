<?php
session_start();
$page_title = "Hire a Gardener Status";
include "../../server/database.php";

if (!isset($_SESSION['user_id'])) {
    die("Login required.");
}

$customer_id = $_SESSION['user_id'];

$query = "SELECT h.*, g.name AS gardener_name FROM hire h
          JOIN gardeners g ON h.gardener_id = g.gardener_id
          WHERE h.customer_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

ob_start();
?>

<h2 class="text-3xl font-bold text-center uppercase my-6">Hire Gardener Status</h2>

<div class="overflow-x-auto">
    <table class="table table-zebra w-full">
        <thead class="text-base">
            <tr>
                <th>Gardener Name</th>
                <th>Tasks</th>
                <th>From</th>
                <th>To</th>
                <th>Duration</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['gardener_name']); ?></td>
                    <td><?= htmlspecialchars($row['task']); ?></td>
                    <td><?= $row['hire_date_from']; ?></td>
                    <td><?= $row['hire_date_to']; ?></td>
                    <td><?= $row['duration_days']; ?> day(s)</td>
                    <td>₹<?= number_format($row['total_amount'], 2); ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <button class="btn btn-outline btn-sm"
                            onclick="openRatingModal(<?= $row['hiring_id']; ?>, <?= $row['gardener_id']; ?>)">Give
                            Rating</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Rating Modal -->
<input type="checkbox" id="ratingModal" class="modal-toggle" />
<div class="modal" role="dialog">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Rate the Gardener</h3>
        <form action="../../server/user/submit_rating.php" method="POST" class="space-y-3">
            <input type="hidden" name="gardener_id" id="modalGardenerId">
            <input type="hidden" name="customer_id" value="<?= $customer_id; ?>">

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Rating (1 to 5)</span></div>
                <input type="number" name="rating" min="1" max="5" class="input input-bordered w-full" required>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Review (optional)</span></div>
                <textarea name="review" class="textarea textarea-bordered w-full" rows="3"></textarea>
            </label>

            <div class="modal-action">
                <label for="ratingModal" class="btn">Cancel</label>
                <button type="submit" class="btn btn-primary">Submit Rating</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRatingModal(hireId, gardenerId) {
        document.getElementById("modalHireId").value = hireId;
        document.getElementById("modalGardenerId").value = gardenerId;
        document.getElementById("ratingModal").checked = true;
    }
</script>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>