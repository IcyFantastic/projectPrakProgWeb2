<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoLoker - Visi & Misi</title>
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
        .vision-section .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .vision-section h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }
        .vision-content {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .vision-card, .mission-card {
            flex: 1;
            min-width: 300px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .vision-card h2, .mission-card h2 {
            font-size: 24px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .vision-card p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666;
        }
        .mission-card ul {
            list-style: none;
            padding: 0;
        }
        .mission-card ul li {
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <section class="vision-section">
            <div class="container">
                <h1>Visi & Misi</h1>
                <div class="vision-content">
                    <div class="vision-card">
                        <h2><i class='bx bx-bulb'></i> Visi</h2>
                        <p>Menjadi platform terdepan dalam menghubungkan talenta terbaik dengan perusahaan di Indonesia untuk menciptakan ekosistem ketenagakerjaan yang produktif dan berkelanjutan.</p>
                    </div>
                    <div class="mission-card">
                        <h2><i class='bx bx-target-lock'></i> Misi</h2>
                        <ul>
                            <li>Menyediakan platform yang mudah dan efisien untuk pencarian kerja</li>
                            <li>Memfasilitasi perusahaan dalam menemukan kandidat terbaik</li>
                            <li>Meningkatkan kualitas SDM Indonesia melalui informasi karir</li>
                            <li>Menciptakan transparansi dalam proses rekrutmen</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>