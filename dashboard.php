<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
// Total seluruh dokumen
$total_semua_dokumen = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM dokumen WHERE user_id='$user_id'")
);

// Total seluruh download
$total_semua_download = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(download) as total FROM dokumen WHERE user_id='$user_id'")
);

$total_download_all = $total_semua_download['total'] ?? 0;

// total dokumen setiap arsip
$kategori_list = ['Pribadi', 'Akademik', 'Tugas', 'Sertifikat', 'Administrasi', 'Tugas Akhir'];
$jumlah_per_kategori = [];

foreach ($kategori_list as $k) {
    $res = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM dokumen WHERE user_id='$user_id' AND kategori='$k'");
    $row = mysqli_fetch_assoc($res);
    $jumlah_per_kategori[] = $row['jumlah'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/script.js" defer></script>
</head>

<body>
    <nav>
        <h2>E-ARSIP TEKNOLOGI INFORMASI 2024</h2>
        <div class="sidebar" id="sidebar" onclick="toggleSidebar()">
            <div class="sidebar1">
                <a href="dashboard.php">Dashboard</a>
                <?php foreach ($kategori_list as $k) { ?>
                    <a href="view.php?kategori=<?= $k ?>">Arsip <?= $k ?></a>
                <?php } ?>
                <a href="auth/logout.php">Logout</a>
            </div>
    </nav>


    <div class="content">
        <div class="deskripsi">
            <h1>Selamat datang DI Website E-ARSIP</h1>
            <h3>HAI, <?= $_SESSION['username'] ?></h3>
            <p>silahkan simpan file akademika kalian di menu arsip sesuai dengan dokumen.</p>
        </div>
        <div class="card-box">
            <div class="total-dokumen">
                <h4>Semua Dokumen</h4>
                <h2><?= $total_semua_dokumen ?></h2>
            </div>

            <div class="total-download">
                <h4>Total Download</h4>
                <h2><?= $total_download_all ?></h2>
            </div>
            <?php foreach ($kategori_list as $i => $k) { ?>
                <div class="stat-card">
                    <h4><?= $k ?></h4>
                    <h2><?= $jumlah_per_kategori[$i] ?></h2>
                    <Hr>
                    <h2>jumlah dokumen</h2>
                </div>
            <?php } ?>
        </div>

        <canvas id="chartKategori"></canvas>
        <?php
        $kategori_list = ['Pribadi', 'Akademik', 'Tugas', 'Sertifikat', 'Administrasi', 'Tugas Akhir'];
        $jumlah_per_kategori = [];

        foreach ($kategori_list as $k) {
            $res = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM dokumen WHERE user_id='$user_id' AND kategori='$k'");
            $row = mysqli_fetch_assoc($res);
            $jumlah_per_kategori[] = $row['jumlah'];
        }
        ?>

        <canvas id="chartKategoriDashboard" style="max-width:800px;margin-top:10px;"></canvas>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const ctx = document.getElementById('chartKategoriDashboard').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode($kategori_list) ?>,
                        datasets: [{
                            label: 'Jumlah Dokumen per Kategori',
                            data: <?= json_encode($jumlah_per_kategori) ?>,
                            backgroundColor: [
                                '#2563eb',
                                '#16a34a',
                                '#f59e0b',
                                '#ef4444',
                                '#8b5cf6',
                                '#06b6d4'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        }
                    }
                });

            });
        </script>

        <script>
            initKategoriChart(
                <?= json_encode($kategori_list) ?>,
                <?= json_encode($jumlah_per_kategori) ?>
            );
        </script>

    </div>
</body>

</html>