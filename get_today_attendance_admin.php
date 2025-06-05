<?php
require_once "db_config.php";
header('Content-Type: application/json');

$today = date('Y-m-d');

// Ambil semua kasir
$sqlUsers = "SELECT name FROM users WHERE role = 'kasir'";
$resultUsers = $conn->query($sqlUsers);

$attendanceList = [];

while ($user = $resultUsers->fetch_assoc()) {
    $name = $user['name'];

    $stmt = $conn->prepare("SELECT status, TIME(timestamp) as time FROM attendance WHERE name = ? AND created_at = ?");
    $stmt->bind_param("ss", $name, $today);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $attendanceList[] = [
            "name" => $name,
            "status" => $row['status'],
            "time" => $row['time']
        ];
    } else {
        $attendanceList[] = [
            "name" => $name,
            "status" => "Belum Presensi",
            "time" => "-"
        ];
    }
}

echo json_encode([
    "success" => true,
    "attendance" => $attendanceList
]);
