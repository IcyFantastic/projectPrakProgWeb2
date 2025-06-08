<?php include '../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoLoker - Tentang Kami</title>
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
        .about-section .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .about-section h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }
        .about-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .about-card {
            flex: 1;
            min-width: 300px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .about-card .card-icon {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 10px;
        }
        .about-card h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .about-card p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666;
        }
        .features-list {
            list-style: none;
            padding: 0;
        }
        .features-list li {
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <section class="about-section">
            <div class="container">
                <h1>Tentang InfoLoker</h1>
                <div class="about-grid">
                    <div class="about-card">
                        <i class='bx bxs-user-badge card-icon'></i>
                        <h2>Untuk Pencari Kerja</h2>
                        <p>InfoLoker menyediakan platform untuk mencari lowongan pekerjaan yang sesuai dengan keahlian dan minat Anda. Temukan berbagai peluang karir dari perusahaan terpercaya dengan mudah dan cepat.</p>
                        <ul class="features-list">
                            <li>Pencarian lowongan yang mudah</li>
                            <li>Lamar pekerjaan dengan satu klik</li>
                            <li>Kelola profil dan CV online</li>
                            <li>Pantau status lamaran</li>
                        </ul>
                    </div>
                    <div class="about-card">
                        <i class='bx bxs-buildings card-icon'></i>
                        <h2>Untuk Perusahaan</h2>
                        <p>Temukan kandidat terbaik untuk perusahaan Anda melalui platform kami. Posting lowongan pekerjaan dan kelola proses rekrutmen dengan efisien.</p>
                        <ul class="features-list">
                            <li>Posting lowongan pekerjaan</li>
                            <li>Akses database kandidat</li>
                            <li>Kelola lamaran masuk</li>
                            <li>Branding perusahaan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>