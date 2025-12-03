<?php
include 'db_config.php';

// Test inserting a pengumuman
$judul = "Test Pengumuman";
$isi = "Ini adalah pengumuman test untuk memverifikasi sistem.";
$tanggal_pengumuman = date('Y-m-d');
$status = 'Aktif';

$sql = "INSERT INTO pengumuman (judul, isi, tanggal_pengumuman, status) VALUES ('$judul', '$isi', '$tanggal_pengumuman', '$status')";

if ($conn->query($sql) === TRUE) {
    echo "Test pengumuman berhasil ditambahkan.<br>";
} else {
    echo "Error: " . $conn->error . "<br>";
}

// Test retrieving pengumuman
$result = $conn->query("SELECT judul, isi, tanggal_pengumuman FROM pengumuman WHERE status = 'Aktif' ORDER BY tanggal_pengumuman DESC LIMIT 5");

if ($result->num_rows > 0) {
    echo "<br>Pengumuman terbaru:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "- " . htmlspecialchars($row['judul']) . " (" . htmlspecialchars($row['tanggal_pengumuman']) . ")<br>";
    }
} else {
    echo "Tidak ada pengumuman ditemukan.<br>";
}

$conn->close();
?>
