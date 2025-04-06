<?php
include "../../server/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gardener_id = $_POST['gardener_id'];
    $customer_id = $_POST['customer_id'];
    $rating = (int) $_POST['rating'];
    $review = trim($_POST['review']);

    if ($rating < 1 || $rating > 5) {
        die("Invalid rating.");
    }

    $stmt = $conn->prepare("INSERT INTO gardener_ratings (gardener_id, customer_id, rating, review) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $gardener_id, $customer_id, $rating, $review);

    if ($stmt->execute()) {
        header("Location: ../../views/customers/hire_gardener_status.php");
    } else {
        echo "Failed to submit rating.";
    }
}
?>