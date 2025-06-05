-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Bulan Mei 2025 pada 12.40
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `infoloker`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `lamaran`
--

CREATE TABLE `lamaran` (
  `id` int(11) NOT NULL,
  `pelamar_id` int(11) DEFAULT NULL,
  `lowongan_id` int(11) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `portofolio` varchar(255) DEFAULT NULL,
  `surat_lamaran` varchar(255) DEFAULT NULL,
  `waktu_lamaran` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lowongan`
--

CREATE TABLE `lowongan` (
  `id` int(11) NOT NULL,
  `perusahaan_id` int(11) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `jenis_pekerjaan` varchar(50) DEFAULT NULL,
  `level_pekerjaan` varchar(50) DEFAULT NULL,
  `pendidikan` varchar(100) DEFAULT NULL,
  `gaji` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `keahlian` text DEFAULT NULL,
  `kualifikasi` text DEFAULT NULL,
  `tanggal_posting` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lowongan`
--

INSERT INTO `lowongan` (`id`, `perusahaan_id`, `judul`, `lokasi`, `jenis_pekerjaan`, `level_pekerjaan`, `pendidikan`, `gaji`, `deskripsi`, `keahlian`, `kualifikasi`, `tanggal_posting`) VALUES
(1, 1, 'Part Time Jaga Stand', 'Kota Bandung', 'Part Time', 'Entry Level', 'SMA / SMK', 'Kompetitif', 
'- Goreng Cireng\n- Melayani Konsumen dgn Baik\n- Mencatat Laporan Penjualan\n- Set Up Booth Ditempat', 
'- Kemampuan komunikasi\n- Kemampuan menggoreng', 
'- Pria, diutamakan sekitar jam 4 sore waktunya kosong\n- Usia min. 18th\n- Memiliki Kendaraan & Memiliki SIM C', 
'2025-05-22'),

(2, 2, 'Freelance Event Organizer', 'Jakarta Selatan', 'Freelance', 'Junior / Entry Level', 'Diploma/D1/D2/D3, SMA / SMK / STM', 'Negosiasi', 
'Menyiapkan event mulai dari ide, persiapan, hingga eksekusi event', 
'- Bisa dekorasi Bunga\n- Bisa dekorasi Balon\n- Bisa handle event mulai dari ide, persiapan, hingga eksekusi event', 
'- Pria/Wanita\n- Fresh graduate silahkan melamar', 
'2025-05-22'),

(3, 3, 'Project Manager', 'Bogor', 'Full Time', 'Manager / Assistant Manager', 'Sarjana / S1', 'Rp 4.000.000,00 - Rp 5.000.000,00', 
'- Merencanakan dan mengawasi jalannya proyek\n- Memantau progres proyek\n- Berkomunikasi dengan klien\n- Membuat estimasi anggaran instalasi (BoQ)', 
'- Kemampuan membaca gambar kerja, RAP, dan RAB\n- Penguasaan perangkat lunak seperti Microsoft Office, AutoCAD\n- Keterampilan komunikasi dan koordinasi', 
'- Pendidikan minimal SMA/SMK atau D3, diutamakan jurusan Teknik Sipil, Teknik Arsitektur\n- Berpengalaman 3-4 Tahun\n- Bersedia bekerja di kantor Bogor dan lokasi proyek', 
'2025-05-22');


-- --------------------------------------------------------

--
-- Struktur dari tabel `pelamar`
--

CREATE TABLE `pelamar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelamar`
--

INSERT INTO `pelamar` (`id`, `user_id`, `nama_lengkap`, `tanggal_lahir`, `no_hp`) VALUES
(1, 1, 'Budi Santoso', '2000-01-15', '081234567890'),
(2, 2, 'Siti Rahma', '1999-06-25', '081298765432');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_perusahaan` varchar(100) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `user_id`, `nama_perusahaan`, `lokasi`, `logo`) VALUES
(1, 1, 'PT. Mitra Makmur Sahabat', 'Jakarta Barat', 'PT._Mitra_Makmur_Sahabat.jpg'),
(2, 2, 'Warung Nasi Indonesia', 'Jakarta Selatan', 'Warung_Makan_Indonesia.png');
(3, 3, 'Cireng Napoleon', 'Kiara Condong & Batununggal', 'Cireng_Napoleon.png'),
(4, 4, 'Jakarta Surprise Planner', 'Tanggerang', 'Jakarta_Surprise_Planner.jpg'),
(5, 5, 'PT. AgriFam', 'Bogor', 'PT._AgriFam.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('pelamar','perusahaan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'PTMakmur', 'adminmakmur', 'perusahaan'),
(2, 'WarungNasi', 'adminwarung', 'perusahaan'),
(3, 'CirengNapoleon', 'admincireng', 'perusahaan'),
(4, 'JakartaSurprise', 'adminsurprise', 'perusahaan'),
(5, 'PTAgriFam', 'adminagri', 'perusahaan');
(6, 'Hansel', 'Hansel', 'pelamar'),
(7, 'Darryl', 'Darryl', 'pelamar');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pelamar_id` (`pelamar_id`,`lowongan_id`),
  ADD KEY `lowongan_id` (`lowongan_id`);

--
-- Indeks untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perusahaan_id` (`perusahaan_id`);

--
-- Indeks untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `lamaran_ibfk_1` FOREIGN KEY (`pelamar_id`) REFERENCES `pelamar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lamaran_ibfk_2` FOREIGN KEY (`lowongan_id`) REFERENCES `lowongan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  ADD CONSTRAINT `lowongan_ibfk_1` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  ADD CONSTRAINT `pelamar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD CONSTRAINT `perusahaan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
