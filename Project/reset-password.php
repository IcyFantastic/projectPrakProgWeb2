<?php
session_start();
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Cek email exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        // In real application, send reset password email
        $success = "Link reset password telah dikirim ke email Anda";
    } else {
        $error = "Email tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoLoker - Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .reset-container {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .reset-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .reset-title {
            font-size: 24px;
            margin: 0;
        }
        .reset-subtitle {
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
        .reset-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .reset-btn:hover {
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
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="main-content">
        <div class="reset-container">
            <div class="reset-header">
                <h1 class="reset-title">Reset Password</h1>
                <p class="reset-subtitle">Masukkan email untuk reset password</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="success-message">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form class="reset-form" method="POST" action="">
                <div class="input-group">
                    <input type="email" class="input-field" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope input-icon'></i>
                </div>

                <button type="submit" class="reset-btn">
                    <span class="btn-text">Kirim Link Reset</span>
                </button>

                <div class="login-link">
                    <a href="login.php">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>