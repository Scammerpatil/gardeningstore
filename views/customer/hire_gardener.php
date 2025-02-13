<?php
session_start();
$page_title = "Hire a Gardener";
include "../../server/database.php";
ob_start();
?>

<section class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center">Available Gardeners</h1>
    <div class="overflow-x-auto mt-6">
        <table class="table w-full border-collapse border border-base-content text-base">
            <thead>
                <tr class="bg-base-200">
                    <th class="border border-base-content text-center">Name</th>
                    <th class="border border-base-content text-center">Email</th>
                    <th class="border border-base-content text-center">Phone</th>
                    <th class="border border-base-content text-center">Charges (per day)</th>
                    <th class="border border-base-content text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM gardeners";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='border border-base-content text-center'>";
                        echo "<td class='border border-base-content'>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td class='border border-base-content'>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td class='border border-base-content'>" . (!empty($row['phone_no']) ? htmlspecialchars($row['phone_no']) : "Not Provided") . "</td>";
                        echo "<td class='border border-base-content'>" . (!empty($row['charges']) ? "₹" . number_format($row['charges'], 2) : "Contact for Pricing") . "</td>";
                        echo "<td class='border border-base-content'>
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
</section>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>