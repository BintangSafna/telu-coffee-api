<?php
header("Content-Type: application/json");
require_once "db_config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['order_id']) || !isset($data['status'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing order_id or status"
    ]);
    exit;
}

$orderId = $data['order_id'];
$status = $data['status'];

$query = "UPDATE orders SET status = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $status, $orderId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Order updated"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update order"]);
}
?>
