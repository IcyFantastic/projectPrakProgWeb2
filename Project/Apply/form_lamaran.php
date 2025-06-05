<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pelamar') {
    header("Location: ../Login/login.php");
    exit();
}
require '../koneksi.php';

$userId = $_SESSION['id'];
$lowonganId = $_GET['id'] ?? null;

if (!$lowonganId) {
    echo "<script>alert('ID lowongan tidak valid.'); window.location='../Dashboard/dashboard_pelamar.php';</script>";
    exit();
}

// Get existing pelamar data if available
$getPelamar = mysqli_query($conn, "SELECT * FROM pelamar WHERE user_id = '$userId'");
$pelamar = mysqli_fetch_assoc($getPelamar);

// Check if already applied
if ($pelamar) {
    $pelamarId = $pelamar['id'];
    $cekQuery = "SELECT * FROM lamaran WHERE pelamar_id = ? AND lowongan_id = ?";
    $stmt = mysqli_prepare($conn, $cekQuery);
    mysqli_stmt_bind_param($stmt, "ii", $pelamarId, $lowonganId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Anda sudah pernah melamar lowongan ini'); window.location='../Detail/detail_lowongan.php?id=$lowonganId';</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $tgl = $_POST['tanggal_lahir'];
    $email = $_POST['email'];  // Get email from form input
    $nohp = $_POST['no_hp'];

    // Upload files
    function uploadFile($file, $folder) {
        if ($file['size'] > 0) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $namaFile = uniqid() . "." . $ext;
            $target = "uploads/$folder/" . $namaFile;
            
            // Create directory if not exists
            if (!is_dir("uploads/$folder")) {
                mkdir("uploads/$folder", 0777, true);
            }
            
            move_uploaded_file($file['tmp_name'], $target);
            return $namaFile;
        }
        return null;
    }

    $cvName = uploadFile($_FILES['cv'], 'cv');
    $portoName = uploadFile($_FILES['portofolio'], 'portofolio');
    $suratName = uploadFile($_FILES['surat'], 'surat');

    // Start transaction
    mysqli_begin_transaction($conn);
    try {
        // Insert or update pelamar data
        if (!$pelamar) {
            $insertPelamar = mysqli_query($conn, "INSERT INTO pelamar (user_id, nama_lengkap, tanggal_lahir, no_hp, email) 
                VALUES ('$userId', '$nama', '$tgl', '$nohp', '$email')");
            $pelamarId = mysqli_insert_id($conn);
        } else {
            $pelamarId = $pelamar['id'];
            $updatePelamar = mysqli_query($conn, "UPDATE pelamar SET 
                nama_lengkap = '$nama',
                tanggal_lahir = '$tgl',
                no_hp = '$nohp',
                email = '$email'
                WHERE id = $pelamarId");
        }

        // Insert lamaran
        $insertLamaran = mysqli_query($conn, "INSERT INTO lamaran (pelamar_id, lowongan_id, cv, portofolio, surat_lamaran) 
            VALUES ('$pelamarId', '$lowonganId', '$cvName', '$portoName', '$suratName')");

        if ($insertLamaran) {
            mysqli_commit($conn);
            echo "<script>alert('✅ Berhasil Mengirim Lamaran'); window.location='../Dashboard/dashboard_pelamar.php';</script>";
            exit();
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Lamaran</title>
    <link rel="stylesheet" href="lamaran.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <nav class="breadcrumb">
        <div class="breadcrumb-content">
            <a href="../Dashboard/dashboard_pelamar.php">Home</a> / <span>Form Lamaran</span>
        </div>
    </nav>

    <div class="main-content">
        <section id="apply">
            <h2 class="section-title">Form Pengajuan Lamaran</h2>

            <div class="form-container">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" 
                               value="<?= htmlspecialchars($pelamar['nama_lengkap'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" 
                               value="<?= $pelamar['tanggal_lahir'] ?? '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" 
                               value="<?= htmlspecialchars($pelamar['email'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input type="tel" id="no_hp" name="no_hp" 
                               value="<?= htmlspecialchars($pelamar['no_hp'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="cv">Unggah CV (PDF/DOCX)</label>
                        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                        <small>Format yang didukung: PDF, DOC, DOCX</small>
                    </div>

                    <div class="form-group">
                        <label for="portofolio">Unggah Portofolio (Opsional)</label>
                        <input type="file" id="portofolio" name="portofolio" accept=".pdf">
                        <small>Format yang didukung: PDF</small>
                    </div>

                    <div class="form-group">
                        <label for="surat">Unggah Surat Lamaran (Opsional)</label>
                        <input type="file" id="surat" name="surat" accept=".pdf">
                        <small>Format yang didukung: PDF</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="tombol-lamaran">Kirim Lamaran</button>
                        <button type="button" class="tombol-lamaran tombol-batal" 
                                onclick="window.location.href='../Dashboard/dashboard_pelamar.php'">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
