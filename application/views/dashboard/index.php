<?php
$role = $this->session->userdata('role');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            Assalamu'alaikum, <?= htmlspecialchars($this->session->userdata('nama')); ?> 👋
        </h3>
        <p class="text-muted small mb-0">Selamat datang di Panel Manajemen RBQ Al Fatih - Metode Ummi.</p>
    </div>
    <div>
        <span class="badge bg-light text-dark border p-2">
            <i class="fa-regular fa-clock me-1 text-primary"></i> <?= date('l, d F Y'); ?>
        </span>
    </div>
</div>

<?php if ($role === 'admin'): ?>
    <!-- ==================== DASHBOARD ADMIN ==================== -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Santri Aktif</small>
                        <h3 class="fw-bold text-dark mb-0"><?= number_format($stats['total_santri']); ?></h3>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <i class="fa-solid fa-users fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <a href="<?= base_url('santri'); ?>" class="small text-success fw-semibold text-decoration-none">
                        Kelola Santri <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Total Kelas</small>
                        <h3 class="fw-bold text-dark mb-0"><?= number_format($stats['total_kelas']); ?></h3>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                        <i class="fa-solid fa-chalkboard fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <a href="<?= base_url('kelas'); ?>" class="small text-primary fw-semibold text-decoration-none">
                        Kelola Kelas <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Saldo Kas SPP</small>
                        <h4 class="fw-bold text-success mb-0">Rp <?= number_format($stats['saldo_spp'], 0, ',', '.'); ?></h4>
                    </div>
                    <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                        <i class="fa-solid fa-vault fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <small class="text-muted">Untuk Bisyaroh Guru</small>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Saldo Infaq & Donasi</small>
                        <h4 class="fw-bold text-primary mb-0">Rp <?= number_format($stats['saldo_infaq'], 0, ',', '.'); ?></h4>
                    </div>
                    <div class="bg-info-subtle text-info p-3 rounded-circle">
                        <i class="fa-solid fa-hand-holding-heart fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <small class="text-muted">Operasional & Pokja</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts Admin -->
    <div class="card-custom p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class="fa-solid fa-bolt text-warning me-2"></i> Aksi Cepat Administrator</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('santri/tambah'); ?>" class="btn btn-outline-success rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-user-plus me-1"></i> Tambah Santri Baru
            </a>
            <a href="<?= base_url('kelas'); ?>" class="btn btn-outline-primary rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Buat Kelas Baru
            </a>
            <a href="<?= base_url('tahun_ajaran'); ?>" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-calendar-plus me-1"></i> Atur Semester
            </a>
            <a href="<?= base_url('pengajar_admin'); ?>" class="btn btn-outline-info rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-chalkboard-user me-1"></i> Profil Pengajar (Asatidz)
            </a>
            <a href="<?= base_url('users'); ?>" class="btn btn-outline-dark rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-user-gear me-1"></i> Manajemen Pengguna
            </a>
        </div>
    </div>

<?php elseif ($role === 'keuangan'): ?>
    <!-- ==================== DASHBOARD KEUANGAN ==================== -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Setoran Wali Kelas Pending</small>
                        <h3 class="fw-bold text-danger mb-0"><?= number_format($stats['setoran_pending']); ?></h3>
                    </div>
                    <div class="bg-danger-subtle text-danger p-3 rounded-circle">
                        <i class="fa-solid fa-bell fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <a href="<?= base_url('kas/setoran_masuk'); ?>" class="small text-danger fw-semibold text-decoration-none">
                        Verifikasi Setoran <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Pengeluaran Bulan Ini</small>
                        <h4 class="fw-bold text-dark mb-0">Rp <?= number_format($stats['pengeluaran_bulan_ini'], 0, ',', '.'); ?></h4>
                    </div>
                    <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                        <i class="fa-solid fa-money-bill-transfer fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <a href="<?= base_url('kas/pengeluaran'); ?>" class="small text-warning fw-semibold text-decoration-none">
                        Input Pengeluaran Baru <i class="fa-solid fa-plus ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Donasi Masuk Bulan Ini</small>
                        <h4 class="fw-bold text-success mb-0">Rp <?= number_format($stats['donasi_bulan_ini'], 0, ',', '.'); ?></h4>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <i class="fa-solid fa-heart-circle-plus fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <a href="<?= base_url('kas/donasi'); ?>" class="small text-success fw-semibold text-decoration-none">
                        Catat Donasi Donatur <i class="fa-solid fa-plus ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Saldo Kas Utama -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card-custom p-4 border-start border-4 border-success">
                <h6 class="text-muted fw-bold">Saldo Kas SPP (Kas Utama)</h6>
                <h3 class="fw-bold text-success mb-1">Rp <?= number_format($stats['saldo_spp'], 0, ',', '.'); ?></h3>
                <small class="text-muted">Khusus peruntukan Bisyaroh Guru</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-custom p-4 border-start border-4 border-primary">
                <h6 class="text-muted fw-bold">Saldo Kas Infaq & Donatur (Kas Utama)</h6>
                <h3 class="fw-bold text-primary mb-1">Rp <?= number_format($stats['saldo_infaq'], 0, ',', '.'); ?></h3>
                <small class="text-muted">Khusus operasional, kas pokja, dan pengadaan buku</small>
            </div>
        </div>
    </div>

