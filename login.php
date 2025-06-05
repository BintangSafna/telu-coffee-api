<?php
header("Content-Type: application/json");
require_once "db_config.php";

// Ambil data JSON dari body
$data = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Email dan password wajib diisi"
    ]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);

// Cek user berdasarkan email
$query = "SELECT id, name, email, password, phone, role FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email tidak ditemukan"
    ]);
    exit;
}

$user = $result->fetch_assoc();

// Verifikasi password
if (!password_verify($password, $user['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Password salah"
    ]);
    exit;
}

// Berhasil login
echo json_encode([
    "success" => true,
    "message" => "Login berhasil",
    "user" => [
        "id" => $user['id'],
        "name" => $user['name'],
        "email" => $user['email'],
        "phone" => $user['phone'],
        "role" => $user['role']
    ]
]);
