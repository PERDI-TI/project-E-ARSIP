<?php
session_start();
include "config/koneksi.php";

if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ambil data dokumen
$data = mysqli_query($conn,"SELECT * FROM dokumen WHERE id='$id' AND user_id='$user_id'");
$d = mysqli_fetch_assoc($data);

if($d){

    $file_path = "uploads/" . $d['nama_file'];

    if(file_exists($file_path)){

        // Tambah jumlah download +1
        mysqli_query($conn,"UPDATE dokumen SET download = download + 1 WHERE id='$id'");

        // Force download file
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . basename($file_path) . "\"");
        header("Content-Length: " . filesize($file_path));
        readfile($file_path);
        exit;

    } else {
        echo "File tidak ditemukan.";
    }

} else {
    echo "Akses ditolak.";
}
?>