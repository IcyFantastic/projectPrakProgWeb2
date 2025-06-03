<?php
session_start();
require 'koneksi.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = md5($_POST['password']); // cocokkan hash MD5 dari password

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
            exit;
        } elseif ($data['role'] == 'perusahaan') {
            header("Location: dashboard_perusahaan.php");
            exit;
        }
    } else {
        $error = "Login gagal. Cek email atau password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/Logindefault.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <img src="../Gambar/Adobe Express - file.png" alt="Logo" class="logo">
        <h2 class="logonama">InfoLoker</h2>
        <nav class="navigasi">
            <a href="Logindefault.html">Home</a>
            <a href="#">Tentang</a>
            <a href="#">Visi & Misi</a>
            <a href="#">Contact</a>
            <div class="dropdown">
    <button class="tombolLogin">Login ⮟</button>
    <div class="dropdown-menu">
        <a href="LoginUser.html"><i class='bx bxs-user'></i>Pelamar</a>
        <a href="LoginPerusahaan.html"><i class='bx bxs-briefcase'></i>Perusahaan</a>
    </div>
</div>
            </div>
        </nav>
    </header>

    

    <div class="wrapper">
        <form action="../Halaman_Utama/UtamaPelamar.html">
            <h1>Login Pelamar</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" required> 
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Kata sandi" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Ingat Saya</label>
                <a href="#">Lupa Kata Sandi?</a>
            </div>
            
            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Tidak punya akun? <a href="#">Daftar Sekarang!</a></p>
            </div>
        </form>

       
    </div>

    <footer class="footer">
        <footer>
            <p>Hansel Ivano.S - 71231039 | Laurensius Rio Darryl - 71231022</p>
        </footer>
    </footer>
    
    
</body>
</html>