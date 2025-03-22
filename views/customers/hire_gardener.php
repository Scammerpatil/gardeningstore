<?php
session_start();
$page_title = "Hire a Gardener";
include "../../server/database.php";
ob_start();
?>

<h2 class="text-3xl font-bold text-center uppercase">Available Gardeners</h2>
<div class="overflow-x-auto mt-6">
    <table class="table-auto w-full border-collapse border border-base-content">
        <thead>
            <tr class="bg-base-200">
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Charges (Per Day)</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM gardeners";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border px-4 py-2 text-center'>";
                    echo "<td class='border px-4 py-2 text-center'>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td class='border px-4 py-2 text-center'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='border px-4 py-2 text-center'>" . (!empty($row['phone_no']) ? htmlspecialchars($row['phone_no']) : "Not Provided") . "</td>";
                    echo "<td class='border px-4 py-2 text-center'>" . (!empty($row['charges']) ? "₹" . number_format($row['charges'], 2) : "Contact for Pricing") . "</td>";
                    echo "<td class='border px-4 py-2 text-center'>
                                <a href='hire_form.php?gardener_id=" . $row['gardener_id'] . "' class='btn btn-primary'>
                                    Hire
                                </a>
                              </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center p-3'>No gardeners available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>