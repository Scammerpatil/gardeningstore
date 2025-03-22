<?php
session_start();
include "../../server/database.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='product.php';</script>";
    } else {
        echo "<script>alert('Error deleting product.'); window.location.href='product.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid product ID.'); window.location.href='product.php';</script>";
}

$conn->close();
?>