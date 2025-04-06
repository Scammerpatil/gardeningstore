<?php
session_start();
include "../../server/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["gardener_id"]) && isset($_POST["rating"])) {
    $gardener_id = intval($_POST["gardener_id"]);
    $rating = intval($_POST["rating"]);
    $user_id = $_SESSION['user_id']; // Assuming user is logged in

    if ($rating >= 1 && $rating <= 5) {
        // Check if the user already rated
        $checkQuery = "SELECT * FROM ratings WHERE gardener_id = ? AND user_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ii", $gardener_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update existing rating
            $updateQuery = "UPDATE ratings SET rating = ? WHERE gardener_id = ? AND user_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("iii", $rating, $gardener_id, $user_id);
        } else {
            // Insert new rating
            $insertQuery = "INSERT INTO ratings (gardener_id, user_id, rating) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("iii", $gardener_id, $user_id, $rating);
        }

        if ($stmt->execute()) {
            echo "Rating updated successfully!";
        } else {
            echo "Error updating rating.";
        }
    } else {
        echo "Invalid rating.";
    }
} else {
    echo "Invalid request.";
}
?>
