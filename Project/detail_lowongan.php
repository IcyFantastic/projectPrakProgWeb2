<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pelamar') {
    header("Location: login.php");
    exit();
}
require 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID lowongan tidak valid.";
    exit();
}

$idLowongan = $_GET['id'];
$userId = $_SESSION['id'];

// Ambil detail lowongan
$query = "SELECT l.*, p.nama_perusahaan, p.lokasi AS lokasi_perusahaan, p.logo 
          FROM lowongan l 
          JOIN perusahaan p ON l.perusahaan_id = p.id 
          WHERE l.id = $idLowongan";
$result = mysqli_query($conn, $query);
$lowongan = mysqli_fetch_assoc($result);

if (!$lowongan) {
    echo "Lowongan tidak ditemukan.";
    exit();
}

// Cek apakah user sudah melamar
$cekLamaran = mysqli_query($conn, "
    SELECT * FROM lamaran 
    WHERE pelamar_id = (SELECT id FROM pelamar WHERE user_id = $userId) 
    AND lowongan_id = $idLowongan
");
$sudahMelamar = mysqli_num_rows($cekLamaran) > 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($lowongan['judul']) ?> - <?= htmlspecialchars($lowongan['nama_perusahaan']) ?></title>
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #5856eb;
            --secondary-color: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: sticky;
            top: 60px;
            z-index: 999;
            width: 100%;
        }

        .breadcrumb a {
            color: var(--white);
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .breadcrumb a:hover {
            opacity: 1;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Job Header */
        .job-header {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: var(--shadow-lg);
        }

        .job-header h1 {
            color: var(--text-primary);
            margin: 0 0 1rem 0;
            font-size: 2rem;
        }

        .company-name {
            color: var(--text-secondary);
            font-size: 1.2rem;
            margin: 0.5rem 0;
        }

        .company-name a {
            color: var(--primary-color);
            text-decoration: none;
        }

        /* Job Container */
        .job-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin: 2rem 0;
        }

        /* Job Details */
        .job-details {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
        }

        .job-details p {
            color: var(--text-secondary);
            margin: 1rem 0;
        }

        .job-details strong {
            color: var(--text-primary);
        }

        /* Company Card */
        .company-card {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: calc(60px + 3rem);
        }

        .company-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .company-logo {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            object-fit: cover;
        }

        .company-info p {
            color: var(--text-secondary);
            margin: 0.5rem 0;
        }

        /* Buttons */
        .apply-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .apply-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .back-btn {
            background: var(--secondary-color);
            color: var(--text-primary);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: var(--border-color);
            transform: translateY(-2px);
        }

        /* Sections */
        .job-description, .job-requirements {
            margin: 2rem 0;
        }

        .job-description h2, .job-requirements h2 {
            color: var(--text-primary);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Already Applied Warning */
        .warning-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .job-container {
                grid-template-columns: 1fr;
            }

            .company-card {
                position: static;
            }

            .container {
                padding: 1rem;
            }

            .job-header, .job-details, .company-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <nav class="breadcrumb">
        <a href="dashboard_pelamar.php">Home</a> / <a href="#">Detail Lowongan</a>
    </nav>
    <div class="job-header">
        <h1><?= htmlspecialchars($lowongan['judul']) ?></h1>
        <p class="company-name">🏢 <a href="#"><?= htmlspecialchars($lowongan['nama_perusahaan']) ?></a></p>

        <?php if ($sudahMelamar): ?>
            <div class="warning-message">⚠️ Anda sudah pernah melamar LOWONGAN ini.</div>
        <?php else: ?>
            <button class="apply-btn" onclick="window.location.href='form_lamaran.php?id=<?= $lowongan['id'] ?>'">
                📝 Lamar Pekerjaan
            </button>
        <?php endif; ?>
    </div>

    <div class="job-container">
        <div class="job-details">
            <p>📍 <strong>Lokasi:</strong> <?= htmlspecialchars($lowongan['lokasi']) ?></p>
            <p>⏳ <strong>Tipe:</strong> <?= htmlspecialchars($lowongan['jenis_pekerjaan']) ?></p>
            <p>📌 <strong>Level:</strong> <?= htmlspecialchars($lowongan['level_pekerjaan']) ?></p>
            <p>🎓 <strong>Pendidikan:</strong> <?= htmlspecialchars($lowongan['pendidikan']) ?></p>
            <p>💰 <strong>Gaji:</strong> <?= htmlspecialchars($lowongan['gaji']) ?></p>

            <section class="job-description">
                <h2>Deskripsi:</h2>
                <p><?= nl2br(htmlspecialchars($lowongan['deskripsi'])) ?></p>
            </section>

            <section class="job-requirements">
                <h2>Keahlian:</h2>
                <p><?= nl2br(htmlspecialchars($lowongan['keahlian'])) ?></p>
                <h2>Kualifikasi:</h2>
                <p><?= nl2br(htmlspecialchars($lowongan['kualifikasi'])) ?></p>
            </section>
        </div>

        <div class="company-card">
            <div class="company-header">
                <img src="Gambar/<?= $lowongan['logo'] ?>" alt="Logo" class="company-logo">
                <h2><?= htmlspecialchars($lowongan['nama_perusahaan']) ?></h2>
            </div>
            <div class="company-info">
                <p>📍 <?= htmlspecialchars($lowongan['lokasi_perusahaan']) ?></p>
                <p>🏢 Industri: Tidak ditentukan</p>
                <p>👥 Skala: Tidak ditentukan</p>
            </div>
            <p class="company-desc">Deskripsi perusahaan dapat ditambahkan di database jika ingin lebih lengkap.</p>
        </div>
    </div>

    <button class="back-btn" onclick="window.location.href='dashboard_pelamar.php'">⬅ Kembali ke Halaman Utama</button>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
