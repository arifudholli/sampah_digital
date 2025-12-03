<?php
include 'db_config.php';

// Alter sampah_digital table to add user_id column
$sql1 = "ALTER TABLE sampah_digital ADD COLUMN user_id INT NULL AFTER id";

if ($conn->query($sql1) === TRUE) {
    echo "Kolom user_id berhasil ditambahkan ke tabel sampah_digital.<br>";
} else {
    echo "Error menambah user_id: " . $conn->error . "<br>";
}

// Alter sampah_digital table to add foto_bukti column
$sql2 = "ALTER TABLE sampah_digital ADD COLUMN foto_bukti VARCHAR(255) NULL AFTER lokasi_penyimpanan";

if ($conn->query($sql2) === TRUE) {
    echo "Kolom foto_bukti berhasil ditambahkan ke tabel sampah_digital.<br>";
} else {
    echo "Error menambah foto_bukti: " . $conn->error . "<br>";
}

// Alter sampah_digital table to add id_pelapor column
$sql3 = "ALTER TABLE sampah_digital ADD COLUMN id_pelapor VARCHAR(50) NULL AFTER nama_pelapor";

if ($conn->query($sql3) === TRUE) {
    echo "Kolom id_pelapor berhasil ditambahkan ke tabel sampah_digital.<br>";
} else {
    echo "Error menambah id_pelapor: " . $conn->error . "<br>";
}

$conn->close();
?>
