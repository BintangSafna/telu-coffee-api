<?php
header("Content-Type: application/json");
require_once "db_config.php";

// Terima request
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->order_id)) {
    echo json_encode(["success" => false, "message" => "order_id dibutuhkan"]);
    exit;
}

$orderId = $data->order_id;

// Ambil data order
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Pesanan tidak ditemukan"]);
    exit;
}

$order = $result->fetch_assoc();

// Ambil item-item
$itemsQuery = "SELECT * FROM order_items WHERE order_id = ?";
$itemStmt = $conn->prepare($itemsQuery);
$itemStmt->bind_param("i", $orderId);
$itemStmt->execute();
$itemResult = $itemStmt->get_result();

$items = [];
while ($item = $itemResult->fetch_assoc()) {
    $items[] = $item;
}

echo json_encode([
    "success" => true,
    "order" => [
        "id" => $order['id'],
        "name" => $order['name'],
        "location" => $order['location'],
        "method" => $order['method'],
        "payment_method" => $order['payment_method'],
        "cash" => $order['cash'],
        "total" => $order['total'],
        "status" => $order['status'],
        "created_at" => $order['created_at'],
        "items" => $items
    ]
]);

$stmt->close();
$itemStmt->close();
$conn->close();
?>
