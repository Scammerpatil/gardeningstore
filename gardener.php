<!DOCTYPE html>
<html lang="en" data-theme="lemonade">
<?php include './components/general/Header.php' ?>
<?php include './server/database.php' ?>
<?php
$query = "SELECT gardener_id, name, email, phone_no, charges FROM gardeners";
$result = $conn->query($query);
?>

<body style="font-family: Dosis, sans-serif;">
    <?php include './components/general/Navbar.php' ?>
    <?php include './components/general/Hero.php' ?>
    <section class="bg-base-300 py-10">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl font-bold text-center text-base-content uppercase">GARDENER</h1>
            <p class="text-xl text-center my-2">Our Hard Working Gardener</p>
            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-5">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $name = htmlspecialchars($row['name']);
                    $email = htmlspecialchars($row['email']);
                    $phone_no = !empty($row['phone_no']) ? htmlspecialchars($row['phone_no']) : "Not Provided";
                    $charges = !empty($row['charges']) ? "₹" . number_format($row['charges'], 2) . "/hour" : "Contact for Pricing";
                    $imageSrc = "https://avatar.iran.liara.run/public/" . number_format($row['gardener_id']);
                    ?>

                    <!-- Gardener Card -->
                    <div class="card w-80 bg-base-100 shadow-xl">
                        <figure><img src="<?php echo $imageSrc; ?>" alt="<?= $name; ?>"
                                class="h-48 w-full object-contain" />
                        </figure>
                        <div class="card-body text-center">
                            <h2 class="card-title justify-center text-lg font-bold"><?= $name; ?></h2>
                            <p><span class="font-semibold text-lg">Charges:</span> <?= $charges; ?></p>
                            <p><span class="font-semibold text-lg">Phone:</span> <?= $phone_no; ?></p>
                            <div class="card-actions justify-center">
                                <a href="mailto:<?= $email; ?>" class="btn btn-secondary"><i
                                        class="fa-solid fa-envelope"></i> Contact</a>
                                <a href="login.php" class="btn btn-primary"><i class="fa-solid fa-user-tie"></i> Hire</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
</body>

</html>