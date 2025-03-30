<?php
session_start();
include "../../server/database.php";

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in.");
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM plant_sales WHERE user_id = $user_id ");

$page_title = "Accept Sale Price";
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sale_id = $_POST['sale_id'];
    $acceptance = $_POST['acceptance'];

    $stmt = $conn->prepare("UPDATE plant_sales SET seller_acceptance = ? WHERE id = ?");
    $stmt->bind_param("si", $acceptance, $sale_id);

    if ($stmt->execute()) {
        echo "<p class='text-success font-bold text-center'>Response submitted.</p>";

        if ($acceptance === "Accepted") {
            $query = $conn->prepare("SELECT plant_name, category, quantity, suggested_price, image FROM plant_sales WHERE id = ?");
            $query->bind_param("i", $sale_id);
            $query->execute();
            $result = $query->get_result();
            $plant = $result->fetch_assoc();

            $plant_name = $plant['plant_name'];
            $subcategory = $plant['category'];
            $quantity = $plant['quantity'];
            $price = $plant['suggested_price'];
            $image = $plant['image'];

            $check_query = $conn->prepare("SELECT product_id, quantity FROM products WHERE name = ? AND category = 'Plant' AND subcategory = ?");
            $check_query->bind_param("ss", $plant_name, $subcategory);
            $check_query->execute();
            $existing_product = $check_query->get_result()->fetch_assoc();

            if ($existing_product) {
                $new_quantity = $existing_product['quantity'] + $quantity;
                $update_stmt = $conn->prepare("UPDATE products SET quantity = ? WHERE product_id = ?");
                $update_stmt->bind_param("ii", $new_quantity, $existing_product['product_id']);
                $update_stmt->execute();
            } else {
                $category = "Plant";
                $insert_stmt = $conn->prepare("INSERT INTO products (name, category, subcategory, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
                $insert_stmt->bind_param("ssssis", $plant_name, $category, $subcategory, $price, $quantity, $image);
                $insert_stmt->execute();
            }
        }
    } else {
        echo "<p class='text-error font-bold text-center'>Error updating status.</p>";
    }
}
?>

<h2 class="text-3xl font-bold text-center uppercase">Accept or Reject Sale Price</h2>
<div class="overflow-x-auto mt-6">
    <table class="table-auto w-full border-collapse border border-base-content">
        <thead>
            <tr class="bg-base-200">
                <th class="border px-4 py-2">Plant Name</th>
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">Category</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Admin Action</th>
                <th class="border px-4 py-2">Quantity</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td class="border px-4 py-2 text-center"><?= $row['plant_name'] ?></td>
                    <td class="border px-4 py-2 text-center"><?php
                    if ($row['image']) {
                        $image_data = base64_encode($row['image']);
                        echo "<img src='data:image/jpeg;base64,$image_data' alt='Plant Image' class='w-20 h-20 object-cover'>";
                    } else {
                        echo "No image available";
                    }
                    ?></td>
                    <td class="border px-4 py-2 text-center"><?= $row['category'] ?></td>
                    <td class="border px-4 py-2 text-center"><?= $row['suggested_price'] ?> ₹/piece</td>
                    <td class="border px-4 py-2 text-center"><?= $row['status'] ?></td>
                    <td class="border px-4 py-2 text-center"><?= $row['quantity'] ?></td>
                    <td class="border px-4 py-2 text-center">
                        <?php if ($row['status'] == "Pending") { ?>
                            Approval Pending From Admin
                        <?php } elseif ($row['status'] == "Approved") { ?>
                            <?php if ($row['seller_acceptance'] == 'Pending') { ?>
                                <form method='POST'>
                                    <input type='hidden' name='sale_id' value='<?= $row['id'] ?>'>
                                    <button name='acceptance' value='Accepted' class='btn btn-success rounded'>Accept</button>
                                    <button name='acceptance' value='Rejected' class='btn btn-error rounded'>Reject</button>
                                </form>
                            <?php } elseif ($row['seller_acceptance'] == 'Accepted') { ?>
                                <p class='text-success font-bold text-center'>Seller has accepted the sale.</p>
                            <?php } elseif ($row['seller_acceptance'] == 'Rejected') { ?>
                                <p class='text-error font-bold text-center'>Seller has rejected the sale.</p>
                            <?php } ?>
                        <?php } ?>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>