<?php
// Include database connection
include "../database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_type = trim($_POST['user_type']);

    // Validate inputs
    if (empty($email) || empty($password) || empty($user_type)) {
        die("All fields are required.");
    }

    if ($email === "admin@gardeningstore.com" && $password === "admin") {
        $_SESSION['user_id'] = 0;
        $_SESSION['name'] = "Admin";
        $_SESSION['user_type'] = "admin";
        header("Location: /gardeningstore/views/admin/");
        exit();
    }

    // Determine table based on user type
    $table = '';
    if ($user_type === 'customer') {
        $table = 'Customers';
    } elseif ($user_type === 'gardener') {
        $table = 'Gardeners';
    } elseif ($user_type === 'seller') {
        $table = 'Sellers';
    } else {
        die("Invalid user type.");
    }

    // Check if the user exists in the respective table
    $query = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables for the logged-in user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_type'] = $user_type;

            // Redirect based on user type
            if ($user_type === 'customer') {
                header("Location: /gardeningstore/views/customer/");
            } elseif ($user_type === 'gardener') {
                header("Location: /gardeningstore/views/gardener/");
            } elseif ($user_type === 'seller') {
                header("Location: /gardeningstore/views/seller/");
            }
            exit();
        } else {
            die("Invalid password.");
        }
    } else {
        die("No account found for this email and user type.");
    }
}

$conn->close();
?>