<?php
session_start();
// Periksa apakah pengguna sudah login dan memiliki peran sebagai perusahaan
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: login.php");
    exit();
}
require 'koneksi.php';

$userId = $_SESSION['id'];

// Ambil data perusahaan berdasarkan user_id
$getPerusahaan = mysqli_query($conn, "SELECT * FROM perusahaan WHERE user_id = $userId");
$perusahaan = mysqli_fetch_assoc($getPerusahaan);
$perusahaanId = $perusahaan['id'];

// Ambil daftar lowongan milik perusahaan
$lowongan = mysqli_query($conn, "
    SELECT l.*, 
           (SELECT COUNT(*) FROM lamaran WHERE lamaran.lowongan_id = l.id) AS jumlah_pelamar
    FROM lowongan l
    WHERE perusahaan_id = $perusahaanId
    ORDER BY l.tanggal_posting DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Perusahaan</title>
    <style>
        /* Variabel warna dan gaya global */
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

        /* Reset margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Gaya untuk elemen body */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Container utama dashboard */
        .dashboard-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
        }

        /* Gaya breadcrumb */
        .breadcrumb {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 60px; /* Sesuaikan dengan tinggi header */
        }

        .breadcrumb-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
        }

        .breadcrumb a {
            color: var(--white);
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .breadcrumb span {
            color: var(--white);
            opacity: 0.6;
        }

        .breadcrumb a:hover {
            opacity: 1;
        }

        /* Konten utama */
        .main-content {
            flex: 1;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            margin-top: 20px; /* Dikurangi karena ada breadcrumb */
        }

        /* Bagian selamat datang */
        .welcome-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .welcome-header h2 {
            margin-bottom: 0.5rem;
        }

        .welcome-header p {
            opacity: 0.9;
        }

        .action-button {
            background-color: var(--white);
            color: var(--primary-color);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        /* Judul bagian */
        .section-title {
            color: var(--white);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        /* Kartu lowongan */
        .job-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .job-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .job-header h3 {
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .job-header h2 {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .location {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        /* Tag */
        .job-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .tag {
            background: var(--secondary-color);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Informasi lowongan */
        .job-info {
            display: flex;
            justify-content: space-between;
            margin: 1rem 0;
            color: var(--text-secondary);
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        /* Tombol aksi */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--white);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .edit {
            background-color: #ffc107;
        }

        .delete {
            background-color: #dc3545;
        }

        .view {
            background-color: var(--primary-color);
        }

        /* Desain responsif */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .welcome-section {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'header.php'; ?>

    <nav class="breadcrumb">
        <div class="breadcrumb-content">
            <a href="dashboard_perusahaan.php">Home</a> / <span>Dashboard Perusahaan</span>
        </div>
    </nav>

    <div class="main-content">
        <section id="search" class="welcome-section">
            <div class="welcome-header">
                <h2>Selamat datang, <?= htmlspecialchars($perusahaan['nama_perusahaan']) ?></h2>
                <p>📍 Lokasi: <?= $perusahaan['lokasi'] ?></p>
            </div>
            <button class="action-button" onclick="window.location.href='tambah_lowongan.php'">
                <span class="button-icon">➕</span> Tambah Lowongan
            </button>
        </section>

        <h1 class="section-title">Lowongan Kerja Yang Anda Buka</h1>

        <section id="job-listings">
            <div class="job-container">
                <?php while ($row = mysqli_fetch_assoc($lowongan)): ?>
                    <div class="job-card">
                        <div class="job-header">
                            <h3><?= htmlspecialchars($row['judul']) ?></h3>
                            <h2><?= htmlspecialchars($perusahaan['nama_perusahaan']) ?></h2>
                            <p class="location">📍 <?= htmlspecialchars($row['lokasi']) ?></p>
                        </div>
                        <div class="job-tags">
                            <span class="tag"><?= $row['jenis_pekerjaan'] ?></span>
                            <span class="tag"><?= $row['pendidikan'] ?></span>
                            <span class="tag"><?= $row['level_pekerjaan'] ?></span>
                        </div>
                        <div class="job-info">
                            <p class="salary">💰 <?= $row['gaji'] ?></p>
                            <p class="applicants">👥 Pelamar: <?= $row['jumlah_pelamar'] ?> orang</p>
                        </div>
                        <div class="action-buttons">
                            <a href="edit_lowongan.php?id=<?= $row['id'] ?>" class="btn edit">✏ Edit</a>
                            <a href="hapus_lowongan.php?id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Yakin ingin menghapus lowongan ini?')">🗑 Hapus</a>
                            <a href="lihat_pelamar.php?id=<?= $row['id'] ?>" class="btn view">👀 Lihat Pelamar</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>
</div>

</body>
</html>