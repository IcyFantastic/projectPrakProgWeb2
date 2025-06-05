<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: ../Login/login.php");
    exit();
}
require '../koneksi.php';

$userId = $_SESSION['id'];
$lowonganId = $_GET['id'] ?? null;

if (!$lowonganId) {
    echo "ID lowongan tidak ditemukan.";
    exit();
}

// Cek apakah lowongan milik perusahaan
$getPerusahaan = mysqli_query($conn, "SELECT * FROM perusahaan WHERE user_id = $userId");
$perusahaan = mysqli_fetch_assoc($getPerusahaan);
$perusahaanId = $perusahaan['id'];

$cekLowongan = mysqli_query($conn, "SELECT * FROM lowongan WHERE id = $lowonganId AND perusahaan_id = $perusahaanId");
$lowongan = mysqli_fetch_assoc($cekLowongan);

if (!$lowongan) {
    echo "Lowongan tidak ditemukan atau bukan milik Anda.";
    exit();
}

// Ambil data pelamar
$pelamarQuery = mysqli_query($conn, "
    SELECT 
        lamaran.*,
        pelamar.nama_lengkap,
        pelamar.tanggal_lahir,
        pelamar.no_hp,
        pelamar.email
    FROM lamaran
    JOIN pelamar ON lamaran.pelamar_id = pelamar.id
    WHERE lamaran.lowongan_id = $lowonganId
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pelamar - <?= htmlspecialchars($lowongan['judul']) ?></title>
    <link rel="stylesheet" href="lihat_pelamar.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <nav class="breadcrumb">
        <div class="breadcrumb-content">
            <a href="../Dashboard/dashboard_perusahaan.php">Home</a> / <span>Daftar Pelamar</span>
        </div>
    </nav>

    <div class="main-content">
        <section class="applicant-section">
            <h1 class="section-title">Pelamar untuk: <?= htmlspecialchars($lowongan['judul']) ?></h1>

            <?php if (mysqli_num_rows($pelamarQuery) > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Nomor HP</th>
                                <th>Tanggal Lahir</th>
                                <th>CV</th>
                                <th>Portofolio</th>
                                <th>Surat Lamaran</th>
                                <th>Waktu Melamar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($p = mysqli_fetch_assoc($pelamarQuery)): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['nama_lengkap']) ?></td>
                                <td><?= htmlspecialchars($p['email']) ?></td>
                                <td><?= htmlspecialchars($p['no_hp']) ?></td>
                                <td><?= htmlspecialchars($p['tanggal_lahir']) ?></td>
                                <td class="document-cell">
                                    <?php if ($p['cv']): ?>
                                        <a href="uploads/cv/<?= $p['cv'] ?>" target="_blank" class="view-link">CV</a>
                                    <?php else: ?>-<?php endif; ?>
                                </td>
                                <td class="document-cell">
                                    <?php if ($p['portofolio']): ?>
                                        <a href="uploads/portofolio/<?= $p['portofolio'] ?>" target="_blank" class="view-link">Portfolio</a>
                                    <?php else: ?>-<?php endif; ?>
                                </td>
                                <td class="document-cell">
                                    <?php if ($p['surat_lamaran']): ?>
                                        <a href="uploads/surat/<?= $p['surat_lamaran'] ?>" target="_blank" class="view-link">Surat</a>
                                    <?php else: ?>-<?php endif; ?>
                                </td>
                                <td><?= $p['waktu_lamaran'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>Belum ada pelamar untuk lowongan ini.</p>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
