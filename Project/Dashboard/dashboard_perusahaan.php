<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: ../Login/login.php");
    exit();
}
require '../koneksi.php';

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
    <link rel="stylesheet" href="utama_perusahaan.css">
</head>
<body>

<div class="dashboard-container">
    <?php include '../partials/header.php'; ?>

    <nav class="breadcrumb">
        <div class="breadcrumb-content">
            <a href="../Dashboard/dashboard_perusahaan.php">Home</a> / <span>Dashboard Perusahaan</span>
        </div>
    </nav>

    <div class="main-content">
        <section id="search" class="welcome-section">
            <div class="welcome-header">
                <h2>Selamat datang, <?= htmlspecialchars($perusahaan['nama_perusahaan']) ?></h2>
                <p>📍 Lokasi: <?= $perusahaan['lokasi'] ?></p>
            </div>
            <button class="action-button" onclick="window.location.href='../Perusahaan/tambah_lowongan.php'">
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
                            <a href="../Perusahaan/edit_lowongan.php?id=<?= $row['id'] ?>" class="btn edit">✏ Edit</a>
                            <a href="hapus_lowongan.php?id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Yakin ingin menghapus lowongan ini?')">🗑 Hapus</a>
                            <a href="../pages/lihat_pelamar.php?id=<?= $row['id'] ?>" class="btn view">👀 Lihat Pelamar</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>

    <?php include '../partials/footer.php'; ?>
</div>

</body>
</html>