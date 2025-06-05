<?php
require_once "db_config.php";
header('Content-Type: application/json');

$result = $conn->query("SELECT is_open FROM cafe_status LIMIT 1");

if ($row = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "is_open" => (bool)$row["is_open"]]);
} else {
    echo json_encode(["success" => false, "message" => "Status not found"]);
}
