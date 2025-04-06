<?php
session_start();
$page_title = "Hire a Gardener";
include "../../server/database.php";
ob_start();

// Function to get the average rating
function getAverageRating($gardener_id, $conn) {
    $query = "SELECT AVG(rating) as avg_rating FROM ratings WHERE gardener_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $gardener_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return round($result['avg_rating'], 1);
}

?>

<h2 class="text-3xl font-bold text-center uppercase">Available Gardeners</h2>
<div class="overflow-x-auto mt-6">
    <table class="table-auto w-full border-collapse border border-base-content">
        <thead>
            <tr class="bg-base-200">
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Rating</th> <!-- Rating Column -->

                <?php
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
                    $services = json_decode($row['services'], true);
                    $rating = getAverageRating($row['gardener_id'], $conn);

                    echo "<tr class='border px-4 py-2 text-center'>";
                    echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td class='border px-4 py-2'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='border px-4 py-2'>" . (!empty($row['phone_no']) ? htmlspecialchars($row['phone_no']) : "Not Provided") . "</td>";

                    // Display rating with stars
                    echo "<td class='border px-4 py-2'>";
                    echo "<span class='text-yellow-500'>" . str_repeat("⭐", $rating) . "</span> ($rating)";
                    echo "<br><select class='rating-dropdown' data-gardener='" . $row['gardener_id'] . "'>
                            <option value='1'>⭐</option>
                            <option value='2'>⭐⭐</option>
                            <option value='3'>⭐⭐⭐</option>
                            <option value='4'>⭐⭐⭐⭐</option>
                            <option value='5'>⭐⭐⭐⭐⭐</option>
                          </select>";
                    echo "</td>";

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

<script>
document.querySelectorAll('.rating-dropdown').forEach(dropdown => {
    dropdown.addEventListener('change', function() {
        let gardenerId = this.getAttribute('data-gardener');
        let rating = this.value;

        fetch('rate_gardener.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `gardener_id=${gardenerId}&rating=${rating}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        });
    });
});
</script>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>
