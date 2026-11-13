<?php
// Matikan error reporting biar tampilan gak berantakan (opsional)
error_reporting(0);

// Koneksi ke Database
$host = "localhost";
$user = "root"; // Default XAMPP
$pass = "";     // Default XAMPP kosong
$db   = "db_pos_kasir";

$koneksi = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($koneksi->connect_error) {
    echo json_encode(["status" => "error", "pesan" => "Koneksi database gagal."]);
    exit;
}

// Ambil data dari JavaScript
$data = json_decode(file_get_contents("php://input"), true);
$action = isset($_GET['action']) ? $_GET['action'] : '';

// ====== LOGIKA LOGIN ======
if ($action === 'login') {
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    // Cari user di database
    $stmt = $koneksi->prepare("SELECT nama_lengkap FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            "status" => "success", 
            "nama" => $row['nama_lengkap']
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "pesan" => "Username atau Password salah, bro!"
        ]);
    }
    $stmt->close();
}

$koneksi->close();
?>