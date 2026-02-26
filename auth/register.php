<?php
session_start();
include "../config/koneksi.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO users(username,email,password)
        VALUES('$username','$email','$password')");
        header("Location: login.php");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../assets/form.css">
    <title>Register</title>
</head>

<body class="center">
    <div class="card">
        <h2>Register</h2>
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <label>Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button name="register">Register</button>
        </form>
        <p>Jika sudah mempunyai akun silakan? 
        <a href="login.php">Login</a></p>
    </div>
</body>

</html>