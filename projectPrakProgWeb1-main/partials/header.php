<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<header>
    <img src="Gambar/Adobe Express - file.png" alt="Logo" class="logo">
    <h2 class="logonama">InfoLoker</h2>
    <nav class="navigasi">
        <a href="dashboard_pelamar.php">Home</a>
        <a href="#">Tentang</a>
        <a href="#">Visi & Misi</a>
        <a href="#">Contact</a>
        <button class="tombolLogin" onclick="window.location.href='logout.php'">Logout</button>
    </nav>
</header>
