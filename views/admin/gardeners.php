<?php
session_start();
include "../../server/database.php";
$page_title = "Manage Gardeners";

// Fetch gardeners from the database
$query = "SELECT gardener_id, name, email, phone_no, charges FROM gardeners";
$result = $conn->query($query);
?>

<h2 class="text-3xl font-bold text-center uppercase">Manage Gardeners</h2>

<?php if ($result->num_rows > 0): ?>
    <div class="overflow-x-auto mt-6">
        <table class="table-auto w-full border-collapse border border-base-content">
            <thead class="bg-base-200">
                <tr>
                    <th class="border px-4 py-2">Gardener ID</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Phone No</th>
                    <th class="border px-4 py-2">Charges (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="border px-4 py-2"><?= $row["gardener_id"] ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row["name"]) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row["email"]) ?></td>
                        <td class="border px-4 py-2"><?= $row["phone_no"] ?: 'N/A' ?></td>
                        <td class="border px-4 py-2">₹<?= number_format($row["charges"], 2) ?: 'N/A' ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="text-center text-lg mt-6">No gardeners found.</p>
<?php endif; ?>

<?php
$conn->close();
?>


<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>