<?php
include "../database.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

$seller_id = $_SESSION['user_id'] ?? null;

// 'Plant','Seed','Bulb','Soil & Fertilizer','Gardening Tool','Gift','Pebble','Accessory'

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

    $check_admin = $conn->prepare("SELECT seller_id FROM sellers WHERE email = ?");
    $admin_email = "admin@gardeningstore.com";
    $check_admin->bind_param("s", $admin_email);
    $check_admin->execute();
    $check_admin->store_result();

    if ($check_admin->num_rows == 0) {
        // Admin does not exist, so create one
        $add_admin = $conn->prepare("INSERT INTO sellers (name, contact_no, email, password_hash) VALUES (?, ?, ?, ?)");
        $admin_name = "Admin";
        $admin_contact_no = "9848707903";
        $admin_password = password_hash("admin", PASSWORD_DEFAULT);
        $add_admin->bind_param("ssss", $admin_name, $admin_contact_no, $admin_email, $admin_password);
        $add_admin->execute();
        $add_admin->close();
    }
    $check_admin->close();

    $imageData = file_get_contents($image['tmp_name']);

    if ($imageData === false) {
        echo "Failed to read image file.";
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO products (name, category, subcategory, price, quantity, description, image, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssdisbi", $name, $category, $subcategory, $price, $quantity, $description, $null, $seller_id);

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