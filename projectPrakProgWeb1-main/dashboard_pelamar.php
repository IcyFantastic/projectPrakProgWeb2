<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'pelamar') {
    header("Location: login.php");
    exit();
}

require 'koneksi.php';

// Fungsi pencarian
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
    <title>Dashboard Pelamar</title>
    <link rel="stylesheet" href="UtamaPelamar.css">
</head>
<body>

<?php include 'partials/header.php'; ?>

<section id="search">
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Cari berdasarkan Nama Perusahaan / Lokasi / Jenis Pekerjaan / Gaji" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="tombol-pencarian">Cari</button>
    </form>
</section>

<h1 class="lowongan-tanda">Daftar Lowongan Kerja</h1>

<section id="job-listings">
    <div class="job-container">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <a href="detail_lowongan.php?id=<?= $row['id'] ?>" class="job-card">
                <h3><?= htmlspecialchars($row['nama_perusahaan']) ?></h3>
                <h2><?= htmlspecialchars($row['judul']) ?></h2>
                <p>📍 <?= htmlspecialchars($row['lokasi']) ?></p>
                <div class="job-tags">
                    <span class="job-tag"><?= $row['jenis_pekerjaan'] ?></span>
                    <span class="job-tag"><?= $row['pendidikan'] ?></span>
                    <span class="job-tag"><?= $row['level_pekerjaan'] ?></span>
                </div>
                <div class="job-footer">
                    <p class="salary">💰 Gaji: <?= htmlspecialchars($row['gaji']) ?></p>
                    <p>Tgl Posting: <?= $row['tanggal_posting'] ?></p>
                </div>
            </a>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'partials/footer.php'; ?>

</body>
</html>
