<?php
header("Content-Type: application/json");
require_once "db_config.php";

// Ambil input dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Validasi field wajib
if (
    !isset($data['name']) || 
    !isset($data['email']) || 
    !isset($data['password']) || 
    !isset($data['phone'])
) {
    echo json_encode([
        "success" => false,
        "message" => "Semua field wajib diisi"
    ]);
    exit;
}

$name     = trim($data['name']);
$email    = trim($data['email']);
$password = trim($data['password']);
$phone    = trim($data['phone']);
$role     = 'pembeli'; // Default role

// Cek apakah email sudah digunakan
$checkQuery = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email sudah terdaftar"
    ]);
    exit;
}
$stmt->close();

// Hash password untuk keamanan
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Simpan data ke tabel users
$insertQuery = "INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertQuery);
$stmt->bind_param("sssss", $name, $email, $hashedPassword, $phone, $role);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Registrasi berhasil"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal menyimpan data"
    ]);
}

$stmt->close();
$conn->close();
?>