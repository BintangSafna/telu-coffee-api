<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid JSON"]);
    exit;
}

require_once("db_config.php");

$name = $data["name"];
$location = $data["location"];
$method = $data["method"];
$payment_method = $data["payment_method"];
$cash = $data["cash"];
$total = $data["total"];
$items = $data["items"];

// Default status: 0 (menunggu konfirmasi)
$query = "INSERT INTO orders (name, location, method, payment_method, cash, total, status) VALUES (?, ?, ?, ?, ?, ?, 0)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssid", $name, $location, $method, $payment_method, $cash, $total);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    // Insert item satu per satu
    foreach ($items as $item) {
        $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, name, price, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmtItem->bind_param("issii", $order_id, $item["product_id"], $item["name"], $item["price"], $item["quantity"]);
        $stmtItem->execute();
        $stmtItem->close();
    }

    echo json_encode([
        "success" => true,
        "message" => "Pesanan berhasil disimpan",
        "order_id" => $order_id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal menyimpan pesanan"
    ]);
}
?>
