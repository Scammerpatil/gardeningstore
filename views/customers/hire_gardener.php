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

                <?php
                // Fetch first gardener's services to dynamically generate table headers
                $query = "SELECT services FROM gardeners LIMIT 1";
                $result = $conn->query($query);
                $service_keys = [];

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $service_keys = array_keys(json_decode($row['services'], true));

                    foreach ($service_keys as $service) {
                        echo "<th class='border px-4 py-2'>$service (Per Day)</th>";
                    }
                }
                ?>

                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT gardener_id, name, email, phone_no, services FROM gardeners";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Decode services JSON
                    $services = json_decode($row['services'], true);

                    echo "<tr class='border px-4 py-2 text-center'>";
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

                    echo "<td class='border px-4 py-2'>
                            <a href='hire_form.php?gardener_id=" . $row['gardener_id'] . "' class='btn btn-primary'>
                                Hire
                            </a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='" . (count($service_keys) + 4) . "' class='text-center p-3'>No gardeners available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>