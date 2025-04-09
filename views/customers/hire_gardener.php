<?php
session_start();
$page_title = "Hire a Gardener";
include "../../server/database.php";
ob_start();
function getAverageRating($gardener_id, $conn)
{
    $query = "SELECT AVG(rating) as avg_rating FROM gardener_ratings WHERE gardener_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $gardener_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return round($result['avg_rating'], 1);
}
?>

<h2 class="text-3xl font-bold text-center uppercase">Available Gardeners</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-10 px-10">
    <?php
    $query = "SELECT gardener_id, name, email, phone_no, services FROM gardeners";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Decode services JSON
            $services = json_decode($row['services'], true);
            $rating = getAverageRating($row['gardener_id'], $conn); // Assuming getAverageRating function is defined
            $service_keys = array_keys($services); // Get the service keys dynamically
    
            $imageSrc = "https://avatar.iran.liara.run/public/" . number_format($row['gardener_id']);
            ?>
            <div class="card w-80 bg-base-200 shadow-xl">
                <figure><img src="<?php echo $imageSrc; ?>" alt="<?= htmlspecialchars($row['name']); ?>"
                        class="h-48 w-full object-contain" /></figure>
                <div class="card-body">
                    <h2 class="card-title text-xl text-primary"><?= htmlspecialchars($row['name']); ?></h2>
                    <p><strong>Email:</strong> <?= htmlspecialchars($row['email']); ?></p>
                    <p><strong>Phone:</strong>
                        <?= !empty($row['phone_no']) ? htmlspecialchars($row['phone_no']) : 'Not Provided'; ?></p>

                    <div class="mt-2">
                        <span class="text-error text-lg"><?= str_repeat('⭐', floor($rating)); ?></span>
                                <span class="text-sm text-base-content/60 ml-2">(<?= $rating; ?>)</span>
                    </div>

                    <div class="mt-4">
                        <h3 class="font-bold">Services</h3>
                        <ul class="list-disc list-inside text-sm">
                            <?php foreach ($service_keys as $service): ?>
                                <li><?= htmlspecialchars($service); ?>: ₹<?= number_format($services[$service], 2); ?> / day</li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="card-actions mt-4">
                        <a href="hire_form.php?gardener_id=<?= $row['gardener_id']; ?>"
                            class="btn btn-primary btn-block">Hire</a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <p class="col-span-full text-center text-lg text-base-content/80">No gardeners available at the moment.</p>
        <?php
    }
    ?>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>