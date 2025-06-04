<?php
session_start();
require '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // Debug: Print values
    // echo "Username: $username, Password: $password, Role: $role";
    
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);
    
    // Debug: Print query and any errors
    // echo $query;
    // echo mysqli_error($conn);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'pelamar') {
            header("Location: ../Halaman_Utama/dashboard_pelamar.php");
            exit();
        } elseif ($user['role'] == 'perusahaan') {
            header("Location: ../Halaman_Utama/dashboard_perusahaan.php");
            exit();
        }
    } else {
        $error = "Username, password, atau role tidak sesuai";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoLoker - Login</title>
    <link rel="stylesheet" href="Logindefault.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="login.js"></script>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">IL</div>
                <div class="logo-text">InfoLoker</div>
            </div>
            <nav class="nav-links">
                <a href="#home">Home</a>
                <a href="#about">Tentang</a>
                <a href="#vision">Visi & Misi</a>
                <a href="#contact">Contact</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="login-container">
            <div class="role-selection">
                <button type="button" class="role-btn active" data-role="pelamar">
                    <i class='bx bxs-user'></i> Pelamar
                </button>
                <button type="button" class="role-btn" data-role="perusahaan">
                    <i class='bx bxs-briefcase'></i> Perusahaan
                </button>
            </div>

            <form class="login-form" method="POST" action="">
                <input type="hidden" name="role" id="selectedRole" value="pelamar">
                <div class="input-group">
                    <input type="text" class="input-field" name="username" placeholder="Masukkan username" required>
                    <i class='bx bxs-user input-icon'></i>
                </div>
                <div class="input-group">
                    <input type="password" class="input-field" name="password" placeholder="Kata Sandi" required>
                    <i class='bx bxs-lock-alt input-icon'></i>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        Ingat Saya
                    </label>
                    <a href="#" class="forgot-password">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="login-btn">
                    <span class="btn-text">Masuk</span>
                    <div class="loading"></div>
                </button>

                <div class="register-link">
                    Belum punya akun? <a href="#">Daftar Sekarang</a>
                </div>
            </form>

            <!-- Di bagian form, tambahkan error message display -->
            <?php if(isset($error)): ?>
                <div class="error-message" style="color: red; text-align: center; margin-bottom: 10px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?>
</body>
</html>