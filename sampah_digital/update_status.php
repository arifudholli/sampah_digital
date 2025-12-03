<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT id, nama_pelapor, jenis_sampah, status FROM sampah_digital ORDER BY tanggal_pengajuan DESC");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['status_baru'])) {
    $id = (int)$_POST['id'];
    $status_baru = $conn->real_escape_string($_POST['status_baru']);

    $sql = "UPDATE sampah_digital SET status = '$status_baru' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard_petugas.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Laporan - Petugas Kebersihan</title>
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
            max-width: 800px;
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
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        label {
            font-weight: 600;
            color: #333;
        }
        select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: transform 0.3s;
        }
        button:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Update Status Laporan</h1>
        <a href="dashboard_petugas.php" class="back-btn">Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <h2>Pilih Laporan dan Update Status</h2>
        <form method="POST" action="">
            <div>
                <label for="id">Pilih Laporan:</label>
                <select id="id" name="id" required>
                    <option value="">Pilih Laporan</option>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>">
                                ID: <?php echo $row['id']; ?> - <?php echo htmlspecialchars($row['nama_pelapor']); ?> - <?php echo htmlspecialchars($row['jenis_sampah']); ?> (<?php echo htmlspecialchars($row['status']); ?>)
                            </option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">Tidak ada laporan ditemukan</option>
                    <?php endif; ?>
                </select>
            </div>
            <div>
                <label for="status_baru">Status Baru:</label>
                <select id="status_baru" name="status_baru" required>
                    <option value="">Pilih Status Baru</option>
                    <option value="Diajukan">Diajukan</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Dibuang">Dibuang</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
            <button type="submit">Update Status</button>
        </form>
    </div>
</body>
</html>
<?php

$conn->close();
?>
