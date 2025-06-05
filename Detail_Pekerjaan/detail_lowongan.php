<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'pelamar') {
    header("Location: login.php");
    exit();
}

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
    <link rel="stylesheet" href="detail.css">
</head>
<body>

<?php include 'partials/header.php'; ?>

<div class="container">
   <body>
    <?php include '../partials/header.php'; ?>

    <div class="container">
        <nav class="breadcrumb">
            <a href="../dashboard/dashboard_pelamar.php">Home</a> / 
            <span>Detail Lowongan</span>
        </nav>

        <div class="job-header">
            <h1><?= htmlspecialchars($lowongan['judul']) ?></h1>
            <p class="company-name">
                🏢 <?= htmlspecialchars($lowongan['nama_perusahaan']) ?>
            </p>

            <?php if ($sudahMelamar): ?>
                <div class="alert alert-warning">
                    ⚠️ Anda sudah pernah melamar lowongan ini
                </div>
            <?php else: ?>
                <button 
                    class="apply-btn" 
                    data-href="form_lamaran.php?id=<?= $idLowongan ?>"
                    onclick="handleApply(this)">
                    Lamar Pekerjaan
                </button>
            <?php endif; ?>
        </div>

        <div class="job-container">
            <!-- Job Details Section -->
            <div class="job-details">
                <!-- ... existing job details code ... -->
            </div>

            <!-- Company Card Section -->
            <div class="company-card">
                <!-- ... existing company card code ... -->
            </div>
        </div>

        <button class="back-btn" onclick="window.history.back()">
            ⬅ Kembali
        </button>
    </div>


<?php include 'partials/footer.php'; ?>
scr
</body>
</html>
