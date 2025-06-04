<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: login.php");
    exit();
}

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
    SELECT lamaran.*, pelamar.nama_lengkap, pelamar.tanggal_lahir, pelamar.no_hp, users.email
    FROM lamaran
    JOIN pelamar ON lamaran.pelamar_id = pelamar.id
    JOIN users ON pelamar.user_id = users.id
    WHERE lamaran.lowongan_id = $lowonganId
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pelamar - <?= htmlspecialchars($lowongan['judul']) ?></title>
    <link rel="stylesheet" href="UtamaPerusahaan.css">
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td a {
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php include 'partials/header.php'; ?>

<nav class="breadcrumb">
    <a href="dashboard_perusahaan.php">Dashboard</a> / 
    <a href="#">Daftar Pelamar</a>
</nav>

<h1 class="lowongan-tanda">Pelamar untuk: <?= htmlspecialchars($lowongan['judul']) ?></h1>

<?php if (mysqli_num_rows($pelamarQuery) > 0): ?>
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
                <td>
                    <?php if ($p['cv']): ?>
                        <a href="uploads/cv/<?= $p['cv'] ?>" target="_blank">Lihat</a>
                    <?php else: ?>-<?php endif; ?>
                </td>
                <td>
                    <?php if ($p['portofolio']): ?>
                        <a href="uploads/portofolio/<?= $p['portofolio'] ?>" target="_blank">Lihat</a>
                    <?php else: ?>-<?php endif; ?>
                </td>
                <td>
                    <?php if ($p['surat_lamaran']): ?>
                        <a href="uploads/surat/<?= $p['surat_lamaran'] ?>" target="_blank">Lihat</a>
                    <?php else: ?>-<?php endif; ?>
                </td>
                <td><?= $p['waktu_lamaran'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align: center; margin-top: 50px; color: gray;">Belum ada pelamar untuk lowongan ini.</p>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>

</body>
</html>
