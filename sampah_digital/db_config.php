<?php
// Konfigurasi Database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "sampah_digital";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>