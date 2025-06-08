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

// Ambil ID perusahaan dari user
$getPerusahaan = mysqli_query($conn, "SELECT * FROM perusahaan WHERE user_id = $userId");
$perusahaan = mysqli_fetch_assoc($getPerusahaan);
$perusahaanId = $perusahaan['id'];

// Validasi: apakah lowongan milik perusahaan ini?
$cek = mysqli_query($conn, "SELECT * FROM lowongan WHERE id = $lowonganId AND perusahaan_id = $perusahaanId");
$lowongan = mysqli_fetch_assoc($cek);

if (!$lowongan) {
    echo "Lowongan tidak ditemukan atau bukan milik Anda.";
    exit();
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $lokasi = $_POST['lokasi'];
    $jenis = $_POST['jenis_pekerjaan'];
    $level = $_POST['level_pekerjaan'];
    $pendidikan = $_POST['pendidikan'];
    $gaji = $_POST['gaji'];
    $deskripsi = $_POST['deskripsi'];
    $keahlian = $_POST['keahlian'];
    $kualifikasi = $_POST['kualifikasi'];

    $update = mysqli_query($conn, "UPDATE lowongan SET 
        judul = '$judul',
        lokasi = '$lokasi',
        jenis_pekerjaan = '$jenis',
        level_pekerjaan = '$level',
        pendidikan = '$pendidikan',
        gaji = '$gaji',
        deskripsi = '$deskripsi',
        keahlian = '$keahlian',
        kualifikasi = '$kualifikasi'
        WHERE id = $lowonganId AND perusahaan_id = $perusahaanId
    ");

    if ($update) {
        echo "<script>alert('✅ Lowongan berhasil diperbarui!'); window.location='../Dashboard/dashboard_perusahaan.php';</script>";
        exit();
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Lowongan</title>
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

<?php include '../partials/header.php'; ?>

<nav class="breadcrumb">
    <div class="breadcrumb-content">
        <a href="../Dashboard/dashboard_perusahaan.php">Home</a> / <span>Edit Lowongan</span>
    </div>
</nav>

<section id="apply">
    <h2>Edit Lowongan Pekerjaan</h2>
    <form method="POST">
        <label>Judul Posisi</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($lowongan['judul']) ?>" required>

        <label>Lokasi</label>
        <input type="text" name="lokasi" value="<?= htmlspecialchars($lowongan['lokasi']) ?>" required>

        <label>Jenis Pekerjaan</label>
        <select name="jenis_pekerjaan" required>
            <option <?= $lowongan['jenis_pekerjaan'] === '-- Jenis Pekerjaan --' ? 'selected' : '' ?>>-- Jenis Pekerjaan --</option>
            <option <?= $lowongan['jenis_pekerjaan'] === 'Full Time' ? 'selected' : '' ?>>Full Time</option>
            <option <?= $lowongan['jenis_pekerjaan'] === 'Part Time' ? 'selected' : '' ?>>Part Time</option>
            <option <?= $lowongan['jenis_pekerjaan'] === 'Kontrak' ? 'selected' : '' ?>>Kontrak</option>
            <option <?= $lowongan['jenis_pekerjaan'] === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
        </select>

        <label>Level Pekerjaan</label>
        <select name="level_pekerjaan" required>
            <option <?= $lowongan['level_pekerjaan'] === '-- Level Pekerjaan --' ? 'selected' : '' ?>>-- Level Pekerjaan --</option>
            <option <?= $lowongan['level_pekerjaan'] === 'Junior / Entry Level' ? 'selected' : '' ?>>Junior / Entry Level</option>
            <option <?= $lowongan['level_pekerjaan'] === 'Mid Level' ? 'selected' : '' ?>>Mid Level</option>
            <option <?= $lowongan['level_pekerjaan'] === 'Senior Level' ? 'selected' : '' ?>>Senior Level</option>
            <option <?= $lowongan['level_pekerjaan'] === 'Executive Level' ? 'selected' : '' ?>>Executive Level</option>
        </select>

        <label>Pendidikan Minimal</label>
        <input type="text" name="pendidikan" value="<?= htmlspecialchars($lowongan['pendidikan']) ?>" required>

        <label>Rentang Gaji</label>
        <input type="text" name="gaji" value="<?= htmlspecialchars($lowongan['gaji']) ?>" required>

        <label>Deskripsi Pekerjaan</label>
        <textarea name="deskripsi" rows="5" required><?= htmlspecialchars($lowongan['deskripsi']) ?></textarea>

        <label>Keahlian Dibutuhkan</label>
        <textarea name="keahlian" rows="4" required><?= htmlspecialchars($lowongan['keahlian']) ?></textarea>

        <label>Kualifikasi</label>
        <textarea name="kualifikasi" rows="4" required><?= htmlspecialchars($lowongan['kualifikasi']) ?></textarea>

        <button type="submit" class="tombol-lamaran">Update Lowongan</button>
    </form>
</section>

<?php include '../partials/footer.php'; ?>

</body>
</html>
