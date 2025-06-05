<?php
header("Content-Type: application/json");
require_once "db_config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    if (!isset($data->order_id)) {
        echo json_encode(["success" => false, "message" => "Missing order_id"]);
        exit;
    }

    $orderId = $data->order_id;

    // Ambil status
    $stmt = $conn->prepare("SELECT status FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->bind_result($status);

    if ($stmt->fetch()) {
        $stmt->close();

        // Hitung jumlah order status 2 (diproses)
        $countQuery = "SELECT COUNT(*) FROM orders WHERE status = 2";
        $countResult = $conn->query($countQuery);
        $processingCount = $countResult->fetch_row()[0];

        // Hitung antrean user saat ini
        $queueQuery = "SELECT COUNT(*) FROM orders WHERE status = 2 AND id < ?";
        $queueStmt = $conn->prepare($queueQuery);
        $queueStmt->bind_param("i", $orderId);
        $queueStmt->execute();
        $queueStmt->bind_result($queuePosition);
        $queueStmt->fetch();
        $queueStmt->close();

        echo json_encode([
            "success" => true,
            "status" => (int)$status, // 0 = menunggu, 1 = disetujui, 2 = diproses, 3 = selesai, -1 = ditolak
            "orders_in_progress" => (int)$processingCount,
            "queue_position" => (int)$queuePosition
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Order not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
