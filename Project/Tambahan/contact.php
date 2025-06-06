<?php include '../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoLoker - Hubungi Kami</title>
    <link rel="stylesheet" href="tambahan.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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