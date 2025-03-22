<?php
include "../database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        die("All fields are required.");
    }

    if ($email === "admin@gardeningstore.com" && $password === "admin") {
        $_SESSION['user_id'] = 0;
        $_SESSION['name'] = "Admin";
        $_SESSION['user_type'] = "admin";
        header("Location: /gardeningstore/views/admin/");
        exit();
    }

    $userTables = [
        'Customers' => 'customer_id',
        'Gardeners' => 'gardener_id'
    ];

    $userFound = false;

    foreach ($userTables as $table => $idColumn) {
        $query = "SELECT * FROM $table WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user[$idColumn];
                $_SESSION['name'] = $user['name'];
                $_SESSION['user_type'] = strtolower($table);
                header("Location: /gardeningstore/views/" . strtolower($table) . "/");
                $userFound = true;
                exit();
            } else {
                die("Invalid password.");
            }
        }
    }

    if (!$userFound) {
        die("No account found for this email.");
    }
}

$conn->close();
?>