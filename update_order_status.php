<?php
header("Content-Type: application/json");
require_once "db_config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    if (!isset($data->order_id) || !isset($data->new_status)) {
        echo json_encode([
            "success" => false,
            "message" => "Parameter order_id dan new_status wajib diisi"
        ]);
        exit;
    }

    $orderId = (int) $data->order_id;
    $newStatus = (int) $data->new_status;

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStatus, $orderId);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Status berhasil diperbarui"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Gagal memperbarui status"
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
}
?>
