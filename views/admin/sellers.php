<?php
session_start();
include "../../server/database.php";

if (!isset($_SESSION['user_id'])) {
    die("Admin access only.");
}

$page_title = "Manage Plant Sales";
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_sale'])) {
    $sale_id = $_POST['sale_id'];
    $status = $_POST['update_sale'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE plant_sales SET status = ?, suggested_price = ? WHERE id = ?");
    $stmt->bind_param("sdi", $status, $price, $sale_id);

    if ($stmt->execute()) {
        echo "<p class='text-success font-bold text-center'>Sale updated successfully.</p>";
    } else {
        echo "<p class='text-error font-bold text-center'>Error updating sale.</p>";
    }
    $stmt->close();
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
        ps.seller_acceptance
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
                <th class="border px-4 py-2">Action</th>
                <th class="border px-4 py-2">User Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <form method="POST">
                            <input type="hidden" name="sale_id" value="<?= $row['sale_id'] ?>">
                            <td class="border px-4 py-2 text-center"><?= $row['seller_name'] ?></td>
                            <td class="border px-4 py-2 text-center"><?= $row['seller_email'] ?></td>
                            <td class="border px-4 py-2 text-center"><?= $row['seller_phone'] ?></td>
                            <td class="border px-4 py-2 text-center"><?= $row['plant_name'] ?></td>
                            <td class="border px-4 py-2 text-center"><?= $row['category'] ?></td>
                            <td class="border px-4 py-2 text-center"><?= $row['quantity'] ?></td>
                            <td class="border px-4 py-2 text-center">
                                <input type="number" name="price" class="input input-primary input-bordered"
                                    value="<?= $row['suggested_price'] ?>">
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <button name="update_sale" value="Approved" class="btn btn-success rounded">Approve</button>
                                    <button name="update_sale" value="Rejected" class="btn btn-error rounded">Reject</button>
                                <?php } else {
                                    echo $row['status'];
                                } ?>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <?php
                                echo $row['seller_acceptance'];
                                ?>
                            </td>
                        </form>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="9" class="text-center py-4 text-base-content/80">No pending plant sales available.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>