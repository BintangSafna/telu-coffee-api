<?php
require_once "db_config.php";

if (!isset($_GET['month'])) {
    die("Parameter 'month' dibutuhkan (format: yyyy-mm)");
}

$month = $_GET['month']; // Contoh: 2025-06

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"sales_$month.csv\"");

$output = fopen('php://output', 'w');

// Header kolom CSV
fputcsv($output, ['Order ID', 'Nama', 'Lokasi', 'Metode', 'Pembayaran', 'Produk', 'Qty', 'Harga', 'Total Order', 'Waktu']);

$query = "
    SELECT o.id, o.name, o.location, o.method, o.payment_method, o.total, o.created_at,
           oi.name AS product_name, oi.quantity, oi.price
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    WHERE o.status = 4 AND DATE_FORMAT(o.created_at, '%Y-%m') = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $month);
$stmt->execute();
$result = $stmt->get_result();

// Tulis data
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['location'],
        $row['method'],
        $row['payment_method'],
        $row['product_name'],
        $row['quantity'],
        $row['price'],
        $row['total'],
        $row['created_at']
    ]);
}

fclose($output);
exit;
