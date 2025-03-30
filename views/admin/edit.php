<?php
include '../../server/database.php';
$page_title = "Edit Product";
ob_start();

// Check if 'id' is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p class='text-center text-red-500'>Invalid Product ID.</p>";
    exit;
}

$product_id = $_GET['id'];

// Fetch the product from the database
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// If no product is found, show an error message
if (!$product) {
    echo "<p class='text-center text-red-500'>Product not found.</p>";
    exit;
}

?>

<h2 class="text-3xl font-bold text-center uppercase">Edit Product</h2>

<form action="../../server/admin/editProduct.php" method="POST" enctype="multipart/form-data" class="mt-4 w-full">
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']); ?>">

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-base font-bold mb-2" for="name">Product Name</label>
            <input class="block w-full bg-base-100 border rounded py-3 px-4" id="name" type="text" name="name"
                value="<?= htmlspecialchars($product['name']); ?>" required>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-base font-bold mb-2" for="category">Category</label>
            <select class="block w-full bg-base-100 border rounded py-3 px-4" id="category" name="category" required>
                <option value="Plant" <?= ($product['category'] == "Plant") ? "selected" : ""; ?>>Plant</option>
                <option value="Gardening Tool" <?= ($product['category'] == "Gardening Tool") ? "selected" : ""; ?>>
                    Gardening Tool</option>
                <option value="Seed" <?= ($product['category'] == "Seed") ? "selected" : ""; ?>>Seed</option>
                <option value="Bulb" <?= ($product['category'] == "Bulb") ? "selected" : ""; ?>>Bulb</option>
                <option value="Soil & Fertilizer" <?= ($product['category'] == "Soil & Fertilizer") ? "selected" : ""; ?>>
                    Soil & Fertilizer</option>
                <option value="Pebble" <?= ($product['category'] == "Pebble") ? "selected" : ""; ?>>Pebble</option>
                <option value="Accessory" <?= ($product['category'] == "Accessory") ? "selected" : ""; ?>>Accessory
                </option>
                <option value="Pots" <?= ($product['category'] == "Pots") ? "selected" : ""; ?>>Pots
                </option>
            </select>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="subcategory">
                Sub Category
            </label>
            <select
                class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                id="subcategory" name="subcategory" required>
                <option value="">Select Subcategory</option>
            </select>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-base font-bold mb-2" for="price">Product Price</label>
            <input class="block w-full bg-base-100 border rounded py-3 px-4" id="price" type="number" name="price"
                value="<?= htmlspecialchars($product['price']); ?>" required>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-base font-bold mb-2" for="quantity">Quantity</label>
            <input class="block w-full bg-base-100 border rounded py-3 px-4" id="quantity" type="number" name="quantity"
                value="<?= htmlspecialchars($product['quantity']); ?>" required>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-base font-bold mb-2" for="description">Short
                Description</label>
            <textarea class="block w-full bg-base-100 border rounded py-3 px-4" id="description" name="shortdesc"
                required><?= htmlspecialchars($product['shortdesc']); ?></textarea>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-base font-bold mb-2" for="longdescription">Long
                Description</label>
            <textarea class="block w-full bg-base-100 border rounded py-3 px-4" id="longdescription" name="longdesc"
                required><?= htmlspecialchars($product['longdesc']); ?></textarea>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-base font-bold mb-2" for="size">Plant Size</label>
            <input class="block w-full bg-base-100 border rounded py-3 px-4" id="size" name="size"
                value="<?= htmlspecialchars($product['size']); ?>" required>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-base font-bold mb-2" for="image">Current Image</label>
            <img src="data:image/jpeg;base64,<?= base64_encode($product['image']); ?>" class="h-40 w-auto mb-3"
                alt="Product Image">
            <input class="file-input file-input-bordered w-full" type="file" id="image" name="image" accept="image/*">
            <small class="text-sm">Leave blank if you don’t want to change the image.</small>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
        <button type="submit" class="btn btn-primary w-full">Update Product</button>
    </div>
</form>

<script>
    const subcategories = {
        "Gardening Tool": ["Watering Cans & Hoses", "Pest Control", "Garden Furniture", "Landscaping", "Garden Décor", "DIY Kits"],
        "Plant": ["Indoor Plants", "Outdoor Plants", "Flowering Plants", "Succulents", "Bonsai", "Medicinal Plants", "Air Purifying Plants"],
        "Seed": ["Vegetable Seeds", "Herb Seeds", "Flower Seeds", "Organic Seeds", "Exotic Seeds", "Grass Seeds", "Fruit Seeds"],
        "Bulb": ["Flower Bulbs", "Seasonal Bulbs", "Perennial Bulbs", "Exotic Bulbs", "Indoor Bulbs", "Outdoor Bulbs", "Decorative Bulbs"],
        "Soil & Fertilizer": ["Organic Fertilizer", "Potting Soil", "Coco Peat", "Vermicompost", "Nutrient Mixes", "Soil Amendments", "Specialty Fertilizers"],
        "Pebble": ["Decorative Pebbles", "Natural Stones", "River Rocks", "Colored Pebbles", "Aquarium Pebbles", "Garden Path Pebbles", "Gravel"],
        "Accessory": ["Plant Stands", "Garden Lighting", "Labels & Markers", "Sprayers & Misters", "Hanging Hooks", "Trellises & Supports", "Garden Storage"],
        "Pots": ["Ceramic Pots", "Plastic Pots", "Terracotta Pots", "Hanging Pots", "Self-Watering Pots", "Decorative Pots", "Planters"]
    };

    function updateSubcategories() {
        let categorySelect = document.getElementById("category");
        let subcategorySelect = document.getElementById("subcategory");
        let selectedCategory = categorySelect.value;
        let selectedSubcategory = "<?= htmlspecialchars($product['subcategory'] ?? ''); ?>"; // Retain old subcategory

        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

        if (selectedCategory && subcategories[selectedCategory]) {
            subcategories[selectedCategory].forEach(subcategory => {
                let option = document.createElement("option");
                option.value = subcategory;
                option.textContent = subcategory;
                if (subcategory === selectedSubcategory) {
                    option.selected = true; // Pre-select the stored subcategory
                }
                subcategorySelect.appendChild(option);
            });
        }
    }

    // Run function on page load
    document.addEventListener("DOMContentLoaded", () => {
        updateSubcategories();
    });

    // Update subcategories when category changes
    document.getElementById("category").addEventListener("change", updateSubcategories);
</script>



<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>