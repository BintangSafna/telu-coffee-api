<?php
header("Content-Type: application/json");
require_once "db_config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    $orders = [];

    if (isset($data->name)) {
        // Mode: Pembeli (ambil berdasarkan nama)
        $query = "SELECT * FROM orders WHERE name = ? ORDER BY id DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $data->name);
    } else {
        // Mode: Kasir (ambil semua)
        $query = "SELECT * FROM orders ORDER BY id ASC";
        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $orderId = $row["id"];

        $itemsQuery = "SELECT * FROM order_items WHERE order_id = ?";
        $itemsStmt = $conn->prepare($itemsQuery);
        $itemsStmt->bind_param("i", $orderId);
        $itemsStmt->execute();
        $itemsResult = $itemsStmt->get_result();

        $items = [];
        while ($item = $itemsResult->fetch_assoc()) {
            $items[] = $item;
        }

        $orders[] = [
            "id" => $row["id"],
            "name" => $row["name"],
            "location" => $row["location"],
            "method" => $row["method"],
            "payment_method" => $row["payment_method"],
            "cash" => $row["cash"],
            "total" => $row["total"],
            "status" => $row["status"],
            "created_at" => $row["created_at"],
            "items" => $items
        ];
    }

    echo json_encode(["success" => true, "orders" => $orders]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
