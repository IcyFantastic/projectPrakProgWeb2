<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: login.php");
    exit();
}

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
    <link rel="stylesheet" href="UtamaPerusahaan.css">
</head>
<body>

<?php include 'partials/header.php'; ?>

<nav class="breadcrumb">
    <a href="#">Home</a> / <a href="#">Dashboard Perusahaan</a>
</nav>

<section id="search">
    <h2>Selamat datang, <?= htmlspecialchars($perusahaan['nama_perusahaan']) ?></h2>
    <p>📍 Lokasi: <?= $perusahaan['lokasi'] ?></p>
    <button class="tombol-pencarian" onclick="window.location.href='tambah_lowongan.php'">➕ Tambah Lowongan</button>
</section>

<h1 class="lowongan-tanda">Lowongan Kerja Yang Anda Buka</h1>

<section id="job-listings">
    <div class="job-container">
        <?php while ($row = mysqli_fetch_assoc($lowongan)): ?>
            <div class="job-card">
                <h3><?= htmlspecialchars($row['judul']) ?></h3>
                <h2><?= htmlspecialchars($perusahaan['nama_perusahaan']) ?></h2>
                <p>📍 <?= htmlspecialchars($row['lokasi']) ?></p>
                <div class="job-tags">
                    <span class="job-tag"><?= $row['jenis_pekerjaan'] ?></span>
                    <span class="job-tag"><?= $row['pendidikan'] ?></span>
                    <span class="job-tag"><?= $row['level_pekerjaan'] ?></span>
                </div>
                <div class="job-footer">
                    <p class="salary">💰 <?= $row['gaji'] ?></p>
                    <p>Pelamar: <?= $row['jumlah_pelamar'] ?> orang</p>
                </div>
                <div style="margin-top: 10px;">
                    <a href="edit_lowongan.php?id=<?= $row['id'] ?>" class="job-tag" style="background:#ffc107;">✏ Edit</a>
                    <a href="hapus_lowongan.php?id=<?= $row['id'] ?>" class="job-tag" style="background:#dc3545;" onclick="return confirm('Yakin ingin menghapus lowongan ini?')">🗑 Hapus</a>
                    <a href="lihat_pelamar.php?id=<?= $row['id'] ?>" class="job-tag" style="background:#17a2b8;">👀 Lihat Pelamar</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'partials/footer.php'; ?>

</body>
</html>
