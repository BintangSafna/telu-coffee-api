<?php
$host = "telu-coffee.rf.gd";       
$user = "if0_39076337";        
$password = "dJwvnjdXExk";     
$db = "if0_39076337_telucoffee"; 

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}
?>
