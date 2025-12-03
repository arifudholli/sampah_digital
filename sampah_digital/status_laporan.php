<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Laporan - Sistem Sampah Digital Kampus</title>
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
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .status {
            padding: 6px 12px;
            border-radius: 4px;
            color: black;
            font-weight: 500;
            text-align: center;
        }
        .status-Diajukan { background-color: #ffc107; }
        .status-Disetujui { background-color: #28a745; }
        .status-Dibuang { background-color: #007bff; }
        .status-Ditolak { background-color: #dc3545; }
        .no-reports {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        .photo-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #ddd;
        }
        .photo-thumbnail:hover {
            opacity: 0.8;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Status Laporan Saya</h1>
        <a href="dashboard_mahasiswa.php" class="back-btn">← Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <h2>Daftar Laporan yang Telah Diajukan</h2>

        <table>
            <thead>
                <tr>
                    <th>ID Pelapor</th>
                    <th>Nama Pelapor</th>
                    <th>Jenis Sampah</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Lokasi Penyimpanan</th>
                    <th>Foto Bukti</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM sampah_digital ORDER BY tanggal_pengajuan DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id_pelapor"] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row["nama_pelapor"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["jenis_sampah"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["deskripsi"]) . "</td>";
                        echo "<td>" . $row["jumlah"] . "</td>";
                        echo "<td>" . $row["tanggal_pengajuan"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["lokasi_penyimpanan"]) . "</td>";

                        // Foto Bukti column
                        if (!empty($row["foto_bukti"]) && file_exists("uploads/" . $row["foto_bukti"])) {
                            echo "<td><img src='uploads/" . $row["foto_bukti"] . "' alt='Foto Bukti' class='photo-thumbnail' onclick='openModal(\"uploads/" . $row["foto_bukti"] . "\")'></td>";
                        } else {
                            echo "<td>Tidak ada foto</td>";
                        }

                        // Status column
                        $status_class = 'status-' . str_replace(' ', '', $row["status"]);
                        echo "<td><span class='status " . $status_class . "'>" . $row["status"] . "</span></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='no-reports'>Belum ada laporan yang diajukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for photo display -->
    <div id="photoModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('photoModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('photoModal').style.display = 'none';
        }

        // Close modal when clicking outside the image
        document.getElementById('photoModal').onclick = function(event) {
            if (event.target === this) {
                closeModal();
            }
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>
