<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$kategori = $_GET['kategori'] ?? 'Pribadi';

$data = mysqli_query($conn, "SELECT * FROM dokumen 
WHERE user_id='$user_id' AND kategori='$kategori' 
ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Arsip <?= $kategori ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
</head>

<body>


    <nav>
        <h2>E-ARSIP TEKNOLOGI INFORMASI 2024</h2>
        <div class="sidebar" id="sidebar" onclick="toggleSidebar()">
            <a href="dashboard.php">Dashboard</a>
            <a href="view.php?kategori=Pribadi">Arsip Pribadi</a>
            <a href="view.php?kategori=Akademik">Arsip Akademik</a>
            <a href="view.php?kategori=Tugas">Arsip Tugas</a>
            <a href="view.php?kategori=Sertifikat">Arsip Sertifikat</a>
            <a href="view.php?kategori=Administrasi">Arsip Administrasi</a>
            <a href="view.php?kategori=Tugas Akhir">Arsip Tugas Akhir</a>
            <a href="auth/logout.php">Logout</a>
        </div>
    </nav>

    <div class="content">

        <h2>Arsip <?= $kategori ?></h2>

        <div class="form-box">
            <h3>Form Tambah Arsip</h3>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="kategori" value="<?= $kategori ?>">


                <label>Tanggal</label>
                <input type="date" name="tanggal" required>

                <label>Upload File</label>
                <input type="file" name="file" required>

                <button name="upload">Simpan</button>
                <a href="dashboard.php" class="btn-back">Kembali</a>
            </form>
        </div>

        <div class="table-box">
            <h3>Data Arsip</h3>
            <table>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama File</th>
                    <th>lokasi file</th>
                    <th>Aksi</th>
                </tr>

                <?php
                $no = 1;
                while ($d = mysqli_fetch_assoc($data)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date("d-m-Y", strtotime($d['created_at'])) ?></td>
                        <td><?= $d['nama_file'] ?></td>
                        <td>
                            <a class="btn-delete" href="uploads/<?= $d['nama_file'] ?>" target="_blank">Lihat</a>
                            <a class="btn-download" href="download.php?id=<?= $d['id'] ?>">Download</a>
                        </td>
                        <td>
                            <a class="btn-edit">Edit</a>
                            <a class="btn-delete" href="delete.php?id=<?= $d['id'] ?>&kategori=<?= $kategori ?>">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>

    </div>
</body>

</html>