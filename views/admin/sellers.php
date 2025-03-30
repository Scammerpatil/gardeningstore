<?php
session_start();
include "../../server/database.php";

if (!isset($_SESSION['user_id'])) {
    die("Admin access only.");
}

$page_title = "Manage Plant Sales";
ob_start();

// Update Status and Price logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_status'])) { // For status update (Approve/Reject)
        $sale_id = $_POST['sale_id'];
        $status = $_POST['update_status'];

        $stmt = $conn->prepare("UPDATE plant_sales SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $sale_id);

        if ($stmt->execute()) {
            echo "<p class='text-success font-bold text-center'>Sale status updated successfully.</p>";
        } else {
            echo "<p class='text-error font-bold text-center'>Error updating sale status.</p>";
        }
        $stmt->close();
    }

    if (isset($_POST['update_price'])) { // For price update
        $sale_id = $_POST['sale_id'];
        $price = $_POST['price'];

        $stmt = $conn->prepare("UPDATE plant_sales SET suggested_price = ? WHERE id = ?");
        $stmt->bind_param("di", $price, $sale_id);

        if ($stmt->execute()) {
            echo "<p class='text-success font-bold text-center'>Price updated successfully.</p>";
        } else {
            echo "<p class='text-error font-bold text-center'>Error updating price.</p>";
        }
        $stmt->close();
    }
}

// Fetch Plant Sales with Seller Details
$query = "
    SELECT 
        ps.id AS sale_id,
        c.name AS seller_name,
        c.email AS seller_email,
        c.phone_no AS seller_phone,
        ps.plant_name,
        ps.category,
        ps.quantity,
        ps.status,
        ps.suggested_price,
        ps.seller_acceptance,
        ps.image
    FROM plant_sales ps
    JOIN customers c ON ps.user_id = c.customer_id
    ORDER BY ps.status ASC, ps.created_at DESC
";

$result = $conn->query($query);
?>

<h2 class="text-3xl font-bold text-center uppercase">Manage Plant Sales</h2>
<div class="overflow-x-auto mt-6">
    <table class="table-auto w-full border-collapse border border-base-content">
        <thead>
            <tr class="bg-base-200">
                <th class="border px-4 py-2">Seller Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Plant Name</th>
                <th class="border px-4 py-2">Category</th>
                <th class="border px-4 py-2">Quantity</th>
                <th class="border px-4 py-2">Set Price</th>
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">Action</th>
                <th class="border px-4 py-2">User Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td class="border px-4 py-2 text-center"><?= $row['seller_name'] ?></td>
                        <td class="border px-4 py-2 text-center"><?= $row['seller_email'] ?></td>
                        <td class="border px-4 py-2 text-center"><?= $row['seller_phone'] ?></td>
                        <td class="border px-4 py-2 text-center"><?= $row['plant_name'] ?></td>
                        <td class="border px-4 py-2 text-center"><?= $row['category'] ?></td>
                        <td class="border px-4 py-2 text-center"><?= $row['quantity'] ?></td>
                        <td class="border px-4 py-2 text-center">
                            <?php
                            if ($row['status'] == 'Pending') { ?>
                                Pending
                            <?php } else if ($row['status'] == 'Approved') {
                                if ($row['suggested_price'] == 0) { ?>
                                        <form action="" method="POST" class="flex flex-row px-10 gap-2">
                                            <input type="hidden" name="sale_id" value="<?= $row['sale_id'] ?>">
                                            <input type="number" name="price" value="<?= $row['suggested_price'] ?>"
                                                class="input input-bordered w-24" required>
                                            <button name="update_price" class="btn btn-success rounded">Set Price</button>
                                        </form>
                                <?php } else { ?>
                                        <span>Suggested Price: <?= $row['suggested_price'] ?></span>
                                <?php }
                            } else { ?>
                                    Not Approved
                            <?php } ?>

                        </td>
                        <td class="border px-4 py-2 text-center">
                            <?php
                            if ($row['image']) {
                                $image_data = base64_encode($row['image']);
                                echo "<img src='data:image/jpeg;base64,$image_data' alt='Plant Image' class='w-20 h-20 object-cover'>";
                            } else {
                                echo "No image available";
                            }
                            ?>
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <form action="" class="flex flex-row gap-2" method="POST">
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <input type="hidden" name="sale_id" value="<?= $row['sale_id'] ?>">
                                    <button name="update_status" value="Approved" class="btn btn-success rounded">Approve</button>
                                    <button name="update_status" value="Rejected" class="btn btn-error rounded">Reject</button>
                                <?php } else {
                                    echo $row['status'];
                                } ?>
                            </form>
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <?php
                            echo $row['seller_acceptance'];
                            ?>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="10" class="text-center py-4 text-base-content/80">No pending plant sales available.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>