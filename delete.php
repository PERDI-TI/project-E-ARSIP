<?php
include "config/koneksi.php";

$id = $_GET['id'];
$kategori = $_GET['kategori'] ?? 'Pribadi';

// Hapus file
$file = mysqli_fetch_assoc(mysqli_query($conn,"SELECT nama_file FROM dokumen WHERE id='$id'"))['nama_file'];
if(file_exists("uploads/".$file)){
    unlink("uploads/".$file);
}

mysqli_query($conn,"DELETE FROM dokumen WHERE id='$id'");
header("Location: view.php?kategori=$kategori");
?>