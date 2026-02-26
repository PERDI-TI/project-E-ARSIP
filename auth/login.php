<?php
session_start();
include "../config/koneksi.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $data = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($data);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../dashboard.php");
    } else {
        echo "<script>alert('Login gagal');</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../assets/form.css">
    <title>Login</title>
</head>

<body class="center">
    <div class="card">
        <h2>Login</h2>
        <form method="POST">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
        <div>
        </div>
        <p>Jika belum punya akun, silahkan buat akun terlebih dahulu? 
            <a href="register.php">Register</a></p>
    </div>
</body>

</html>