<?php
include "../../server/database.php";
session_start();

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION["name"])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$customer_id = $_SESSION["user_id"];
$total_amount = 0;

if (empty($data["cart"])) {
    echo json_encode(["error" => "Cart is empty"]);
    exit();
}

$customizing = isset($data["customizing"]) ? trim($data["customizing"]) : "";

$conn->begin_transaction();

try {
    foreach ($data["cart"] as $item) {
        $total_amount += $item["price"] * $item["quantity"];
    }

    $insert_order = $conn->prepare("INSERT INTO orders (customer_id, order_date, customizing, total_amount,delivery_status, status) VALUES (?, NOW(), ?, ?,'Pending','Pending')");
    $insert_order->bind_param("isd", $customer_id, $customizing, $total_amount);
    $insert_order->execute();
    $order_id = $insert_order->insert_id;

    $insert_order_details = $conn->prepare("INSERT INTO orderdetails (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($data["cart"] as $item) {
        $product_id = $item["id"];
        $quantity = $item["quantity"];
        $price = $item["price"];

        $insert_order_details->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $insert_order_details->execute();

        // Update Product Stock
        $update_stock = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE product_id = ?");
        $update_stock->bind_param("ii", $quantity, $product_id);
        $update_stock->execute();
    }
    $conn->commit();
    echo json_encode(["success" => "Order placed successfully!", "order_id" => $order_id]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Failed to place order: " . $e->getMessage()]);
}

$conn->close();

?>