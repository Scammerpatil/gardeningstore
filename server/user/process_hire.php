<?php
include "../../server/database.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $gardener_id = $_POST['gardener_id'];
    $duration_days = $_POST['duration_days'];
    $hire_date_from = $_POST['hire_date_from'];
    $hire_date_to = $_POST['hire_date_to'];
    $task = $_POST['task'];
    $total_amount = $_POST['total_amount'];
    $total_amount = str_replace("₹", "", $total_amount);
    $task = is_array($task) ? implode(", ", $task) : $task;

    if (empty($customer_id) || empty($gardener_id) || empty($hire_date_from) || empty($hire_date_to) || empty($duration_days) || empty($task) || empty($total_amount)) {
        die("All fields are required.");
    }

    $stmt = $conn->prepare("
        SELECT hire_date_from, hire_date_to 
        FROM hire 
        WHERE gardener_id = ? 
        AND (
            (hire_date_from <= ? AND hire_date_to >= ?) OR
            (hire_date_from <= ? AND hire_date_to >= ?) OR
            (hire_date_from >= ? AND hire_date_to <= ?)
        )
    ");
    $stmt->bind_param("issssss", $gardener_id, $hire_date_from, $hire_date_from, $hire_date_to, $hire_date_to, $hire_date_from, $hire_date_to);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $latest_end_date = "";
        while ($row = $result->fetch_assoc()) {
            if ($row["hire_date_to"] > $latest_end_date) {
                $latest_end_date = $row["hire_date_to"];
            }
        }
        $next_available_date = date("Y-m-d", strtotime($latest_end_date . ' +1 day'));
        echo "<script>
                alert('Gardener is already booked during the selected period. The next available date is $next_available_date.');
                window.location.href='/gardeningstore/views/customer/hire_gardener.php?gardener_id=$gardener_id';
              </script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT services FROM gardeners WHERE gardener_id = ?");
    $stmt->bind_param("i", $gardener_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $gardener = $result->fetch_assoc();

    if (!$gardener) {
        die("Invalid gardener.");
    }

    $status = "Pending";
    $stmt = $conn->prepare("
        INSERT INTO hire (customer_id, gardener_id, hire_date_from, hire_date_to, duration_days, total_amount, task, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iissdsss", $customer_id, $gardener_id, $hire_date_from, $hire_date_to, $duration_days, $total_amount, $task, $status);

    if ($stmt->execute()) {
        echo "<script>
                alert('Gardener hired successfully!');
                window.location.href='/gardeningstore/views/customers/hire_form.php?gardener_id=$gardener_id';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
