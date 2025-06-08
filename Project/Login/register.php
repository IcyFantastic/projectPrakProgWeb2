<?php
session_start();
require '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'pelamar';

    // Validasi username
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username sudah digunakan";
    } else {
        // Insert user baru
        $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['register_success'] = true;
            header("Location: login.php");
            exit();
        } else {
            $error = "Gagal mendaftar: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoLoker - Daftar Akun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .register-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-title {
            font-size: 24px;
            margin: 0;
        }
        .register-subtitle {
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
        .register-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .register-btn:hover {
            background-color: #0056b3;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
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
    <?php include '../partials/header.php'; ?>

    <main class="main-content">
        <div class="register-container">
            <div class="register-header">
                <h1 class="register-title">Daftar Akun</h1>
                <p class="register-subtitle">Buat akun InfoLoker baru</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="error-message">
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

            <form class="register-form" method="POST" action="">
                <input type="hidden" name="role" id="selectedRole" value="pelamar">
                
                <div class="input-group">
                    <input type="text" class="input-field" name="username" placeholder="Username" required>
                    <i class='bx bxs-user input-icon'></i>
                </div>

                <div class="input-group">
                    <input type="email" class="input-field" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope input-icon'></i>
                </div>

                <div class="input-group">
                    <input type="password" class="input-field" name="password" placeholder="Kata Sandi" required>
                    <i class='bx bxs-lock-alt input-icon'></i>
                </div>

                <button type="submit" class="register-btn">
                    <span class="btn-text">Daftar</span>
                </button>

                <div class="login-link">
                    Sudah punya akun? <a href="login.php">Masuk</a>
                </div>
            </form>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?>
</body>
</html>