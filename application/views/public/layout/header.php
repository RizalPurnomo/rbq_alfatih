<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Rumah Belajar Quran (RBQ) Al Fatih'; ?></title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Rumah Belajar Quran (RBQ) Al Fatih - Lembaga pendidikan Al-Quran terstandar menggunakan Metode Ummi berjenjang dari Pra Ummi hingga Jilid 6.">
    <meta name="keywords" content="RBQ Al Fatih, Rumah Belajar Quran, Metode Ummi, Belajar Quran, TPQ, Tahfidz">
    <meta name="author" content="RBQ Al Fatih">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom Styling -->
    <style>
        :root {
            --primary-emerald: #0f766e;
            --primary-dark: #134e4a;
            --primary-light: #ccfbf1;
            --accent-gold: #d97706;
            --accent-gold-light: #fef3c7;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            background-color: #ffffff;
            overflow-x: hidden;
        }

        .navbar-rbq {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .navbar-brand-logo {
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--primary-dark) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand-logo i {
            color: var(--accent-gold);
            font-size: 1.6rem;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.95rem;
            color: #334155 !important;
            padding: 0.6rem 1rem !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-emerald) !important;
        }

        .btn-emerald {
            background-color: var(--primary-emerald);
            color: #ffffff;
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.55rem 1.4rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-emerald:hover {
            background-color: var(--primary-dark);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(15, 118, 110, 0.3);
            transform: translateY(-1px);
        }

        .btn-gold {
            background-color: var(--accent-gold);
            color: #ffffff;
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.55rem 1.4rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-gold:hover {
            background-color: #b45309;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(217, 119, 6, 0.3);
            transform: translateY(-1px);
        }

        .hero-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #e0f2fe 100%);
            padding: 80px 0 60px 0;
            position: relative;
        }

        .badge-ummi {
            background: var(--accent-gold-light);
            color: var(--accent-gold);
            font-weight: 700;
            border-radius: 9999px;
            padding: 6px 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
        }

        .jilid-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px 20px;
            background: #ffffff;
            transition: all 0.3s ease;
            height: 100%;
        }

        .jilid-card:hover {
            border-color: var(--primary-emerald);
            box-shadow: 0 10px 25px -5px rgba(15, 118, 110, 0.1);
            transform: translateY(-4px);
        }

        .footer-rbq {
            background-color: #0b1e1b;
            color: #94a3b8;
            padding: 60px 0 30px 0;
        }

        .footer-rbq a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-rbq a:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-rbq sticky-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-logo" href="<?= base_url(); ?>">
                <i class="fa-solid fa-book-quran"></i>
                <span>RBQ Al Fatih</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars-staggered text-emerald"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($active_menu) && $active_menu === 'home') ? 'active' : ''; ?>" href="<?= base_url(); ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($active_menu) && $active_menu === 'tentang') ? 'active' : ''; ?>" href="<?= base_url('tentang'); ?>">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($active_menu) && $active_menu === 'visi_misi') ? 'active' : ''; ?>" href="<?= base_url('visi-misi'); ?>">Visi & Misi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($active_menu) && $active_menu === 'pengajar') ? 'active' : ''; ?>" href="<?= base_url('pengajar'); ?>">Pengajar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($active_menu) && $active_menu === 'pendaftaran') ? 'active' : ''; ?>" href="<?= base_url('pendaftaran'); ?>">Pendaftaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($active_menu) && $active_menu === 'berita') ? 'active' : ''; ?>" href="<?= base_url('berita'); ?>">Event & Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($active_menu) && $active_menu === 'kontak') ? 'active' : ''; ?>" href="<?= base_url('kontak'); ?>">Kontak</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <a href="<?= base_url('login'); ?>" class="btn btn-emerald">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Login Aplikasi
                    </a>
                </div>
            </div>
        </div>
    </nav>
