<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama_pelapor = $conn->real_escape_string($_POST['nama_pelapor']);
    $unit_asal = $conn->real_escape_string($_POST['unit_asal']);
    $jenis_sampah = $conn->real_escape_string($_POST['jenis_sampah']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $jumlah = (int)$_POST['jumlah'];
    $lokasi_penyimpanan = $conn->real_escape_string($_POST['lokasi_penyimpanan']);
    $tanggal_pengajuan = date('Y-m-d'); 

    $sql = "INSERT INTO sampah_digital (nama_pelapor, unit_asal, jenis_sampah, deskripsi, jumlah, tanggal_pengajuan, lokasi_penyimpanan)
            VALUES ('$nama_pelapor', '$unit_asal', '$jenis_sampah', '$deskripsi', $jumlah, '$tanggal_pengajuan', '$lokasi_penyimpanan')";

    if ($conn->query($sql) === TRUE) {
        echo "Pencatatan sampah berhasil! Kembali ke <a href='index.php'>halaman utama</a>.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?><?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama_pelapor = $conn->real_escape_string($_POST['nama_pelapor']);
    $unit_asal = $conn->real_escape_string($_POST['unit_asal']);
    $jenis_sampah = $conn->real_escape_string($_POST['jenis_sampah']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $jumlah = (int)$_POST['jumlah'];
    $lokasi_penyimpanan = $conn->real_escape_string($_POST['lokasi_penyimpanan']);
    $tanggal_pengajuan = date('Y-m-d'); 

    $sql = "INSERT INTO sampah_digital (nama_pelapor, unit_asal, jenis_sampah, deskripsi, jumlah, tanggal_pengajuan, lokasi_penyimpanan)
            VALUES ('$nama_pelapor', '$unit_asal', '$jenis_sampah', '$deskripsi', $jumlah, '$tanggal_pengajuan', '$lokasi_penyimpanan')";

    if ($conn->query($sql) === TRUE) {
        echo "Pencatatan sampah berhasil! Kembali ke <a href='index.php'>halaman utama</a>.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>