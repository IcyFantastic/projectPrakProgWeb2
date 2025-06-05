<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pelamar') {
    header("Location: ../Halaman_Login/login.php");
    exit();
}
require '../koneksi.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT l.*, p.nama_perusahaan 
        FROM lowongan l 
        JOIN perusahaan p ON l.perusahaan_id = p.id
        WHERE 
            l.judul LIKE '%$search%' OR 
            p.nama_perusahaan LIKE '%$search%' OR 
            l.lokasi LIKE '%$search%' OR 
            l.jenis_pekerjaan LIKE '%$search%' OR 
            l.gaji LIKE '%$search%'";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelamar</title>
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
                <a href="dashboard_pelamar.php" class="active">Beranda</a>
                <a href="profile.php">Profil</a>
                <a href="lamaran_saya.php">Lamaran Saya</a>
                <a href="../logout.php">Keluar</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="dashboard-container">
            <section class="search-section">
                <h1>Temukan Pekerjaan Impianmu</h1>
                <p class="search-subtitle">Jelajahi ribuan lowongan kerja sesuai dengan keahlianmu</p>
                <form method="GET" action="" class="search-form">
                    <div class="search-input-group">
                        <input type="text" name="search" 
                               placeholder="Cari berdasarkan posisi, perusahaan, atau lokasi" 
                               value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i> Cari Pekerjaan
                        </button>
                    </div>
                </form>
            </section>

            <section class="jobs-section">
                <div class="section-title">
                    <h2>Lowongan Tersedia</h2>
                </div>
                <div class="jobs-container">
                    <div class="job-grid">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <a href="detail_lowongan.php?id=<?= $row['id'] ?>" class="job-card-link">
                            <div class="job-card">
                                <div class="job-card-header">
                                    <h3 class="company-name">
                                        <i class="fas fa-building"></i>
                                        <?= htmlspecialchars($row['nama_perusahaan']) ?>
                                    </h3>
                                    <h4 class="job-title"><?= htmlspecialchars($row['judul']) ?></h4>
                                </div>
                                <div class="job-card-body">
                                    <p class="location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?= htmlspecialchars($row['lokasi']) ?>
                                    </p>
                                    <div class="job-tags">
                                        <span class="tag"><?= $row['jenis_pekerjaan'] ?></span>
                                        <span class="tag"><?= $row['pendidikan'] ?></span>
                                        <span class="tag"><?= $row['level_pekerjaan'] ?></span>
                                    </div>
                                </div>
                                <div class="job-card-footer">
                                    <p class="salary">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <?= htmlspecialchars($row['gaji']) ?>
                                    </p>
                                    <p class="posted-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <?= $row['tanggal_posting'] ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 InfoLoker. All rights reserved.</p>
    </footer>
</body>
</html>