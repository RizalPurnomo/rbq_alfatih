<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Login - RBQ Al Fatih'; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-emerald: #0f766e;
            --primary-dark: #134e4a;
            --accent-gold: #d97706;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #042f2e 0%, #0f766e 50%, #115e59 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            background: #f8fafc;
            padding: 35px 30px 20px 30px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .login-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-emerald);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }

        .btn-emerald {
            background-color: var(--primary-emerald);
            color: #ffffff;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            border: none;
            transition: all 0.3s;
        }

        .btn-emerald:hover {
            background-color: var(--primary-dark);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.4);
        }

        .demo-badge {
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.8rem;
        }

        .demo-badge:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <a href="<?= base_url(); ?>" class="text-decoration-none d-inline-flex align-items-center gap-2 mb-2 text-dark">
                <i class="fa-solid fa-book-quran fa-2x text-warning"></i>
                <span class="fs-4 fw-bold">RBQ Al Fatih</span>
            </a>
            <p class="text-muted small mb-0">Masuk ke Portal Manajemen Rumah Belajar Quran</p>
        </div>

        <div class="login-body">
            <!-- Flash Notification -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 small mb-3" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 small mb-3" role="alert">
                    <i class="fa-solid fa-circle-check me-1"></i> <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login'); ?>" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label small fw-bold text-dark">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" id="username" name="username" placeholder="Masukkan username" value="<?= set_value('username'); ?>" required autofocus>
                    </div>
                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label small fw-bold text-dark">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="fa-solid fa-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <button type="submit" class="btn btn-emerald mb-3">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Sekarang
                </button>
            </form>

            <!-- Quick Demo Accounts Helper -->
            <div class="mt-4 pt-3 border-top">
                <small class="text-muted d-block fw-semibold mb-2 text-center">Akun Demo (Klik untuk Isi Cepat):</small>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-dark demo-badge rounded-pill" onclick="fillLogin('admin', 'admin123')">
                        <i class="fa-solid fa-shield-halved me-1 text-danger"></i> Admin
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark demo-badge rounded-pill" onclick="fillLogin('keuangan', 'keuangan123')">
                        <i class="fa-solid fa-coins me-1 text-warning"></i> Keuangan
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark demo-badge rounded-pill" onclick="fillLogin('ustadz_ahmad', 'ustadz123')">
                        <i class="fa-solid fa-chalkboard-user me-1 text-success"></i> Wali Kelas
                    </button>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?= base_url(); ?>" class="text-decoration-none small text-muted hover-underline">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Website Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Script helper demo login -->
    <script>
        function fillLogin(user, pass) {
            document.getElementById('username').value = user;
            document.getElementById('password').value = pass;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
