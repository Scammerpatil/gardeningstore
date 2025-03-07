<?php
include "../database.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

$seller_id = $_SESSION['user_id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    if (empty($name) || empty($category) || empty($subcategory) || empty($price) || empty($quantity) || empty($description) || empty($image['tmp_name'])) {
        echo "All fields are required!";
        exit;
    }

    $imageData = file_get_contents($image['tmp_name']);

    if ($imageData === false) {
        echo "Failed to read image file.";
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO products (name, category, subcategory, price, quantity, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssdisb", $name, $category, $subcategory, $price, $quantity, $description, $null);

    $stmt->send_long_data(6, $imageData);

    if ($stmt->execute()) {
        echo "Product added successfully!";
        echo "$category";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>