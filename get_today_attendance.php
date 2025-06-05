<?php
require_once "db_config.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'])) {
    echo json_encode(["success" => false, "message" => "Missing name"]);
    exit;
}

$name = $data['name'];
$today = date('Y-m-d');

$sql = "SELECT status, TIME(timestamp) as time FROM attendance WHERE name = ? AND created_at = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $today);
$stmt->execute();

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "status" => $row['status'],
        "time" => $row['time']
    ]);
} else {
    echo json_encode(["success" => true, "status" => "Belum Presensi"]);
}
