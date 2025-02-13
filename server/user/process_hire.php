<?php
include "../../server/database.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $gardener_id = $_POST['gardener_id'];
    $duration_days = $_POST['duration_days'];

    // Fetch gardener charges
    $stmt = $conn->prepare("SELECT charges FROM gardeners WHERE gardener_id = ?");
    $stmt->bind_param("i", $gardener_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $gardener = $result->fetch_assoc();

    if (!$gardener) {
        die("Invalid gardener.");
    }

    $total_amount = $gardener['charges'] * $duration_days;
    $hire_date = date("Y-m-d");

    // Insert into hiring table
    $stmt = $conn->prepare("INSERT INTO hire (customer_id, gardener_id, hire_date, duration_days, total_amount, status) 
                            VALUES (?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("iisid", $customer_id, $gardener_id, $hire_date, $duration_days, $total_amount);

    if ($stmt->execute()) {
        echo "<script>alert('Gardener hired successfully!'); window.location.href='/gardeningstore/views/customer/index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>