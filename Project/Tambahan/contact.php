<?php include '../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoLoker - Hubungi Kami</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .main-content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .contact-section .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .contact-section h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }
        .contact-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .contact-info {
            flex: 1;
            min-width: 300px;
        }
        .info-card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .info-card .card-icon {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 10px;
        }
        .info-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .info-card p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666;
        }
        .contact-form {
            flex: 1;
            min-width: 300px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .contact-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: none;
        }
        .submit-btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <section class="contact-section">
            <div class="container">
                <h1>Hubungi Kami</h1>
                <div class="contact-grid">
                    <div class="contact-info">
                        <div class="info-card">
                            <i class='bx bxs-map card-icon'></i>
                            <h3>Alamat</h3>
                            <p>Jl. Telkom University No. 1<br>Bandung, Jawa Barat 40257</p>
                        </div>
                        <div class="info-card">
                            <i class='bx bxs-phone card-icon'></i>
                            <h3>Telepon</h3>
                            <p>+62 22 7564108</p>
                        </div>
                        <div class="info-card">
                            <i class='bx bxs-envelope card-icon'></i>
                            <h3>Email</h3>
                            <p>info@infoloker.id</p>
                        </div>
                    </div>
                    <div class="contact-form">
                        <h2>Kirim Pesan</h2>
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="nama" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <textarea name="pesan" placeholder="Pesan" required></textarea>
                            </div>
                            <button type="submit" class="submit-btn">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>