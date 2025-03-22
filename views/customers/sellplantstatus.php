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
            // Fetch plant details
            $query = $conn->prepare("SELECT plant_name, category, quantity, suggested_price FROM plant_sales WHERE id = ?");
            $query->bind_param("i", $sale_id);
            $query->execute();
            $result = $query->get_result();
            $plant = $result->fetch_assoc();

            $plant_name = $plant['plant_name'];
            $subcategory = $plant['category'];
            $quantity = $plant['quantity'];
            $price = $plant['suggested_price'];

            $check_query = $conn->prepare("SELECT product_id, quantity FROM products WHERE name = ? and category = 'plant' and subcategory = ?");
            $check_query->bind_param("ss", $plant_name, $subcategory);
            $check_query->execute();
            $existing_product = $check_query->get_result()->fetch_assoc();

            if ($existing_product) {
                // Update existing plant quantity
                $new_quantity = $existing_product['quantity'] + $quantity;
                $update_stmt = $conn->prepare("UPDATE products SET quantity = ? WHERE product_id = ?");
                $update_stmt->bind_param("ii", $new_quantity, $existing_product['product_id']);
                $update_stmt->execute();
            } else {
                // Insert new plant
                $category = "plant";
                $insert_stmt = $conn->prepare("INSERT INTO products (name, category, price, quantity) VALUES (?, ?, ?, ?)");
                $insert_stmt->bind_param("ssdi", $plant_name, $category, $subcategory, $price, $quantity);
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
                    <td class="border px-4 py-2 text-center"><?= $row['category'] ?></td>
                    <td class="border px-4 py-2 text-center"><?= $row['suggested_price'] ?> ₹/piece</td>
                    <td class="border px-4 py-2 text-center"><?= $row['status'] ?></td>
                    <td class="border px-4 py-2 text-center"><?= $row['quantity'] ?></td>
                    <td class="border px-4 py-2 text-center">
                        <?= $row['seller_acceptance'] == 'Accepted' ?
                            $row['seller_acceptance'] :
                            "<form method='POST'>
                                <input type='hidden' name='sale_id' value='{$row['id']}'>
                                <button name='acceptance' value='Accepted' class='btn btn-success rounded'>Accept</button>
                                <button name='acceptance' value='Rejected' class='btn btn-error rounded'>Reject</button>
                            </form>"
                            ?>
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