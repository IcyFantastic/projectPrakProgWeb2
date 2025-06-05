<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'pelamar') {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];
$lowonganId = $_GET['id'] ?? null;

if (!$lowonganId) {
    echo "ID lowongan tidak valid.";
    exit();
}

// Ambil id pelamar
$getPelamar = mysqli_query($conn, "SELECT * FROM pelamar WHERE user_id = $userId");
$pelamar = mysqli_fetch_assoc($getPelamar);
$pelamarId = $pelamar['id'];

// Cek jika sudah pernah melamar
$cek = mysqli_query($conn, "SELECT * FROM lamaran WHERE pelamar_id = $pelamarId AND lowongan_id = $lowonganId");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Anda sudah pernah melamar LOWONGAN ini'); window.location='detail_lowongan.php?id=$lowonganId';</script>";
    exit();
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $tgl = $_POST['tanggal_lahir'];
    $email = $_SESSION['email'];
    $nohp = $_POST['no_hp'];

    // Upload file
    $cv = $_FILES['cv'];
    $portofolio = $_FILES['portofolio'];
    $surat = $_FILES['surat'];

    function uploadFile($file, $folder) {
        if ($file['size'] > 0) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $namaFile = uniqid() . "." . $ext;
            $target = "uploads/$folder/" . $namaFile;
            move_uploaded_file($file['tmp_name'], $target);
            return $namaFile;
        }
        return null;
    }

    $cvName = uploadFile($cv, 'cv');
    $portoName = uploadFile($portofolio, 'portofolio');
    $suratName = uploadFile($surat, 'surat');

    // Insert lamaran ke DB
    $insert = mysqli_query($conn, "INSERT INTO lamaran (pelamar_id, lowongan_id, cv, portofolio, surat_lamaran) 
        VALUES ('$pelamarId', '$lowonganId', '$cvName', '$portoName', '$suratName')");

    if ($insert) {
        echo "<script>alert('✅ Berhasil Mengirim Lamaran'); window.location='dashboard_pelamar.php';</script>";
        exit();
    } else {
        echo "Gagal mengirim lamaran: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Lamaran</title>
    <link rel="stylesheet" href="StyleApply.css">
</head>
<body>

<?php include 'partials/header.php'; ?>

<section id="apply">
    <nav class="breadcrumb">
        <a href="dashboard_pelamar.php">Home</a> / <a href="#">Halaman Lamaran</a>
    </nav>

    <h2>Form Pengajuan Lamaran</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($pelamar['nama_lengkap']) ?>" required>

        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="<?= $pelamar['tanggal_lahir'] ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $_SESSION['email'] ?>" readonly>

        <label>Nomor HP</label>
        <input type="tel" name="no_hp" value="<?= htmlspecialchars($pelamar['no_hp']) ?>" required>

        <label>Unggah CV (PDF/DOCX)</label>
        <input type="file" name="cv" accept=".pdf,.doc,.docx" required>

        <label>Unggah Portofolio (Opsional)</label>
        <input type="file" name="portofolio" accept=".pdf">

        <label>Unggah Surat Lamaran (Opsional)</label>
        <input type="file" name="surat" accept=".pdf">

        <button type="submit" class="tombol-lamaran">Kirim Lamaran</button>
    </form>
</section>

<?php include 'partials/footer.php'; ?>

</body>
</html>
