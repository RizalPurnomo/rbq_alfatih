<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Dashboard - RBQ Al Fatih'; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-emerald: #0f766e;
            --primary-dark: #134e4a;
            --sidebar-bg: #0b1e1b;
            --sidebar-hover: #134e4a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            font-weight: 800;
            font-size: 1.2rem;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            padding: 20px 0;
            list-style: none;
            margin: 0;
        }

        .menu-header {
            padding: 10px 24px 5px 24px;
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #64748b;
        }

        .sidebar-link {
            padding: 10px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: #ffffff;
            background-color: var(--sidebar-hover);
            border-left: 4px solid #14b8a6;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
        }

        /* Main Content Area */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .top-navbar {
            background-color: #ffffff;
            padding: 14px 28px;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-body {
            padding: 28px;
            flex-grow: 1;
        }

        .card-custom {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            background: #ffffff;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Include -->
    <?php $this->load->view('layout/sidebar'); ?>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light border d-lg-none" type="button" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="d-none d-md-flex align-items-center gap-2">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill small">
                        <i class="fa-solid fa-calendar-check me-1"></i> TA: <?= isset($current_ta->nama) ? htmlspecialchars($current_ta->nama) : '2026/2027'; ?>
                    </span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill small">
                        Semester: <?= isset($current_semester->tipe) ? ucfirst(htmlspecialchars($current_semester->tipe)) : 'Ganjil'; ?>
                    </span>
                </div>
            </div>

            <!-- User Menu -->
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-bold text-dark small mb-0"><?= htmlspecialchars($this->session->userdata('nama')); ?></div>
                    <span class="badge <?php 
                        $r = $this->session->userdata('role');
                        if ($r === 'admin') echo 'bg-danger';
                        elseif ($r === 'keuangan') echo 'bg-warning text-dark';
                        else echo 'bg-success';
                    ?> text-uppercase" style="font-size: 0.65rem;">
                        <?= str_replace('_', ' ', htmlspecialchars($this->session->userdata('role'))); ?>
                    </span>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle p-2 border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-tie text-emerald fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                        <li class="dropdown-header">Login sebagai: <strong><?= htmlspecialchars($this->session->userdata('username')); ?></strong></li>
                        <li><a class="dropdown-item" href="<?= base_url(); ?>" target="_blank"><i class="fa-solid fa-globe me-2 text-muted"></i> Website Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content Body -->
        <main class="content-body">
            <!-- Flash Message Alerts -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 small mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 small mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
