<?php
session_start();
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'pelamar') {
            header("Location: dashboard_pelamar.php");
            exit();
        } elseif ($user['role'] == 'perusahaan') {
            header("Location: dashboard_perusahaan.php");
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-title {
            font-size: 24px;
            margin: 0;
        }
        .login-subtitle {
            font-size: 14px;
            color: #666;
        }
        .input-group {
            margin-bottom: 15px;
            position: relative;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .input-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #aaa;
        }
        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
        .register-link {
            text-align: center;
            margin-top: 10px;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleButtons = document.querySelectorAll('.role-btn');
            const selectedRoleInput = document.getElementById('selectedRole');

            roleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    roleButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    selectedRoleInput.value = this.getAttribute('data-role');
                });
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="main-content">
        <div class="login-container">
            <div class="login-header">
                <h1 class="login-title">Selamat Datang</h1>
                <p class="login-subtitle">Masuk ke akun InfoLoker Anda</p>
            </div>

            <!-- Error Mesasage Display -->
            <?php if(isset($error)): ?>
                <div class="error-message" style="color: red; text-align: center; margin-bottom: 10px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

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
                    <a href="reset-password.php" class="forgot-password">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="login-btn">
                    <span class="btn-text">Masuk</span>
                    <div class="loading"></div>
                </button>

                <div class="register-link">
                    Belum punya akun? <a href="register.php">Daftar Sekarang</a>
                </div>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>