<?php
session_start();
include "../../server/database.php";
$page_title = "Manage Gardeners";
ob_start();

// Fetch gardeners from the database
$query = "SELECT gardener_id, name, email, phone_no, services FROM gardeners";
$result = $conn->query($query);  // Make sure this query is executed before using $result

?>

<h2 class="text-3xl font-bold text-center uppercase">Manage Gardeners</h2>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="overflow-x-auto mt-6">
        <table class="table-auto w-full border-collapse border border-base-content">
            <thead class="bg-base-200">
                <tr>
                    <th class="border px-4 py-2">Gardener ID</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Phone No</th>
                    <?php
                    // Fetch first gardener's services to dynamically generate table headers
                    $service_query = "SELECT services FROM gardeners LIMIT 1";
                    $service_result = $conn->query($service_query);
                    $service_keys = [];

                    if ($service_result && $service_result->num_rows > 0) {
                        $row = $service_result->fetch_assoc();
                        $service_keys = array_keys(json_decode($row['services'], true));

                        foreach ($service_keys as $service) {
                            echo "<th class='border px-4 py-2'>$service (Per Day)</th>";
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Decode services JSON
                        $services = json_decode($row['services'], true);

                        echo "<tr class='border px-4 py-2 text-center'>";
                        echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['gardener_id']) . "</td>";
                        echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td class='border px-4 py-2'>" . (!empty($row['phone_no']) ? htmlspecialchars($row['phone_no']) : "Not Provided") . "</td>";

                        // Display service charges dynamically
                        foreach ($service_keys as $service) {
                            if (isset($services[$service])) {
                                echo "<td class='border px-4 py-2'>₹" . number_format($services[$service], 2) . "</td>";
                            } else {
                                echo "<td class='border px-4 py-2 text-gray-500'>Not Available</td>";
                            }
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='" . (count($service_keys) + 5) . "' class='text-center p-3'>No gardeners available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="text-center text-lg mt-6">No gardeners found.</p>
<?php endif; ?>

<?php
$conn->close();
$page_content = ob_get_clean();
include './components/layout.php';
?>
