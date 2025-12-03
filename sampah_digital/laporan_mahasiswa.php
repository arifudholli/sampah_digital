<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelapor = $conn->real_escape_string($_POST['id_pelapor']);
    $nama_pelapor = $conn->real_escape_string($_SESSION['username']);
    $unit_asal = $conn->real_escape_string($_POST['unit_asal']);
    $jenis_sampah = $conn->real_escape_string($_POST['jenis_sampah']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $jumlah = (int)$_POST['jumlah'];
    $lokasi_penyimpanan = $conn->real_escape_string($_POST['lokasi_penyimpanan']);
    $tanggal_pengajuan = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    // Handle file upload
    $foto_bukti = '';
    if (isset($_FILES['foto_bukti']) && $_FILES['foto_bukti']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['foto_bukti']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($_FILES['foto_bukti']['tmp_name'], $target_file)) {
                $foto_bukti = $new_filename;
            } else {
                $message = "Error uploading file.";
            }
        } else {
            $message = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        $message = "Foto bukti wajib diupload!";
    }

    if (empty($message)) {
        $sql = "INSERT INTO sampah_digital (nama_pelapor, id_pelapor, unit_asal, jenis_sampah, deskripsi, jumlah, tanggal_pengajuan, lokasi_penyimpanan, foto_bukti, user_id)
                VALUES ('$nama_pelapor', '$id_pelapor', '$unit_asal', '$jenis_sampah', '$deskripsi', $jumlah, '$tanggal_pengajuan', '$lokasi_penyimpanan', '$foto_bukti', $user_id)";

        if ($conn->query($sql) === TRUE) {
            $message = "Laporan sampah berhasil diajukan!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - Sistem Sampah Digital Kampus</title>
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
            width: 90%;
            max-width: 600px;
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="text"]:focus, input[type="number"]:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .file-input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f8f9fa;
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Buat Laporan Sampah Digital</h1>
        <a href="dashboard_mahasiswa.php" class="back-btn">← Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <h2>Form Laporan Sampah Digital</h2>
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'berhasil') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id_pelapor">ID Pelapor <span class="required">*</span>:</label>
                <input type="text" id="id_pelapor" name="id_pelapor" required>
            </div>
            <div class="form-group">
                <label for="unit_asal">Unit/Fakultas Asal <span class="required">*</span>:</label>
                <input type="text" id="unit_asal" name="unit_asal" required>
            </div>
            <div class="form-group">
                <label for="jenis_sampah">Jenis Sampah <span class="required">*</span>:</label>
                <select id="jenis_sampah" name="jenis_sampah" required>
                    <option value="">Pilih Jenis Sampah</option>
                    <option value="Organik">Organik</option>
                    <option value="Non-Organik">Non-Organik</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi Detail:</label>
                <textarea id="deskripsi" name="deskripsi" placeholder="Jelaskan kondisi dan detail sampah digital..."></textarea>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah Item <span class="required">*</span>:</label>
                <input type="number" id="jumlah" name="jumlah" min="1" required>
            </div>
            <div class="form-group">
                <label for="lokasi_penyimpanan">Lokasi Penyimpanan Saat Ini:</label>
                <input type="text" id="lokasi_penyimpanan" name="lokasi_penyimpanan" placeholder="Contoh: Ruang Lab Komputer Lt. 2">
            </div>
            <div class="form-group">
                <label for="foto_bukti">Foto Bukti <span class="required">*</span> (JPG, PNG, GIF):</label>
                <input type="file" id="foto_bukti" name="foto_bukti" accept=".jpg,.jpeg,.png,.gif" required class="file-input">
            </div>
            <button type="submit" class="submit-btn">Ajukan Laporan</button>
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>
