include 'db_config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistem Sampah Digital Kampus</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 90%; margin: 20px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        .status-diajukan { background-color: #ffc107; }
        .status-disetujui { background-color: #28a745; color: white; }
        .status-dibuang { background-color: #007bff; color: white; }
        .status-ditolak { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pencatatan Sampah Digital Baru</h2>
        <form action="proses.php" method="POST">
            <div class="form-group">
                <label for="nama_pelapor">Nama Pelapor:</label>
                <input type="text" name="nama_pelapor" required>
            </div>
            <div class="form-group">
                <label for="unit_asal">Unit/Fakultas Asal:</label>
                <input type="text" name="unit_asal" required>
            </div>
            <div class="form-group">
                <label for="jenis_sampah">Jenis Sampah:</label>
                <select name="jenis_sampah" required>
                    <option value="Komputer/Laptop">Komputer/Laptop</option>
                    <option value="Monitor/Layar">Monitor/Layar</option>
                    <option value="Printer/Scanner">Printer/Scanner</option>
                    <option value="Media Penyimpanan">Media Penyimpanan</option>
                    <option value="Kabel/Aksesoris">Kabel/Aksesoris</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi Detail:</label>
                <textarea name="deskripsi" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah Item:</label>
                <input type="number" name="jumlah" min="1" requNaN                  <th>tanggal_pengajuan</th>
                    <th>lokasi_penyimpanan</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM sampah_digital ORDER BY tanggal_pengajuan DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nama_pelapor"] . " (" . $row["unit_asal"] . ")</td>";
                        echo "<td>" . $row["jenis_sampah"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["deskripsi"]) . "</td>";
                        echo "<td>" . $row["jumlah"] . "</td>";
                        echo "<td>" . $row["tanggal_pengajuan"] . "</td>";
                        echo "<td>" . $row["lokasi_penyimpanan"] . "</td>";
                        echo "<td class='status-" . strtolower(str_replace(' ', '', $row["status"])) . "'>" . $row["status"] . "</td>";
                        
                        echo "<td>";
                        echo "<form action='update_status.php' method='POST' style='display:inline;'>";
                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                        echo "<select name='status_baru' onchange='this.form.submit()'>";
                        echo "<option value='Diajukan' " . ($row["status"] == 'Diajukan' ? 'selected' : '') . ">Diajukan</option>";
                        echo "<option value='Disetujui' " . ($row["status"] == 'Disetujui' ? 'selected' : '') . ">Disetujui</option>";
                        echo "<option value='Dibuang' " . ($row["status"] == 'Dibuang' ? 'selected' : '') . ">Dibuang</option>";
                        echo "<option value='Ditolak' " . ($row["status"] == 'Ditolak' ? 'selected' : '') . ">Ditolak</option>";
                        echo "</select>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Belum ada sampah digital yang tercatat.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>
=======
<?php
// Redirect to login page as the main entry point
header("Location: login.php");
exit();
?>
