<?php
session_start();
$page_title = "Sell Plant";
include "../../server/database.php";
ob_start();
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to sell a plant.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $plant_name = $_POST['name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        echo "<p class='text-error font-bold text-center'>Error with image upload.</p>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO plant_sales (user_id, plant_name, category, quantity, image, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("issis", $user_id, $plant_name, $category, $quantity, $image);

    if ($stmt->execute()) {
        echo "<p class='text-success font-bold text-center'>Plant listing submitted successfully. Awaiting admin approval.</p>";
    } else {
        echo "<p class='text-error font-bold text-center'>Error submitting listing.</p>";
    }

    $stmt->close();
}
?>
<h2 class="text-3xl font-bold text-center uppercase">Sell Your Plant</h2>
<form action="" method="POST" class="mt-4" enctype="multipart/form-data"> <!-- Add enctype="multipart/form-data" -->
    <div class="flex flex-wrap mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="name">
                Plant Name
            </label>
            <input
                class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                id="name" type="text" name="name" placeholder="Enter Product Name" required>
        </div>
    </div>
    <div class="flex flex-wrap mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="subcategory">
                Category
            </label>
            <select
                class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                name="category" required>
                <option value="">Select Category</option>
                <?php
                $categories = [
                    "Indoor Plants",
                    "Outdoor Plants",
                    "Flowering Plants",
                    "Succulents",
                    "Bonsai",
                    "Medicinal Plants",
                    "Air Purifying Plants",
                    "Cacti",
                    "Herbs",
                    "Ferns",
                    "Tropical Plants",
                    "Shrubs",
                    "Climbers",
                    "Aquatic Plants"
                ];
                for ($i = 0; $i < count($categories); $i++) {
                    echo "<option value='$categories[$i]'>$categories[$i]</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="flex flex-wrap mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="quantity">
                Quantity
            </label>
            <input
                class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                id="quantity" type="number" name="quantity" placeholder="Enter Product Quantity" required>
        </div>
    </div>
    <div class="flex flex-wrap mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="image">
                Image
            </label>
            <input class="file-input file-input-bordered w-full" id="image" type="file" name="image"
                placeholder="Enter Product Quantity" required>
        </div>
    </div>
    <div class="flex flex-wrap mb-6">
        <button class="btn btn-primary w-full">Add Product</button>
    </div>
</form>
<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>