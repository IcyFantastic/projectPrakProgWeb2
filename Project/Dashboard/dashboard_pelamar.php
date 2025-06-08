<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'pelamar') {
    header("Location: ../Login/login.php");
    exit();
}
require '../koneksi.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelamar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        /* Header styles from login.css */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: fixed;
            width: 100%;
            z-index: 1000;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Main content styles */
        .main-content {
            padding: 6rem 2rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-container {
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: fadeInUp 1s ease-out;
        }

        /* Search section */
        .search-section {
            padding: 3rem 2rem;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: var(--white);
        }

        .search-section h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .search-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .search-form {
            max-width: 700px;
            margin: 0 auto;
        }

        .search-input-group {
            display: flex;
            gap: 1rem;
            background: var(--white);
            padding: 0.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
        }

        .search-input-group input {
            flex: 1;
            padding: 1rem;
            border: none;
            font-size: 1rem;
            border-radius: 8px;
        }

        .search-button {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* Jobs section */
        .jobs-section {
            padding: 2rem;
        }

        .jobs-section h2 {
            color: var(--text-primary);
            margin-bottom: 2rem;
        }

        .job-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .job-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            text-decoration: none;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .job-card-header {
            margin-bottom: 1rem;
        }

        .company-name {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .job-title {
            color: var(--text-primary);
            font-size: 1.1rem;
            margin: 0;
        }

        .job-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .tag {
            background: var(--secondary-color);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .job-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* Footer */
        footer {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 1.5rem;
            text-align: center;
            color: var(--text-secondary);
            margin-top: 2rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .header-content {
                padding: 1rem;
            }

            .main-content {
                padding: 5rem 1rem 1rem;
            }

            .search-input-group {
                flex-direction: column;
            }

            .search-button {
                width: 100%;
                padding: 1rem;
            }

            .job-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include '../partials/header.php'; ?>

    <main class="main-content">
        <div class="dashboard-container">
            <section class="search-section">
                <h1>Temukan Pekerjaan Impianmu</h1>
                <p class="search-subtitle">Jelajahi ribuan lowongan kerja sesuai dengan keahlianmu</p>
                <form method="GET" action="" class="search-form">
                    <div class="search-input-group">
                        <i class="fas fa-search input-icon"></i>
                        <input type="text" name="search" 
                               placeholder="Cari berdasarkan posisi, perusahaan, atau lokasi" 
                               value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="search-button">
                            Cari Pekerjaan
                        </button>
                    </div>
                </form>
            </section>

            <section class="jobs-section">
                <h2>Lowongan Tersedia</h2>
                <div class="job-grid">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <a href="../Detail/detail_lowongan.php?id=<?= $row['id'] ?>" class="job-card">
                            <div class="job-card-header">
                                <h3 class="company-name">
                                    <i class="fas fa-building"></i>
                                    <?= htmlspecialchars($row['nama_perusahaan']) ?>
                                </h3>
                                <h4 class="job-title"><?= htmlspecialchars($row['judul']) ?></h4>
                            </div>
                            <div class="job-card-body">
                                <p class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($row['lokasi']) ?>
                                </p>
                                <div class="job-tags">
                                    <span class="tag"><?= $row['jenis_pekerjaan'] ?></span>
                                    <span class="tag"><?= $row['pendidikan'] ?></span>
                                    <span class="tag"><?= $row['level_pekerjaan'] ?></span>
                                </div>
                            </div>
                            <div class="job-card-footer">
                                <p class="salary">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <?= htmlspecialchars($row['gaji']) ?>
                                </p>
                                <p class="posted-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?= $row['tanggal_posting'] ?>
                                </p>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>
            </section>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?>
</body>
</html>