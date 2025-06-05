<?php
require_once "db_config.php";

if (!isset($_GET['month'])) {
    die("Missing month");
}

$month = $_GET['month']; // Format: YYYY-MM
$filename = "presensi_$month.csv";

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"$filename\"");

$output = fopen('php://output', 'w');

// Header
fputcsv($output, ['Nama', 'Tanggal', 'Jam', 'Status', 'Foto']);

// Data
$sql = "SELECT name, DATE(timestamp) as date, TIME(timestamp) as time, status, image_path 
        FROM attendance 
        WHERE DATE_FORMAT(created_at, '%Y-%m') = ? 
        ORDER BY name, date";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $month);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['name'],
        $row['date'],
        $row['time'],
        $row['status'],
        $row['image_path'] ?? ''
    ]);
}

fclose($output);
exit;
