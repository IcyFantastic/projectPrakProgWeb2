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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #5856eb;
            --secondary-color: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --white: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Form Section */
        #apply {
            max-width: 800px;
            margin: 6rem auto;
            padding: 2rem;
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
        }

        #apply h2 {
            color: var(--text-primary);
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.8rem;
        }

        /* Form Elements */
        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        form label {
            color: var(--text-primary);
            font-weight: 500;
            font-size: 1rem;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="tel"],
        form input[type="date"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            color: var(--text-primary);
            transition: border-color 0.3s ease;
        }

        form input[type="file"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            background: var(--secondary-color);
        }

        /* File Upload Group Styling */
        .file-upload-group {
            background: var(--secondary-color);
            padding: 2rem;
            border-radius: 12px;
            margin: 2.5rem 0;
            box-shadow: var(--shadow);
        }

        .file-upload-group .form-group {
            margin-bottom: 2rem;
        }

        .file-upload-group .form-group:last-child {
            margin-bottom: 0;
        }

        .file-upload-group label {
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .file-upload-group input[type="file"] {
            background: var(--white);
            border: 1px dashed var(--border-color);
            padding: 1rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .file-upload-group input[type="file"]:hover {
            border-color: var(--primary-color);
            background: rgba(99, 102, 241, 0.05);
        }

        .file-upload-group small {
            display: block;
            color: var(--text-secondary);
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        /* Form Group Styling */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group input[type="date"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input[type="file"] {
            background: var(--secondary-color);
            border-style: dashed;
        }

        .form-group input[type="file"]:hover {
            border-color: var(--primary-color);
            background: rgba(99, 102, 241, 0.05);
        }

        .form-group small {
            display: block;
            color: var(--text-secondary);
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        /* Button Styles */
        .tombol-lamaran {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.875rem 2.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .tombol-lamaran:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .tombol-batal {
            background: var(--text-secondary);
        }

        .tombol-batal:hover {
            background: #4b5563;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 2rem;
            margin-bottom: 2rem;
        }

        .breadcrumb a {
            color: var(--white);
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .breadcrumb span {
            color: var(--white);
            opacity: 0.6;
        }

        .breadcrumb a:hover {
            opacity: 1;
        }

        /* Success Message */
        #pesanSukses:target {
            background: #dcfce7;
            color: #166534;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            text-align: center;
            font-weight: 500;
        }

        /* Form Actions Styling */
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #apply {
                margin: 2rem;
                padding: 1.5rem;
            }

            .breadcrumb {
                padding: 0.75rem 1rem;
            }

            form input[type="file"] {
                padding: 0.5rem;
            }

            .file-upload-group {
                padding: 1.5rem;
                margin: 2rem 0;
            }

            .form-actions {
                flex-direction: column;
                margin-top: 2rem;
            }

            .tombol-lamaran,
            .tombol-batal {
                width: 100%;
                text-align: center;
            }
        }
    </style>
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
