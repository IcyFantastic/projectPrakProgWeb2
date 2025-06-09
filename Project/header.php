<?php 
if (session_status() === PHP_SESSION_NONE) session_start(); 

// Definisikan base URL
$baseUrl = '/projectPrakProgWeb2/Project';
?>

<header>
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">IL</div>
                <div class="logo-text">InfoLoker</div>
            </div>
            <nav class="nav-links">
                <a href="<?= $baseUrl ?>login.php">Home</a>
                <a href="<?= $baseUrl ?>about.php">Tentang</a>
                <a href="<?= $baseUrl ?>vision.php">Visi & Misi</a>
                <a href="<?= $baseUrl ?>contact.php">Contact</a>
            </nav>
        </div>
    </header>

<style>
    /* Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 100;
            animation: slideDown 0.8s ease-out;
            transition: all 0.3s ease;
        }

        header:hover {
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes slideDown {
            0% { transform: translateY(-100%); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .logo:hover {
            transform: rotate(5deg) scale(1.05);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .logo-text:hover {
            transform: translateY(-1px);
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
            border-radius: 25px;
            opacity: 0;
            transition: all 0.4s ease;
            z-index: -1;
        }

        .nav-links a:hover {
            color: #ffffff;
            transform: translateY(-3px) scale(1.05);
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .nav-links a:hover::before {
            opacity: 1;
            transform: scale(1.1);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #ffffff, rgba(255, 255, 255, 0.5));
            border-radius: 2px;
            transition: all 0.4s ease;
            transform: translateX(-50%);
        }

        .nav-links a:hover::after {
            width: 100%;
            box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);
        }

        .nav-links a:active {
            transform: translateY(-1px) scale(1.02);
        }
</style>
