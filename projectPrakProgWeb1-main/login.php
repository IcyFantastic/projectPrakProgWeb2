<?php
session_start();
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = md5($_POST['password']); // harus match dengan hash di DB

    $query = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $data['id'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];

        // Redirect berdasarkan role
        if ($data['role'] == 'pelamar') {
            header("Location: dashboard_pelamar.php");
        } elseif ($data['role'] == 'perusahaan') {
            header("Location: dashboard_perusahaan.php");
        }
    } else {
        echo "<script>alert('Login gagal. Cek email atau password.'); window.location='login.php';</script>";
    }
}
?>
