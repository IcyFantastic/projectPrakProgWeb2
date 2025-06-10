# 🚀 Aplikasi Portal Lowongan Kerja

## 📋 Ringkasan
Aplikasi portal lowongan kerja modern yang menghubungkan pencari kerja dengan perusahaan, dibangun menggunakan PHP dan MySQL. Fitur lengkap dengan dashboard intuitif untuk perusahaan dan pencari kerja! ✨

## 🎯 Fitur

### 💼 Untuk Perusahaan
- 🔐 Sistem autentikasi yang aman
- 📊 Dashboard perusahaan yang dinamis
- ➕ Tambah lowongan pekerjaan baru
- 📝 Edit lowongan pekerjaan yang ada
- 👥 Lihat dan kelola pelamar
- 🏢 Manajemen profil perusahaan
- 📑 Sistem review dokumen pelamar

### 👤 Untuk Pencari Kerja
- 🔑 Sistem autentikasi pengguna
- 🎯 Dashboard yang dipersonalisasi
- 🔍 Pencarian lowongan kerja yang canggih
- 📨 Lamar pekerjaan dengan satu klik
- 📤 Manajemen dokumen lamaran
- 📈 Pelacakan status lamaran

## 🛠️ Teknologi yang Digunakan
- 🎨 **Frontend:** HTML5, CSS3, JavaScript
- ⚙️ **Backend:** PHP
- 💾 **Database:** MySQL
- 🖥️ **Server:** XAMPP

## 📁 Struktur Project
```
projectPrakProgWeb2/
├── 📂 Project/
│   ├── 📂 css/
│   │   ├── login.css
│   │   ├── detail.css
│   │   ├── dashboard_pelamar.css
│   │   ├── dashboard_perusahaan.css
│   │   ├── lamaran.css
│   │   ├── lowongan.css
│   │   ├── pelamar.css
│   │   ├── register.css
│   │   ├── reset-password.css
│   │   └── tambahan.css
│   ├── 📂 js/
│   │   ├── login.js
│   │   └── register.js
│   ├── 📂 Gambar/
│   │   └── 
│   ├── 📂 SQL/
│   │   └── progweb.sql
│   dashboard_pelamar.php
│   dashboard_perusahaan.php
│   dashboard_awal.php
│   login.php
│   register.php
│   reset-password.php
│   logout.php
│   about.php
│   vision.php
│   contact.php
│   detail_lowongan.php
│   tambah_lowongan.php
│   edit_lowongan.php
│   lihat_pelamar.php
│   header.php
│   footer.php
│   koneksi.php
└── 📝 README.md
```

## ⚡ Panduan Instalasi

### Prasyarat
- 🖥️ XAMPP terinstal
- 🌐 Browser web
- 📝 Editor teks (disarankan VS Code)

### Langkah-langkah
1. 📥 **Instal XAMPP**
   - Jalankan layanan Apache dan MySQL.

2. 📋 **Clone Repository**
   ```bash
   git clone [repository-url] C:\xampp\htdocs\projectPrakProgWeb2
   ```

3. 💾 **Setup Database**
   - Buka phpMyAdmin.
   - Buat database baru.
   - Import file `SQL/progweb.sql`.

4. ⚙️ **Konfigurasi Koneksi**
   Edit file `koneksi.php`:
   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";
   $db = "progweb";
   ```

5. 🌐 **Akses Aplikasi**
   Buka URL berikut di browser:
   ```
   http://localhost/projectPrakProgWeb2/
   ```

   Atau
   ```
   miniproject.local
   ```

## 📱 Fitur Utama

### Untuk Perusahaan 🏢
1. **Manajemen Lowongan**
   - Tambah lowongan pekerjaan.
   - Edit lowongan yang ada.
   - Hapus lowongan (jika belum ada pelamar).

2. **Pelacakan Pelamar**
   - Lihat profil pelamar.
   - Unduh dokumen pelamar.
   - Pantau status lamaran.

### Untuk Pencari Kerja 👤
1. **Manajemen Profil**
   - Buat dan edit profil.
   - Unggah dokumen lamaran.
   - Pantau status lamaran.

2. **Pencarian Lowongan**
   - Filter berdasarkan kategori.
   - Cari berdasarkan lokasi.
   - Lamar pekerjaan dengan cepat.

## 🔧 Pengembangan

### Menjalankan Secara Lokal
```bash
# Jalankan XAMPP
# Navigasi ke folder project
cd C:\xampp\htdocs\projectPrakProgWeb2
```

## 👥 Kontributor
- 👨‍💻 Laurensius Rio Darryl [71231022]
- 👩‍💻 Hansel Ivano Supratman [71231039]

## 🤝 Dukungan
- 📧 Email: support@example.com
- 💬 Masalah: GitHub Issues
- 📚 Dokumentasi: [Wiki Project]

## 🔄 Riwayat Versi
- 🆕 v1.0.0 - Rilis Awal
- 📅 Terakhir Diperbarui: 11 Juni 2025

---
Dibuat dengan ❤️ oleh [Kelompok 8]

### 🌟 Star us on GitHub if this project helps you!
