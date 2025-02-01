<!DOCTYPE html>
<html lang="en">
<?php
include './components/general/header.php';
?>
<body style="background-color: #DDF2D1;">
    <?php include './components/general/navbar.php'; ?>
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Category Sidebar -->
            <div class="col-md-3">
                <div class="list-group category-sidebar">
                    <h4 class="text-center category-title">Categories</h4>
                    <ul class="list-group">
                        <!-- Plant Category -->
                        <li class="list-group-item category-item" onclick="toggleSubcategories('plant')">
                            Plant
                            <ul class="list-group subcategory" id="plant">
                                <li class="list-group-item">Indoor Plants</li>
                                <li class="list-group-item">Outdoor Plants</li>
                                <li class="list-group-item">Flowers</li>
                                <li class="list-group-item">Succulents</li>
                                <li class="list-group-item">Bonsai</li>
                                <li class="list-group-item">Medicinal Plants</li>
                                <li class="list-group-item">Air Purifying Plants</li>
                            </ul>
                        </li>
                        <!-- Gardening Tool -->
                        <li class="list-group-item category-item" onclick="toggleSubcategories('gardening-tool')">
                            Gardening Tool
                            <ul class="list-group subcategory" id="gardening-tool">
                                <li class="list-group-item">Watering Can & Hoses</li>
                                <li class="list-group-item">Pest Control</li>
                                <li class="list-group-item">Garden Furniture</li>
                                <li class="list-group-item">Landscaping</li>
                                <li class="list-group-item">Garden Decor</li>
                                <li class="list-group-item">DIY Kits</li>
                            </ul>
                        </li>
                        <!-- Seeds -->
                        <li class="list-group-item category-item" onclick="toggleSubcategories('seeds')">
                            Seeds
                            <ul class="list-group subcategory" id="seeds">
                                <li class="list-group-item">Vegetable Seeds</li>
                                <li class="list-group-item">Herb Seeds</li>
                                <li class="list-group-item">Flower Seeds</li>
                                <li class="list-group-item">Organic Seeds</li>
                                <li class="list-group-item">Exotic Seeds</li>
                                <li class="list-group-item">Fruit Seeds</li>
                                <li class="list-group-item">Grass Seeds</li>
                            </ul>
                        </li>
                        <!-- Bulb -->
                        <li class="list-group-item category-item" onclick="toggleSubcategories('bulb')">
                            Bulb
                            <ul class="list-group subcategory" id="bulb">
                                <li class="list-group-item">Flower Bulbs</li>
                                <li class="list-group-item">Seasonal Bulbs</li>
                                <li class="list-group-item">Perennial Bulbs</li>
                                <li class="list-group-item">Exotic Bulbs</li>
                                <li class="list-group-item">Indoor Bulbs</li>
                                <li class="list-group-item">Outdoor Bulbs</li>
                                <li class="list-group-item">Decorative Bulbs</li>
                            </ul>
                        </li>
                        <!-- Soil & Fertilizer -->
                        <li class="list-group-item category-item" onclick="toggleSubcategories('soil-fertilizer')">
                            Soil & Fertilizer
                            <ul class="list-group subcategory" id="soil-fertilizer">
                                <li class="list-group-item">Organic Fertilizer</li>
                                <li class="list-group-item">Potting Soil</li>
                                <li class="list-group-item">Coco Peat</li>
                                <li class="list-group-item">Vermicompost</li>
                                <li class="list-group-item">Nutrient Mixes</li>
                                <li class="list-group-item">Soil Amendments</li>
                            </ul>
                        </li>
                        <!-- Pebbles -->
                        <li class="list-group-item category-item" onclick="toggleSubcategories('pebbles')">
                            Pebbles
                            <ul class="list-group subcategory" id="pebbles">
                                <li class="list-group-item">Decorative Pebbles</li>
                                <li class="list-group-item">Natural Stones</li>
                                <li class="list-group-item">River Rocks</li>
                                <li class="list-group-item">Colored Pebbles</li>
                                <li class="list-group-item">Aquarium Pebbles</li>
                                <li class="list-group-item">Garden Path Pebbles</li>
                                <li class="list-group-item">Gravel</li>
                            </ul>
                        </li>
                        <!-- Accessories -->
                        <li class="list-group-item category-item" onclick="toggleSubcategories('accessories')">
                            Accessories
                            <ul class="list-group subcategory" id="accessories">
                                <li class="list-group-item">Plant Stands</li>
                                <li class="list-group-item">Garden Lighting</li>
                                <li class="list-group-item">Labels & Markers</li>
                                <li class="list-group-item">Sprayers & Misters</li>
                                <li class="list-group-item">Hanging Hooks</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9">
                <section class="hero-area">
                    <div class="hero-post-slides owl-carousel"></div>
                </section>

                <section class="alazea-portfolio-area section-padding-100-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-heading text-center">
                                    <h2>GARDENING STORE</h2>
                                    <p>Explore our store</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include "./components/general/portfolio.php"; ?>
                </section>
            </div>
        </div>
    </div>

    <script>
        function toggleSubcategories(id) {
            let subcategory = document.getElementById(id);
            subcategory.style.display = subcategory.style.display === "none" ? "block" : "none";
        }

        document.addEventListener("DOMContentLoaded", function() {
            let subcategories = document.querySelectorAll(".subcategory");
            subcategories.forEach(sub => sub.style.display = "none");
        });
    </script>

    <style>
        /* Make category sidebar fixed and occupy the full left corner */
        .category-sidebar {
            background-color: black;
            color: white;
            padding: 15px;
            border-radius: 5px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 20%;
            overflow-y: auto;
        }

        .category-title {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .category-item {
            background-color: black;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        .category-item:hover {
            background-color: #343a40;
        }

        .subcategory {
            list-style-type: none;
            padding-left: 15px;
            display: none;
        }

        .subcategory .list-group-item {
            background-color: black;
            color: white;
            border-left: 3px solid #CDEBC5;
            margin-bottom: 2px;
        }

        .subcategory .list-group-item:hover {
            background-color: #343a40;
        }

        /* Adjust main content to avoid overlapping with fixed sidebar */
        .col-md-9 {
            margin-left: 22%;
        }
    </style>
</body>
</html>