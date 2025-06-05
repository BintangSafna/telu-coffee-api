<?php
require_once "db_config.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['product_id']) || !isset($data['is_available'])) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

$productId = $data['product_id'];
$isAvailable = $data['is_available'] ? 1 : 0;

$stmt = $conn->prepare("UPDATE products SET is_available = ? WHERE id = ?");
$stmt->bind_param("ii", $isAvailable, $productId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}
