<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'petugas') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['judul']) && isset($_POST['isi'])) {
    $judul = $conn->real_escape_string($_POST['judul']);
    $isi = $conn->real_escape_string($_POST['isi']);
    $tanggal_pengumuman = date('Y-m-d');
    $status = 'Aktif';

    $sql = "INSERT INTO pengumuman (judul, isi, tanggal_pengumuman, status) VALUES ('$judul', '$isi', '$tanggal_pengumuman', '$status')";

    if ($conn->query($sql) === TRUE) {
        $message = "Pengumuman berhasil ditambahkan.";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengumuman - Petugas Kebersihan</title>
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
            transition: all 0.3s ease;
            animation: fadeInLeft 0.6s ease-out 0.4s both;
        }
        @keyframes fadeInLeft {
            from { transform: translateX(-30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-5px);
        }
        .container {
            width: 95%;
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }
        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .form-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
            animation: zoomIn 0.6s ease-out 0.8s both;
        }
        @keyframes zoomIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            font-size: 1.8em;
            animation: fadeIn 0.6s ease-out 1s both;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            animation: fadeInUp 0.6s ease-out 1.2s both;
        }
        .form-group:nth-child(2) {
            animation-delay: 1.4s;
        }
        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 1.1em;
        }
        input[type="text"], textarea {
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        textarea {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }
        button:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        button:hover:before {
            left: 100%;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        .message {
            text-align: center;
            margin-bottom: 25px;
            padding: 15px;
            border-radius: 8px;
            font-weight: 500;
            animation: slideInDown 0.5s ease-out;
        }
        @keyframes slideInDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kelola Pengumuman</h1>
        <a href="dashboard_petugas.php" class="back-btn">Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <h2>Tambah Pengumuman Baru</h2>
        <?php if (isset($message)): ?>
            <div class="message <?php echo strpos($message, 'berhasil') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <div class="form-card">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="judul">Judul Pengumuman:</label>
                    <input type="text" id="judul" name="judul" placeholder="Masukkan judul pengumuman" required>
                </div>
                <div class="form-group">
                    <label for="isi">Isi Pengumuman:</label>
                    <textarea id="isi" name="isi" placeholder="Masukkan isi pengumuman" required></textarea>
                </div>
                <button type="submit">📢 Tambah Pengumuman</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
