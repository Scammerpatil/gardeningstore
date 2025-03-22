<?php
include '../../server/database.php';
$page_title = "Manage Products";
ob_start();

// Fetch products from the database
$query = "SELECT * FROM products ORDER BY product_id DESC";
$result = $conn->query($query);
?>
<h2 class="text-3xl font-bold text-center uppercase">Manage Products</h2>

<div role="tablist" class="tabs tabs-bordered tabs-lg mt-4">

    <!-- Listed Products Tab -->
    <input type="radio" name="my_tabs_2" role="tab" class="tab text-lg font-semibold" style="width:300px"
        aria-label="Listed Product" checked="checked" />
    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
        <h2 class="text-3xl font-bold text-center uppercase">Listed Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card bg-base-100 shadow-xl">
                    <figure>
                        <img src="data:image/jpeg;base64,<?= base64_encode($row['image']); ?>"
                            alt="<?= htmlspecialchars($row['name']); ?>" class="h-48 w-full object-contain" />
                    </figure>
                    <div class="card-body text-center">
                        <h3 class="card-title"><?= htmlspecialchars($row['name']); ?></h3>
                        <p class="text-lg font-semibold text-primary">₹<?= number_format($row['price'], 2); ?></p>
                        <p class="text-sm"><?= htmlspecialchars($row['shortdesc']); ?></p>
                        <div class="card-actions justify-center">
                            <button class="btn btn-secondary"
                                onclick="confirmEdit(<?= $row['product_id']; ?>)">Edit</button>
                            <a class="btn btn-error" href="javascript:void(0);"
                                onclick="confirmDelete(<?= $row['product_id']; ?>)">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = "delete.php?id=" + id;
            }
        }

        function confirmEdit(id) {
            if (confirm("Do you want to edit this product?")) {
                window.location.href = "edit.php?id=" + id;
            }
        }
    </script>


    <!-- Add Product Tab -->
    <input type="radio" name="my_tabs_2" role="tab" class="tab text-lg font-semibold" style="width:300px"
        aria-label="Add Product" />
    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
        <h2 class="text-3xl font-bold text-center uppercase">Add New Product</h2>
        <form action="../../server/admin/addProduct.php" method="POST" enctype="multipart/form-data"
            class="mt-4 w-full">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="name">
                        Product Name
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="name" type="text" name="name" placeholder="Enter Product Name" required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="category">
                        Category
                    </label>
                    <select
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="category" name="category" onchange="updateSubcategories()" required>
                        <option value="">Select Category</option>
                        <option value="Plant">Plant</option>
                        <option value="Gardening Tool">Gardening Tool</option>
                        <option value="Seed">Seed</option>
                        <option value="Bulb">Bulb</option>
                        <option value="Soil & Fertilizer">Soil & Fertilizer</option>
                        <option value="Pebble">Pebble</option>
                        <option value="Accessory">Accessory</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="subcategory">
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
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="price">
                        Product Price
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="price" type="number" name="price" placeholder="Enter Product Price" required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="quantity">
                        Quantity
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="quantity" type="number" name="quantity" placeholder="Enter Product Quantity" required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="description">
                        Short Description
                    </label>
                    <textarea
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="description" name="shortdesc" placeholder="Enter Product's Short Description"
                        required></textarea>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="longdescription">
                        Long Description
                    </label>
                    <textarea
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="longdescription" name="longdesc" placeholder="Enter Product's Long Description"
                        required></textarea>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="size">
                        Plant Size
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="size" name="size" placeholder="Enter Product Size" required></input>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2" for="image">
                        Image
                    </label>
                    <input class="file-input file-input-base-100 file-input-bordered w-full" type="file" id="image"
                        name="image" placeholder="Enter Product Description" accept="image/*" required />
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <button class="btn btn-primary w-full">Add Product</button>
            </div>
        </form>
    </div>
</div>

<script>
    const subcategories = {
        "Gardening Tool": ["Watering Cans & Hoses", "Pest Control", "Garden Furniture", "Landscaping", "Garden Décor", "DIY Kits"],
        "Plant": ["Indoor Plants", "Outdoor Plants", "Flowering Plants", "Succulents", "Bonsai", "Medicinal Plants", "Air Purifying Plants"],
        "Seed": ["Vegetable Seeds", "Herb Seeds", "Flower Seeds", "Organic Seeds", "Exotic Seeds", "Grass Seeds", "Fruit Seeds"],
        "Bulb": ["Flower Bulbs", "Seasonal Bulbs", "Perennial Bulbs", "Exotic Bulbs", "Indoor Bulbs", "Outdoor Bulbs", "Decorative Bulbs"],
        "Soil & Fertilizer": ["Organic Fertilizer", "Potting Soil", "Coco Peat", "Vermicompost", "Nutrient Mixes", "Soil Amendments", "Specialty Fertilizers"],
        "Pebble": ["Decorative Pebbles", "Natural Stones", "River Rocks", "Colored Pebbles", "Aquarium Pebbles", "Garden Path Pebbles", "Gravel"],
        "Accessory": ["Plant Stands", "Garden Lighting", "Labels & Markers", "Sprayers & Misters", "Hanging Hooks", "Trellises & Supports", "Garden Storage"]
    };

    function updateSubcategories() {
        let categorySelect = document.getElementById("category");
        let subcategorySelect = document.getElementById("subcategory");
        let selectedCategory = categorySelect.value;

        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

        if (selectedCategory && subcategories[selectedCategory]) {
            subcategories[selectedCategory].forEach(subcategory => {
                let option = document.createElement("option");
                option.value = subcategory;
                option.textContent = subcategory;
                subcategorySelect.appendChild(option);
            });
        }
    }
</script>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
$conn->close();
?>