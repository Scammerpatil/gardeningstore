<?php
// Include database connection
include "../database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $user_type = trim($_POST['user_type']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($user_type)) {
        die("All required fields must be filled out!");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $check_query = "SELECT * FROM Customers WHERE email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Email already exists. Please try another.");
    }

    // Insert data based on user type
    if ($user_type === 'customer') {
        $insert_query = "INSERT INTO Customers (name, email, phone_no, address, password_hash) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssss", $name, $email, $phone, $address, $hashed_password);
    } elseif ($user_type === 'gardener') {
        $insert_query = "INSERT INTO Gardeners (name, email, phone_no, charges, password_hash) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssss", $name, $email, $phone, $charges, $hashed_password);
    } elseif ($user_type === 'seller') {
        $insert_query = "INSERT INTO Sellers (name, contact_no, email, password_hash) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssss", $name, $phone, $email, $hashed_password);
    } else {
        die("Invalid user type.");
    }

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: /gardeningstore/login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>