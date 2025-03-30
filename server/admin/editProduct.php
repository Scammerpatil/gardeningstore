<?php
include "../database.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

$seller_id = $_SESSION['user_id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'] ?? null;
    $name = $_POST['name'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $shortdesc = $_POST['shortdesc'];
    $longdesc = $_POST['longdesc'];
    $size = $_POST['size'];
    $image = $_FILES['image'];

    if (empty($product_id) || empty($name) || empty($category) || empty($subcategory) || empty($price) || empty($quantity) || empty($longdesc) || empty($shortdesc) || empty($size)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    if (!empty($image['tmp_name'])) {
        $imageData = file_get_contents($image['tmp_name']);
        if ($imageData === false) {
            echo "<script>alert('Failed to read image file.'); window.history.back();</script>";
            exit;
        }

        $stmt = $conn->prepare("UPDATE products SET name=?, category=?, subcategory=?, price=?, quantity=?, shortdesc=?, longdesc=?, size=?, image=? WHERE product_id=?");
        $stmt->bind_param("sssdisssbi", $name, $category, $subcategory, $price, $quantity, $shortdesc, $longdesc, $size, $null, $product_id);
        $stmt->send_long_data(8, $imageData);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, category=?, subcategory=?, price=?, quantity=?, shortdesc=?, longdesc=?, size=? WHERE product_id=?");
        $stmt->bind_param("sssdisssi", $name, $category, $subcategory, $price, $quantity, $shortdesc, $longdesc, $size, $product_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!');  window.history.back();</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>