<?php
// create_admin.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_dinginbro";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Data admin awal
$username = "nigger";
$password_plain = "adminhitam"; // ganti dengan password pilihanmu

// Hash password
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// Simpan ke DB
$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password_hashed')";
if ($conn->query($sql) === TRUE) {
    echo "✅ Akun admin berhasil dibuat!<br>";
    echo "Username: $username<br>";
    echo "Password: $password_plain<br>";
    echo "<b>⚠️ Hapus file create_admin.php sekarang juga demi keamanan.</b>";
} else {
    echo "Error: " . $conn->error;
}
