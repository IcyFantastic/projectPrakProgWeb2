<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: ../Halaman_Login/login.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perusahaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap' rel='stylesheet'>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">IL</div>
                <div class="logo-text">InfoLoker</div>
            </div>
            <nav class="nav-links">
                <a href="dashboard_perusahaan.php" class="active">Beranda</a>
                <a href="profile.php">Profil</a>
                <a href="lowongan_saya.php">Lowongan Saya</a>
                <a href="../logout.php">Keluar</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="dashboard-container">
            <section class="search-section">
                <h1>Selamat datang, <?= htmlspecialchars($perusahaan['nama_perusahaan']) ?></h1>
                <p class="search-subtitle">📍 <?= htmlspecialchars($perusahaan['lokasi']) ?></p>
            </section>

            <section class="jobs-section">
                <div class="section-title">
                    <h2>Lowongan Yang Dibuka</h2>
                    <a href="tambah_lowongan.php" class="add-job-button">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                
                <div class="job-grid">
                    <?php while ($row = mysqli_fetch_assoc($lowongan)): ?>
                        <div class="job-card">
                            <div class="job-card-header">
                                <h3 class="company-name">
                                    <i class="fas fa-building"></i>
                                    <?= htmlspecialchars($perusahaan['nama_perusahaan']) ?>
                                </h3>
                                <h4 class="job-title"><?= htmlspecialchars($row['judul']) ?></h4>
                                <p class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($row['lokasi']) ?>
                                </p>
                            </div>
                            <div class="job-card-body">
                                <div class="job-tags">
                                    <span class="tag"><?= $row['jenis_pekerjaan'] ?></span>
                                    <span class="tag"><?= $row['pendidikan'] ?></span>
                                    <span class="tag"><?= $row['level_pekerjaan'] ?></span>
                                </div>
                            </div>
                            <div class="job-card-footer">
                                <span><i class="fas fa-money-bill-wave"></i> <?= $row['gaji'] ?></span>
                                <span><i class="fas fa-users"></i> <?= $row['jumlah_pelamar'] ?> Pelamar</span>
                            </div>
                            <div class="action-buttons">
                                <a href="edit_lowongan.php?id=<?= $row['id'] ?>" class="action-btn edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="lihat_pelamar.php?id=<?= $row['id'] ?>" class="action-btn view">
                                    <i class="fas fa-eye"></i> Lihat Pelamar
                                </a>
                                <a href="hapus_lowongan.php?id=<?= $row['id'] ?>" class="action-btn delete" 
                                   onclick="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; IL.</p>
    </footer>
</body>
</html>
