<?php
$role        = $this->session->userdata('role');
$active_menu = isset($active_menu) ? $active_menu : '';
?>

<!-- Sidebar Panel -->
<aside class="sidebar" id="sidebar">
    <a href="<?= base_url('dashboard'); ?>" class="sidebar-brand">
        <i class="fa-solid fa-book-quran text-warning"></i>
        <span>RBQ Al Fatih</span>
    </a>

    <ul class="sidebar-menu">
        <li class="menu-header">Menu Utama</li>
        <li>
            <a href="<?= base_url('dashboard'); ?>" class="sidebar-link <?= ($active_menu === 'dashboard') ? 'active' : ''; ?>">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php if ($role === 'admin'): ?>
            <!-- Menu Khusus Admin -->
            <li class="menu-header">Kesiswaan & Santri</li>
            <li>
                <a href="<?= base_url('santri'); ?>" class="sidebar-link <?= ($active_menu === 'santri') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-users"></i>
                    <span>Data Santri</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('santri/riwayat_jilid'); ?>" class="sidebar-link <?= ($active_menu === 'riwayat_jilid') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Riwayat Jilid</span>
                </a>
            </li>

            <li class="menu-header">Akademik & Kelas</li>
            <li>
                <a href="<?= base_url('kelas'); ?>" class="sidebar-link <?= ($active_menu === 'kelas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chalkboard"></i>
                    <span>Manajemen Kelas</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('tahun_ajaran'); ?>" class="sidebar-link <?= ($active_menu === 'tahun_ajaran') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Tahun Ajaran & Semester</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('raport'); ?>" class="sidebar-link <?= ($active_menu === 'raport') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Ledger & Raport</span>
                </a>
            </li>

            <li class="menu-header">Keuangan & Website</li>
            <li>
                <a href="<?= base_url('kas/laporan'); ?>" class="sidebar-link <?= ($active_menu === 'laporan_kas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Laporan Kas Utama</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('tabungan'); ?>" class="sidebar-link <?= ($active_menu === 'tabungan') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-piggy-bank"></i>
                    <span>Tabungan Santri</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('pengajar_admin'); ?>" class="sidebar-link <?= ($active_menu === 'pengajar_admin') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Profil Pengajar</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('berita_admin'); ?>" class="sidebar-link <?= ($active_menu === 'berita_admin') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>Event & Berita</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('users'); ?>" class="sidebar-link <?= ($active_menu === 'users') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-user-gear"></i>
                    <span>Manajemen Pengguna</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($role === 'keuangan'): ?>
            <!-- Menu Khusus Keuangan -->
            <li class="menu-header">Kas Utama</li>
            <li>
                <a href="<?= base_url('kas/pengeluaran'); ?>" class="sidebar-link <?= ($active_menu === 'pengeluaran') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                    <span>Pengeluaran Kas</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('kas/setoran_masuk'); ?>" class="sidebar-link <?= ($active_menu === 'setoran_masuk') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                    <span>Setoran Wali Kelas</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('kas/donasi'); ?>" class="sidebar-link <?= ($active_menu === 'donasi') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-heart-circle-plus"></i>
                    <span>Penerimaan Donasi</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('tabungan'); ?>" class="sidebar-link <?= ($active_menu === 'tabungan') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-piggy-bank"></i>
                    <span>Tabungan Santri</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('kas/laporan'); ?>" class="sidebar-link <?= ($active_menu === 'laporan_kas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>Laporan Keuangan</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($role === 'wali_kelas'): ?>
            <!-- Menu Khusus Wali Kelas -->
            <li class="menu-header">Kelas Binaan</li>
            <li>
                <a href="<?= base_url('kelas_saya'); ?>" class="sidebar-link <?= ($active_menu === 'kelas_saya') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Santri Kelas Saya</span>
                </a>
            </li>

            <li class="menu-header">Kas & Pembayaran</li>
            <li>
                <a href="<?= base_url('kas/pembayaran'); ?>" class="sidebar-link <?= ($active_menu === 'pembayaran') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>Input Pembayaran SPP</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('kas/setor'); ?>" class="sidebar-link <?= ($active_menu === 'setor_kas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span>Setor ke Kas Utama</span>
                </a>
            </li>

            <li class="menu-header">Penilaian & Raport</li>
            <li>
                <a href="<?= base_url('raport/nilai_pertemuan'); ?>" class="sidebar-link <?= ($active_menu === 'nilai_pertemuan') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Nilai Pertemuan</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('raport/kelas_saya'); ?>" class="sidebar-link <?= ($active_menu === 'raport_kelas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>Raport & Kepribadian</span>
                </a>
            </li>
        <?php endif; ?>

        <li class="menu-header">Akun</li>
        <li>
            <a href="<?= base_url('logout'); ?>" class="sidebar-link text-danger">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Keluar (Logout)</span>
            </a>
        </li>
    </ul>
</aside>
