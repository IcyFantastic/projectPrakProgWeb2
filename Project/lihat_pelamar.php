<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: login.php");
    exit();
}
require 'koneksi.php';

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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .breadcrumb {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
        }
        .breadcrumb-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }
        .breadcrumb-content a {
            color: #fff;
            text-decoration: none;
            margin-right: 5px;
        }
        .breadcrumb-content span {
            margin-left: 5px;
        }
        .main-content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .applicant-section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        .document-cell a {
            color: #007bff;
            text-decoration: none;
        }
        .document-cell a:hover {
            text-decoration: underline;
        }
        .empty-state {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <nav class="breadcrumb">
        <div class="breadcrumb-content">
            <a href="dashboard_perusahaan.php">Home</a> / <span>Daftar Pelamar</span>
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

    <?php include 'footer.php'; ?>
</body>
</html>
