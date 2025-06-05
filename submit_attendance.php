<?php
require_once "db_config.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (!isset($data['name'], $data['status'], $data['timestamp'])) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

$name = $data['name'];
$status = $data['status'];
$timestamp = $data['timestamp'];
$imageBase64 = $data['imageBase64'] ?? null;
$createdAt = date('Y-m-d', strtotime($timestamp));

// Cek apakah sudah presensi hari ini
$checkSql = "SELECT * FROM attendance WHERE name = ? AND created_at = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("ss", $name, $createdAt);
$stmt->execute();
$existing = $stmt->get_result();

if ($existing->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Sudah melakukan presensi hari ini"]);
    exit;
}

// Insert presensi
$insertSql = "INSERT INTO attendance (name, status, timestamp, image_base64, created_at) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertSql);
$stmt->bind_param("sssss", $name, $status, $timestamp, $imageBase64, $createdAt);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $conn->error]);
}
