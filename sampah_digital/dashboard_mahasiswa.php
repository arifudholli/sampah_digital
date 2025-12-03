<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Sistem Sampah Digital Kampus</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            animation: slideDown 0.6s ease-out;
        }
        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .header h1 {
            margin: 0;
            font-size: 2em;
            animation: bounceIn 0.8s ease-out 0.2s both;
        }
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            animation: fadeInRight 0.6s ease-out 0.4s both;
        }
        @keyframes fadeInRight {
            from { transform: translateX(30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(5px);
        }
        .container {
            width: 95%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }
        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            animation: fadeIn 0.6s ease-out 0.8s both;
        }
        .menu-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            flex: 1;
            max-width: 200px;
            position: relative;
            overflow: hidden;
            animation: zoomIn 0.6s ease-out 1s both;
        }
        .menu-item:nth-child(2) {
            animation-delay: 1.2s;
        }
        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .menu-item:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .menu-item:hover:before {
            left: 100%;
        }
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .menu-item h3 {
            margin: 0 0 10px 0;
            font-size: 1.2em;
        }
        .menu-item p {
            margin: 0;
            font-size: 0.9em;
            opacity: 0.9;
        }
        .welcome {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeIn 0.6s ease-out 1.4s both;
        }
        .welcome h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .welcome p {
            color: #666;
            font-size: 1.1em;
        }
        h3 {
            animation: fadeInLeft 0.6s ease-out 1.6s both;
        }
        @keyframes fadeInLeft {
            from { transform: translateX(-30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        table {
            animation: fadeInUp 0.6s ease-out 1.8s both;
        }
        tbody tr {
            animation: fadeInUp 0.4s ease-out both;
        }
        tbody tr:nth-child(1) { animation-delay: 2s; }
        tbody tr:nth-child(2) { animation-delay: 2.2s; }
        tbody tr:nth-child(3) { animation-delay: 2.4s; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard Mahasiswa</h1>
        <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Sistem Laporan Sampah Digital Kampus</h2>
            <p>Kelola laporan sampah elektronik Anda dengan mudah</p>
        </div>

        <div class="menu">
            <a href="laporan_mahasiswa.php" class="menu-item">
                <h3>📝 Buat Laporan</h3>
                <p>Laporkan sampah digital yang perlu didaur ulang</p>
            </a>
            <a href="status_laporan.php" class="menu-item">
                <h3>📊 Cek Status</h3>
                <p>Lihat status laporan Anda yang sudah diajukan</p>
            </a>
        </div>

        <h3>Pengumuman Terbaru</h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Judul</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Isi Pengumuman</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT judul, isi, tanggal_pengumuman FROM pengumuman WHERE status = 'Aktif' ORDER BY tanggal_pengumuman DESC LIMIT 5");
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                    ?>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['judul']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['isi']); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($row['tanggal_pengumuman']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="border: 1px solid #ddd; padding: 8px; text-align: center;">Tidak ada pengumuman ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
