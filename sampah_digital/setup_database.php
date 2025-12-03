<?php
include 'db_config.php';

// Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('petugas', 'mahasiswa') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_users) === TRUE) {
    echo "Tabel users berhasil dibuat.<br>";
} else {
    echo "Error membuat tabel users: " . $conn->error . "<br>";
}

// Create sampah_digital table
$sql_sampah = "CREATE TABLE IF NOT EXISTS sampah_digital (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_pelapor VARCHAR(100) NOT NULL,
    unit_asal VARCHAR(100) NOT NULL,
    jenis_sampah VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    jumlah INT(11) NOT NULL,
    tanggal_pengajuan DATE NOT NULL,
    lokasi_penyimpanan VARCHAR(255),
    status ENUM('Diajukan', 'Disetujui', 'Dibuang', 'Ditolak') DEFAULT 'Diajukan',
    user_id INT(11) NULL,
    foto_bukti VARCHAR(255) NULL
)";

if ($conn->query($sql_sampah) === TRUE) {
    echo "Tabel sampah_digital berhasil dibuat.<br>";
} else {
    echo "Error membuat tabel sampah_digital: " . $conn->error . "<br>";
}

// Create pengumuman table
$sql_pengumuman = "CREATE TABLE IF NOT EXISTS pengumuman (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    tanggal_pengumuman DATE NOT NULL,
    status ENUM('Aktif', 'Tidak Aktif') DEFAULT 'Aktif'
)";

if ($conn->query($sql_pengumuman) === TRUE) {
    echo "Tabel pengumuman berhasil dibuat.<br>";
} else {
    echo "Error membuat tabel pengumuman: " . $conn->error . "<br>";
}

// Insert sample users for testing
$sample_users = [
    ['username' => 'petugas1', 'password' => password_hash('123456', PASSWORD_DEFAULT), 'role' => 'petugas'],
    ['username' => 'mahasiswa1', 'password' => password_hash('123456', PASSWORD_DEFAULT), 'role' => 'mahasiswa']
];

foreach ($sample_users as $user) {
    $sql = "INSERT IGNORE INTO users (username, password, role) VALUES ('{$user['username']}', '{$user['password']}', '{$user['role']}')";
    if ($conn->query($sql) === TRUE) {
        echo "Sample user {$user['username']} berhasil ditambahkan.<br>";
    } else {
        echo "Error menambahkan sample user {$user['username']}: " . $conn->error . "<br>";
    }
}

// Insert sample pengumuman for testing
$sample_pengumuman = [
    ['judul' => 'Selamat Datang di Sistem Sampah Digital', 'isi' => 'Sistem ini membantu mahasiswa dalam melaporkan sampah digital kampus.', 'tanggal_pengumuman' => date('Y-m-d'), 'status' => 'Aktif'],
    ['judul' => 'Pengingat: Jaga Kebersihan Kampus', 'isi' => 'Mari bersama-sama menjaga kebersihan kampus dengan melaporkan sampah digital.', 'tanggal_pengumuman' => date('Y-m-d'), 'status' => 'Aktif']
];

foreach ($sample_pengumuman as $pengumuman) {
    $sql = "INSERT IGNORE INTO pengumuman (judul, isi, tanggal_pengumuman, status) VALUES ('{$pengumuman['judul']}', '{$pengumuman['isi']}', '{$pengumuman['tanggal_pengumuman']}', '{$pengumuman['status']}')";
    if ($conn->query($sql) === TRUE) {
        echo "Sample pengumuman '{$pengumuman['judul']}' berhasil ditambahkan.<br>";
    } else {
        echo "Error menambahkan sample pengumuman '{$pengumuman['judul']}': " . $conn->error . "<br>";
    }
}

echo "<br><strong>Setup database selesai!</strong><br>";
echo "Sample login:<br>";
echo "- Petugas: username='petugas1', password='123456'<br>";
echo "- Mahasiswa: username='mahasiswa1', password='123456'<br>";
echo "<br><a href='login.php'>Klik di sini untuk login</a>";

$conn->close();
?>