<?php elseif ($role === 'wali_kelas'): ?>
    <!-- ==================== DASHBOARD WALI KELAS ==================== -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Kelas Binaan Saya</small>
                        <h4 class="fw-bold text-dark mb-0">
                            <?= isset($stats['kelas']->nama) ? htmlspecialchars($stats['kelas']->nama) : 'Belum Ditugaskan'; ?>
                        </h4>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                        <i class="fa-solid fa-chalkboard-user fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <small class="text-muted">Total Santri: <strong><?= number_format($stats['total_santri_kelas']); ?> Orang</strong></small>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Sudah Bayar Bulan Ini</small>
                        <h3 class="fw-bold text-success mb-0"><?= number_format($stats['santri_lunas_spp']); ?> <small class="fs-6 text-muted">/ <?= number_format($stats['total_santri_kelas']); ?> Santri</small></h3>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <i class="fa-solid fa-receipt fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <a href="<?= base_url('kas/pembayaran'); ?>" class="small text-success fw-semibold text-decoration-none">
                        Input Pembayaran SPP <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Kas Kelas Terhimpun</small>
                        <h4 class="fw-bold text-dark mb-0">Rp <?= number_format($stats['kas_kelas_bulan_ini'], 0, ',', '.'); ?></h4>
                    </div>
                    <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                        <i class="fa-solid fa-money-bill-wave fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <a href="<?= base_url('kas/setor'); ?>" class="small text-warning fw-semibold text-decoration-none">
                        Setor ke Kas Utama <i class="fa-solid fa-paper-plane ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts Wali Kelas -->
    <div class="card-custom p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class="fa-solid fa-bolt text-warning me-2"></i> Tindakan Cepat Wali Kelas</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('kas/pembayaran'); ?>" class="btn btn-outline-success rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-cash-register me-1"></i> Input Pembayaran Santri
            </a>
            <a href="<?= base_url('kas/setor'); ?>" class="btn btn-outline-warning text-dark rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-paper-plane me-1"></i> Setor Kas ke Kas Utama
            </a>
            <a href="<?= base_url('raport/nilai_pertemuan'); ?>" class="btn btn-outline-primary rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-pen-to-square me-1"></i> Input Nilai Pertemuan
            </a>
            <a href="<?= base_url('raport/kelas_saya'); ?>" class="btn btn-outline-dark rounded-pill px-3 btn-sm">
                <i class="fa-solid fa-file-signature me-1"></i> Buka Raport Semester
            </a>
        </div>
    </div>
<?php endif; ?>

<!-- Informasi Semester & Tahun Ajaran Aktif -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-success-subtle text-success p-3 rounded-circle">
            <i class="fa-solid fa-circle-info fa-lg"></i>
        </div>
        <div>
            <h6 class="fw-bold mb-1">Periode Akademik Aktif Saat Ini</h6>
            <p class="small text-muted mb-0">
                Tahun Ajaran: <strong><?= isset($current_ta->nama) ? htmlspecialchars($current_ta->nama) : '2026/2027'; ?></strong> &bull; 
                Semester: <span class="badge bg-primary text-uppercase"><?= isset($current_semester->tipe) ? htmlspecialchars($current_semester->tipe) : 'Ganjil'; ?></span> &bull; 
                Seluruh pengelolaan kelas, riwayat jilid santri, kas bulanan, dan penerbitan raport mengacu pada periode aktif ini.
            </p>
        </div>
    </div>
</div>
