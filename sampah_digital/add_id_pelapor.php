<?php
include 'db_config.php';

// Alter sampah_digital table to add id_pelapor column if it doesn't exist
$sql = "ALTER TABLE sampah_digital ADD COLUMN id_pelapor VARCHAR(50) NULL AFTER nama_pelapor";

if ($conn->query($sql) === TRUE) {
    echo "Kolom id_pelapor berhasil ditambahkan ke tabel sampah_digital.<br>";
} else {
    echo "Error menambah id_pelapor: " . $conn->error . "<br>";
}

$conn->close();
?>
