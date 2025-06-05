<?php
require_once "db_config.php";
header('Content-Type: application/json');

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = [
        "id" => $row["id"],
        "name" => $row["name"],
        "price" => (int)$row["price"],
        "imageUrl" => $row["image_url"],
        "category" => $row["category"],
        "description" => $row["description"],
        "isAvailable" => (bool)$row["is_available"]
    ];
}

echo json_encode(["success" => true, "products" => $products]);
