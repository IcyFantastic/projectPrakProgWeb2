<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: login.php");
    exit();
}
require 'koneksi.php';

$userId = $_SESSION['id'];

// Ambil ID perusahaan
$getPerusahaan = mysqli_query($conn, "SELECT * FROM perusahaan WHERE user_id = $userId");
$perusahaan = mysqli_fetch_assoc($getPerusahaan);
$perusahaanId = $perusahaan['id'];

// Proses jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $lokasi = $_POST['lokasi'];
    $jenis = $_POST['jenis_pekerjaan'];
    $level = $_POST['level_pekerjaan'];
    $pendidikan = $_POST['pendidikan'];
    $gaji = $_POST['gaji'];
    $deskripsi = $_POST['deskripsi'];
    $keahlian = $_POST['keahlian'];
    $kualifikasi = $_POST['kualifikasi'];

    $insert = mysqli_query($conn, "INSERT INTO lowongan 
        (perusahaan_id, judul, lokasi, jenis_pekerjaan, level_pekerjaan, pendidikan, gaji, deskripsi, keahlian, kualifikasi, tanggal_posting) 
        VALUES ('$perusahaanId', '$judul', '$lokasi', '$jenis', '$level', '$pendidikan', '$gaji', '$deskripsi', '$keahlian', '$kualifikasi', CURDATE())");

    if ($insert) {
        echo "<script>alert('✅ Lowongan berhasil ditambahkan!'); window.location='dashboard_perusahaan.php';</script>";
        exit();
    } else {
        echo "Gagal menambahkan lowongan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Lowongan</title>
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
        #apply {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        #apply h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input, form select, form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form textarea {
            resize: none;
        }
        .tombol-lamaran {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .tombol-lamaran:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<nav class="breadcrumb">
    <div class="breadcrumb-content">
        <a href="dashboard_perusahaan.php">Home</a> / <span>Tambah Lowongan</span>
    </div>
</nav>

<section id="apply">
    <h2>Tambah Lowongan Pekerjaan</h2>
    <form method="POST">
        <label>Judul Posisi</label>
        <input type="text" name="judul" required>

        <label>Lokasi</label>
        <input type="text" name="lokasi" required>

        <label>Jenis Pekerjaan</label>
        <select name="jenis_pekerjaan" required>
            <option value="-- Jenis Pekerjaan --">-- Jenis Pekerjaan --</option>
            <option value="Full Time">Full Time</option>
            <option value="Part Time">Part Time</option>
            <option value="Kontrak">Kontrak</option>
            <option value="Freelance">Freelance</option>
        </select>

        <label>Level Pekerjaan</label>
        <select name="level_pekerjaan" required>
            <option value="-- Level Pekerjaan --">-- Level Pekerjaan --</option>
            <option value="Junior / Entry Level">Junior / Entry Level</option>
            <option value="Mid Level">Mid Level</option>
            <option value="Senior Level">Senior Level</option>
            <option value="Executive Level">Executive Level</option>
        </select>

        <label>Pendidikan Minimal</label>
        <input type="text" name="pendidikan" placeholder="Contoh: SMA / D3 / S1" required>

        <label>Rentang Gaji</label>
        <input type="text" name="gaji" placeholder="Contoh: 3 - 5 juta / Negosiasi" required>

        <label>Deskripsi Pekerjaan</label>
        <textarea name="deskripsi" rows="5" required></textarea>

        <label>Keahlian Dibutuhkan</label>
        <textarea name="keahlian" rows="4" required></textarea>

        <label>Kualifikasi</label>
        <textarea name="kualifikasi" rows="4" required></textarea>

        <button type="submit" class="tombol-lamaran">Simpan Lowongan</button>
    </form>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
