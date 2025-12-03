<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM sampah_digital ORDER BY tanggal_pengajuan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Laporan - Petugas Kebersihan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2em;
        }
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .container {
            width: 95%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9);
        }
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .modal-content img {
            width: 100%;
            height: auto;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Lihat Laporan Sampah</h1>
        <a href="dashboard_petugas.php" class="back-btn">Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <h3>Daftar Laporan Sampah</h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ID</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nama Pelapor</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ID Pelapor</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Unit Asal</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Jenis Sampah</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Deskripsi</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Jumlah</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Tanggal Pengajuan</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Lokasi Penyimpanan</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Foto Bukti</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['id']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['nama_pelapor']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['id_pelapor'] ?? ''); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['unit_asal']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['jenis_sampah']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['jumlah']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['tanggal_pengajuan']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['lokasi_penyimpanan']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;">
                                    <?php if (!empty($row['foto_bukti'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($row['foto_bukti']); ?>" alt="Foto Bukti" style="max-width: 100px; max-height: 100px; cursor: pointer;" onclick="openModal('uploads/<?php echo htmlspecialchars($row['foto_bukti']); ?>')">
                                    <?php else: ?>
                                        Tidak ada foto
                                    <?php endif; ?>
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['status'] ?? 'Pending'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" style="border: 1px solid #ddd; padding: 8px; text-align: center;">Tidak ada laporan ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <img id="modalImg" src="" alt="Foto Bukti">
        </div>
    </div>

    <script>
        function openModal(src) {
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("modalImg");
            modal.style.display = "block";
            modalImg.src = src;
        }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        // Close modal when clicking outside the image
        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
<?php
$conn->close();
?>
