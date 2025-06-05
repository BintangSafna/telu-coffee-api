<?php
require_once('db_config.php');

$API_KEY = "123456789abcdef";

if (!isset($_GET['api_key']) || $_GET['api_key'] !== $API_KEY) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$products = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);
?>
