<!DOCTYPE html>
<html lang="en" data-theme="lemonade">
<?php include './components/general/Header.php' ?>

<?php
include "./server/database.php";

function getAverageRating($gardener_id, $conn)
{
    $query = "SELECT AVG(rating) as avg_rating FROM gardener_ratings WHERE gardener_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $gardener_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return round($result['avg_rating'], 1);
}

$query = "SELECT gardener_id, name, email, phone_no, services FROM gardeners";
$result = $conn->query($query);
?>

<body style="font-family: Dosis, sans-serif;">
    <?php include './components/general/Navbar.php' ?>
    <?php include './components/general/Hero.php' ?>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center">Hire a Gardener</h1>
        <p class="text-center mt-4">Find the best gardeners available for your needs.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-10 px-10">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $services = json_decode($row['services'], true);
                    $rating = getAverageRating($row['gardener_id'], $conn);
                    ?>
                    <div class="card shadow-xl bg-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl text-primary"><?= htmlspecialchars($row['name']) ?></h2>
                            <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                            <p><strong>Phone:</strong>
                                <?= !empty($row['phone_no']) ? htmlspecialchars($row['phone_no']) : 'Not Provided' ?></p>

                            <div class="mt-2">
                                <span class="text-yellow-500 text-lg">
                                    <?= str_repeat('⭐', floor($rating)) ?>
                                </span>
                                <span class="text-sm text-gray-600 ml-2">(<?= $rating ?>)</span>
                            </div>

                            <div class="mt-4">
                                <h3 class="font-bold">Services</h3>
                                <ul class="list-disc list-inside text-sm">
                                    <?php foreach ($services as $service => $price): ?>
                                        <li><?= htmlspecialchars($service) ?>: ₹<?= number_format($price, 2) ?> / day</li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="card-actions mt-4">
                                <a href="login.php" class="btn btn-primary btn-block">Hire</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="col-span-full text-center text-lg text-base-content/80">No gardeners available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>