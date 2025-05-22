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
-- Database: `projectprogweb`
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
(1, 1, 'Staff Admin', 'Jakarta Barat', 'Full Time', 'Junior / Entry Level', 'SMA / SMK / STM, Diploma/D1/D2/D3, Sarjana / S1', 'Negosiasi', 'Melakukan pengawasan implementasi sistem operasional dari segi administratif...', 'Komunikatif, bisa Microsoft Office', 'Lulusan SMA/D3/S1, pengalaman 1 tahun', '2025-05-20'),
(2, 1, 'Staff Finance', 'Jakarta Barat', 'Full Time', 'Junior / Entry Level', 'Diploma/D3, Sarjana', 'Negosiasi', 'Mengelola keuangan dan transaksi keluar masuk perusahaan...', 'Mampu mengoperasikan Excel, ketelitian tinggi', 'Lulusan Akuntansi, minimal 1 tahun pengalaman', '2025-05-20'),
(3, 2, 'Fulltime Cook/Bar/Cashier', 'Jakarta Selatan', 'Full Time', 'Junior / Entry Level', 'SMA / SMK', 'Negosiasi', 'Melayani konsumen dan memasak sesuai SOP...', 'Memiliki basic cooking skill, bisa prepare & bersih dapur', 'Usia 17+, pengalaman 1 tahun atau jurusan Tata Boga', '2025-05-20'),
(4, 2, 'Kasir & Pelayanan Pelanggan', 'Jakarta Selatan', 'Part Time', 'Entry Level', 'SMA / SMK', 'Negosiasi', 'Menjalankan kasir dan bantu pelayanan customer...', 'Ramah, jujur, dan bertanggung jawab', 'Usia 18+, mampu kerja shift', '2025-05-20');

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
(1, 3, 'Budi Santoso', '2000-01-15', '081234567890'),
(2, 4, 'Siti Rahma', '1999-06-25', '081298765432');

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
(1, 1, 'PT. Mitra Makmur Sahabat', 'Jakarta Barat', 'PT. Mitra Makmur Sahabat.jpg'),
(2, 2, 'Warung Nasi Indonesia', 'Jakarta Selatan', 'Warung Makan Indonesia.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pelamar','perusahaan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`) VALUES
(1, 'ptmakmur@gmail.com', '819b0643d6b89dc9b579fdfc9094f28e', 'perusahaan'),
(2, 'warungnasi@gmail.com', '34cc93ece0ba9e3f6f235d4af979b16c', 'perusahaan'),
(3, 'pelamar1@gmail.com', '7c6a180b36896a0a8c02787eeafb0e4c', 'pelamar'),
(4, 'pelamar2@gmail.com', '6cb75f652a9b52798eb6cf2201057c73', 'pelamar');

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
  ADD UNIQUE KEY `email` (`email`);

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
