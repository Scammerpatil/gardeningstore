<?php
session_start();
include "../../server/database.php";
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $amount = $_POST['amt'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
    $stmt->execute();
    $order_result = $stmt->get_result();
    $order = $order_result->fetch_assoc();

    // fetch user
    $stmt = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();

    if ($order) {
        $keyId = 'rzp_test_cXJvckaWoN0JQx';
        $keySecret = 'NuVVc8bnNeu4YA2bZ7Eymf39';
        $api = new Api($keyId, $keySecret);

        $orderData = [
            'receipt' => $order_id,
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1,
        ];

        try {
            $response = $api->order->create($orderData);
            $razorpayOrderId = $response['id'];

            $_SESSION['razorpay_order_id'] = $razorpayOrderId;

            $data = [
                "key" => $keyId,
                "amount" => $amount * 100,
                "name" => $user['name'],
                "description" => "Payment for Order #{$order_id}",
                "image" => "https://png.pngtree.com/png-vector/20240310/ourmid/pngtree-fallen-green-leaf-element-png-image_11926275.png",
                "prefill" => [
                    "name" => $user['name'],
                    "email" => $user['email'],
                    "contact" => $user['phone_no'],
                ],
                "order_id" => $razorpayOrderId,
                "theme" => [
                    "color" => "#F37254",
                ],
            ];

            echo "<script src='https://checkout.razorpay.com/v1/checkout.js'></script>";
            echo "<script>
                    var options = " . json_encode($data) . ";
                    options.handler = function (response) {
                        // Send the payment details to the server
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'payment_success.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.send('razorpay_order_id=' + response.razorpay_order_id + '&razorpay_payment_id=' + response.razorpay_payment_id);
                    };
                    options.modal = {
                        ondismiss: function() {
                            window.location = 'orders.php';
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                </script>";
            exit;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    } else {
        echo "Order not found!";
        exit;
    }
} else {
    header("Location: orders.php");
    exit;
}
?>