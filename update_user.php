<?php
header("Content-Type: application/json");
require_once "db_config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["user_id"])) {
    echo json_encode(["success" => false, "message" => "User ID wajib diisi"]);
    exit;
}

$userId = $data["user_id"];
$name = $data["name"] ?? null;
$phone = $data["phone"] ?? null;

$updates = [];
$params = [];
$types = "";

// Update name
if ($name !== null) {
    $updates[] = "name = ?";
    $params[] = $name;
    $types .= "s";
}

// Update phone
if ($phone !== null) {
    $updates[] = "phone = ?";
    $params[] = $phone;
    $types .= "s";
}

if (empty($updates)) {
    echo json_encode(["success" => false, "message" => "Tidak ada data untuk diupdate"]);
    exit;
}

$params[] = $userId;
$types .= "i";

$query = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$success = $stmt->execute();

if ($success) {
    echo json_encode(["success" => true, "message" => "Data berhasil diperbarui"]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal update data"]);
}
