<?php
require_once "db_config.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['is_open'])) {
    echo json_encode(["success" => false, "message" => "Missing is_open"]);
    exit;
}

$isOpen = $data['is_open'] ? 1 : 0;

// Update existing row
$sql = "UPDATE cafe_status SET is_open = $isOpen LIMIT 1";
$result = $conn->query($sql);

if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $conn->error]);
}
