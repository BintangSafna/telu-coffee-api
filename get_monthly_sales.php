<?php
require_once "db_config.php";
header('Content-Type: application/json');

// Ambil data order dan item
$query = "
    SELECT 
        DATE_FORMAT(o.created_at, '%Y-%m') as month,
        SUM(o.total) as total_income,
        SUM(oi.quantity) as total_quantity
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    WHERE o.status = 4
    GROUP BY DATE_FORMAT(o.created_at, '%Y-%m')
    ORDER BY month DESC
";

$result = $conn->query($query);

$monthlySales = [];

while ($row = $result->fetch_assoc()) {
    $monthlySales[] = [
        "month" => $row["month"], // format: 2025-04
        "total_quantity" => (int)$row["total_quantity"],
        "total_income" => (int)$row["total_income"]
    ];
}

echo json_encode([
    "success" => true,
    "data" => $monthlySales
]);
