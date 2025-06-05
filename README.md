# 🚀 Job Portal Web Application

## 📋 Overview
A modern job portal application connecting job seekers with companies, built with PHP and MySQL. Features intuitive dashboards for companies and job seekers! ✨

## 🎯 Features

### 💼 For Companies
- 🔐 Secure authentication system
- 📊 Dynamic company dashboard
- ➕ Post new job listings
- 📝 Edit existing job listings
- 👥 View and manage applicants
- 🏢 Company profile management
- 📑 Document review system

### 👤 For Job Seekers
- 🔑 User authentication
- 🎯 Personalized dashboard
- 🔍 Advanced job search
- 📨 One-click job applications
- 📤 Document management
- 📈 Application tracking

## 🛠️ Technical Stack
- 🎨 **Frontend:** HTML5, CSS3, JavaScript
- ⚙️ **Backend:** PHP
- 💾 **Database:** MySQL
- 🖥️ **Server:** XAMPP

## 📁 Project Structure
```
projectPrakProgWeb2/
├── 📂 Project/
│   ├── 📊 Dashboard/
│   │   ├── dashboard_pelamar.php
│   │   └── dashboard_perusahaan.php
│   ├── 🔐 Halaman_Login/
│   │   ├── login.php
│   │   └── register.php
│   ├── 🏠 Halaman_Utama/
│   │   ├── index.php
│   │   └── home.php
│   ├── 📑 pages/
│   │   ├── lihat_pelamar.php
│   │   └── apply_job.php
│   ├── 🧩 partials/
│   │   ├── header.php
│   │   └── footer.php
│   └── 🔌 koneksi.php
└── 📝 README.md
```

## ⚡ Installation Guide

### Prerequisites
- 🖥️ XAMPP installed
- 🌐 Web browser
- 📝 Text editor (VS Code recommended)

### Steps
1. 📥 **Install XAMPP**
   ```bash
   # Start Apache and MySQL services
   ```

2. 📋 **Clone Repository**
   ```bash
   git clone [repository-url] C:\xampp\htdocs\projectPrakProgWeb2
   ```

3. 💾 **Database Setup**
   - Open phpMyAdmin
   - Create new database
   - Import schema from `database.sql`

4. ⚙️ **Configure Connection**
   Edit `koneksi.php`:
   ```php
   $host = "localhost";
   $username = "your_username";
   $password = "your_password";
   $database = "your_database_name";
   ```

5. 🌐 **Access Application**
   ```
   http://localhost/projectPrakProgWeb2/
   ```

## 📱 Key Features

### For Companies 🏢
1. **Job Management**
   - Create job listings
   - Edit postings
   - Review applications

2. **Applicant Tracking**
   - View candidate profiles
   - Download resumes
   - Track application status

### For Job Seekers 👤
1. **Profile Management**
   - Create/edit profile
   - Upload documents
   - Track applications

2. **Job Search**
   - Filter by category
   - Search by location
   - Quick apply feature

## 🔧 Development

### Running Locally
```bash
# Start XAMPP
# Navigate to project folder
cd C:\xampp\htdocs\projectPrakProgWeb2
```

### Database Updates
```sql
-- Create tables
CREATE TABLE users...
```

## 👥 Contributors
- 👨‍💻 Laurensius Rio Darryl [71231022]
- 👩‍💻 Hansel Ivano Supratman[71231039]

## 📄 License
MIT License © [2025] [Project Praktikum ProgWeb UKDW]

## 🤝 Support
- 📧 Email: support@example.com
- 💬 Issues: GitHub Issues
- 📚 Wiki: [Project Wiki]

## 🔄 Version History
- 🆕 v1.0.0 - Initial Release
- 📅 Last Updated: [06 Juni 2025]

---
Made with ❤️ by [Kelompok 8]

### 🌟 Star us on GitHub if this project helps you!
