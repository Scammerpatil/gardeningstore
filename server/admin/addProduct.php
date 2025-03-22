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
    $shortdesc = $_POST['shortdesc'];
    $longdesc = $_POST['longdesc'];
    $size = $_POST['size'];
    $image = $_FILES['image'];

    if (empty($name) || empty($category) || empty($subcategory) || empty($price) || empty($quantity) || empty($longdesc) || empty($shortdesc) || empty($size) || empty($image['tmp_name'])) {
        echo "All fields are required!";
        exit;
    }

    $imageData = file_get_contents($image['tmp_name']);

    if ($imageData === false) {
        echo "Failed to read image file.";
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO products (name, category, subcategory, price, quantity, shortdesc,longdesc, size, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssdisssb", $name, $category, $subcategory, $price, $quantity, $shortdesc, $longdesc, $size, $null);

    $stmt->send_long_data(9, $imageData);

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