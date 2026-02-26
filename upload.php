<?php
session_start();
include "config/koneksi.php";

if(isset($_POST['upload'])){
    $kategori = $_POST['kategori'];
    $user_id = $_SESSION['user_id'];

    $file = $_FILES['file']['name'];
    $tmp  = $_FILES['file']['tmp_name'];
    $ext  = pathinfo($file, PATHINFO_EXTENSION);

    $tipe_file = strtolower($ext);
    move_uploaded_file($tmp,"uploads/".$file);

    mysqli_query($conn,"INSERT INTO dokumen(user_id,kategori,nama_file,tipe_file)
    VALUES('$user_id','$kategori','$file','$tipe_file')");

    header("Location: view.php?kategori=$kategori");
}
?>