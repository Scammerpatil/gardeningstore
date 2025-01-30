<!DOCTYPE html>
<html lang="en">
<?php include "../../components/admin/header.php" ?>

<?php
session_start();
?>

<body>
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="../../img/core-img/leaf.png" alt="">
        </div>
    </div>
    <?php include "../../components/admin/navbar.php" ?>
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center"
            style="background-image: url(../../img/bg-img/24.jpg);">
            <h2>PRODUCTS</h2>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href=""><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Portfolio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Single Portfolio</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container">
                <h2>Hey Admin, Add Your Product</h2>
                <form action="../../server/admin/addProduct.php" class="form mt-2" method="POST"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control" onchange="updateSubcategories()"
                            required>
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

                    <div class="form-group">
                        <label for="subcategory">Sub Category</label>
                        <select name="subcategory" id="subcategory" class="form-control" required>
                            <option value="">Select Subcategory</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                    </div>

                    <div class="form-group">
                        <button class="btn alazea-btn">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php include "../../components/admin/scripts.php" ?>
    <script>
        // Mapping categories to subcategories
        const subcategories = {
            "Gardening Tool": [
                "Watering Cans & Hoses", "Pest Control",
                "Garden Furniture", "Landscaping", "Garden Décor", "DIY Kits"
            ],
            "Plant": [
                "Indoor Plants", "Outdoor Plants", "Flowering Plants",
                "Succulents", "Bonsai", "Medicinal Plants", "Air Purifying Plants"
            ],
            "Seed": [
                "Vegetable Seeds", "Herb Seeds", "Flower Seeds",
                "Organic Seeds", "Exotic Seeds", "Grass Seeds", "Fruit Seeds"
            ],
            "Bulb": [
                "Flower Bulbs", "Seasonal Bulbs", "Perennial Bulbs",
                "Exotic Bulbs", "Indoor Bulbs", "Outdoor Bulbs", "Decorative Bulbs"
            ],
            "Soil & Fertilizer": [
                "Organic Fertilizer", "Potting Soil", "Coco Peat",
                "Vermicompost", "Nutrient Mixes", "Soil Amendments", "Specialty Fertilizers"
            ],
            "Pebble": [
                "Decorative Pebbles", "Natural Stones", "River Rocks",
                "Colored Pebbles", "Aquarium Pebbles", "Garden Path Pebbles", "Gravel"
            ],
            "Accessory": [
                "Plant Stands", "Garden Lighting", "Labels & Markers",
                "Sprayers & Misters", "Hanging Hooks", "Trellises & Supports", "Garden Storage"
            ]
        };

        function updateSubcategories() {
            let categorySelect = document.getElementById("category");
            let subcategorySelect = document.getElementById("subcategory");
            let selectedCategory = categorySelect.value;

            // Clear existing options
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

            // Populate new options if a category is selected
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

</body>

</html>