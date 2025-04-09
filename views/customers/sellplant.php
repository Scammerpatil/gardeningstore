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

<!-- Background Image Wrapper -->
<div class="bg-cover bg-center min-h-screen flex items-center justify-center" >
<!-- Background Styling -->
<style>
    body {
        background-image: url('../../img/bg-img/seller.jpg');background-size: cover;
        background-size :1400px 1000px ;
        background-position:320px 100px;
        background-repeat: no-repeat;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.8); 
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
</style>



>
    <form action="" method="POST" class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg w-full max-w-md" enctype="multipart/form-data">
        <h2 class="text-2xl font-bold text-center uppercase mb-6">Sell Your Plant</h2>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="name">Plant Name</label>
            <input
                class="appearance-none block w-full bg-base-100 text-base-content rounded py-2 px-4 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                id="name" type="text" name="name" placeholder="Enter Product Name" required>
        </div>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="category">Category</label>
            <select
                class="appearance-none block w-full bg-base-100 text-base-content rounded py-2 px-4 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                name="category" required>
                <option value="">Select Category</option>
                <?php
                $categories = [
                    "Indoor Plants", "Outdoor Plants", "Flowering Plants", "Succulents", "Bonsai", "Medicinal Plants",
                    "Air Purifying Plants", "Cacti", "Herbs", "Ferns", "Tropical Plants", "Shrubs", "Climbers", "Aquatic Plants"
                ];
                foreach ($categories as $cat) {
                    echo "<option value='$cat'>$cat</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="quantity">Quantity</label>
            <input
                class="appearance-none block w-full bg-base-100 text-base-content rounded py-2 px-4 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                id="quantity" type="number" name="quantity" placeholder="Enter Product Quantity" required>
        </div>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="image">Image</label>
            <input class="file-input file-input-bordered w-full" id="image" type="file" name="image" required>
        </div>

        <button class="btn btn-primary w-full">Add Product</button>
    </form>
</div>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>