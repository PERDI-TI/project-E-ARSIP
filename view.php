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
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="assets/script.js" defer></script>
    <script src="assets/script.js" defer></script>
</head>

<body>


    <nav>
        <h2>E-ARSIP TEKNOLOGI INFORMASI 2024</h2>
        <div class="sidebar" id="sidebar" onclick="toggleSidebar()">
            <div class="sidebar1">
            <a href="dashboard.php">
                <i class="fa-solid fa-house"></i> Dashboard
        </a>
            <a href="view.php?kategori=Pribadi">
                <i class="fa-solid fa-file-lines"></i>  Arsip Pribadi
        </a>
            <a href="view.php?kategori=Akademik">
                <i class="fa-solid fa-file-lines"></i>  Arsip Akademik
            </a>
            <a href="view.php?kategori=Tugas">
                <i class="fa-solid fa-file-lines"></i>  Arsip Tugas
            </a>
            <a href="view.php?kategori=Sertifikat">
              <i class="fa-solid fa-file-lines"></i> Arsip Sertifikat 
        </a>
            <a href="view.php?kategori=Administrasi">
                <i class="fa-solid fa-file-lines"></i>  Arsip Administrasi
        </a>
            <a href="view.php?kategori=Tugas Akhir">
                <i class="fa-solid fa-file-lines"></i>  Arsip Tugas Akhir
        </a>
            <a href="auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
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
            <label>Pencarian Dokumen:</label>
            <input type="text" id="search" placeholder="Cari nama file atau tanggal..." onkeyup="cariFile()">
        </div>

        <div class="table-box">
            <h3>Data Arsip</h3>
            <table id="tableArsip">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama File</th>
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
                            <a class="btn-download" href="uploads/<?= $d['nama_file'] ?>" target="_blank"><i class="fa-solid fa-eye"></i></a>
                            <a class="btn-download" href="download.php?id=<?= $d['id'] ?>"><i class="fa-solid fa-download"></i></a>
                            <a class="btn-delete" href="delete.php?id=<?= $d['id'] ?>&kategori=<?= $kategori ?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>

    </div>
    <script>
        function cariFile() {

    let input = document.getElementById("search").value.toLowerCase();
    let table = document.getElementById("tableArsip");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {

        let tdTanggal = tr[i].getElementsByTagName("td")[1];
        let tdNama = tr[i].getElementsByTagName("td")[2];

        if (tdTanggal || tdNama) {

            let txtTanggal = tdTanggal.textContent.toLowerCase();
            let txtNama = tdNama.textContent.toLowerCase();

            if (txtTanggal.includes(input) || txtNama.includes(input)) {

                tr[i].style.display = "";

            } else {

                tr[i].style.display = "none";

            }

        }
    }
}
    </script>
</body>

</html>
