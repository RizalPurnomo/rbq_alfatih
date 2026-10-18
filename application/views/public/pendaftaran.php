<!-- Header Section -->
<section class="py-5 bg-light border-bottom">
    <div class="container text-center py-3">
        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Penerimaan Santri Baru (PSB)</span>
        <h1 class="fw-bold text-dark">Informasi Pendaftaran Santri RBQ Al Fatih</h1>
        <p class="text-muted lead max-w-2xl mx-auto mb-0">
            Bergabunglah bersama keluarga besar Rumah Belajar Quran Al Fatih untuk menumbuhkan cinta Al-Quran sejak dini.
        </p>
    </div>
</section>

<!-- Content Pendaftaran -->
<section class="py-5 bg-white">
    <div class="container py-3">
        <!-- Status Tahun Ajaran -->
        <?php if (!empty($semester_aktif)): ?>
            <div class="alert alert-success d-flex align-items-center rounded-4 shadow-sm mb-5 p-3 p-md-4">
                <i class="fa-solid fa-circle-check fa-2x text-success me-3"></i>
                <div>
                    <h5 class="fw-bold mb-1">Pendaftaran Terbuka untuk Tahun Ajaran <?= htmlspecialchars($semester_aktif->nama_tahun_ajaran); ?></h5>
                    <p class="mb-0 small text-secondary">
                        Semester aktif saat ini: <strong><?= ucfirst(htmlspecialchars($semester_aktif->tipe)); ?></strong>. Kelas santri terbagi dari Pra Ummi hingga Jilid 6.
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Alur Pendaftaran -->
        <div class="mb-5">
            <div class="text-center mb-4">
                <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill fw-bold text-uppercase">Tahapan Mudah</span>
                <h3 class="fw-bold text-dark mt-2">Alur Pendaftaran Santri Baru</h3>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="p-4 border rounded-4 text-center bg-light h-100 position-relative">
                        <span class="badge bg-success rounded-circle fs-6 p-3 mb-3">1</span>
                        <h5 class="fw-bold">Pendaftaran Online/Offline</h5>
                        <p class="small text-muted mb-0">Mengisi formulir data diri santri dan orang tua melalui WhatsApp atau langsung di sekretariat.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 border rounded-4 text-center bg-light h-100 position-relative">
                        <span class="badge bg-success rounded-circle fs-6 p-3 mb-3">2</span>
                        <h5 class="fw-bold">Tes Penempatan (Placement)</h5>
                        <p class="small text-muted mb-0">Santri diuji kemampuan membaca huruf hijaiyah untuk menentukan kelompok jilid yang sesuai (Pra Ummi s.d. Jilid 6).</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 border rounded-4 text-center bg-light h-100 position-relative">
                        <span class="badge bg-success rounded-circle fs-6 p-3 mb-3">3</span>
                        <h5 class="fw-bold">Penempatan Kelas & Wali Kelas</h5>
                        <p class="small text-muted mb-0">Santri dimasukkan ke dalam kelas bersama 1 ustadz/ah wali kelas yang membimbing secara intensif.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 border rounded-4 text-center bg-light h-100 position-relative">
                        <span class="badge bg-success rounded-circle fs-6 p-3 mb-3">4</span>
                        <h5 class="fw-bold">Mulai KBM Al-Quran</h5>
                        <p class="small text-muted mb-0">Santri mulai kegiatan belajar membaca Al-Quran, setoran hafalan doa & surat pendek, serta pencatatan raport digital.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Persyaratan -->
            <div class="col-lg-6">
                <div class="p-4 p-md-5 rounded-4 border bg-light h-100 shadow-sm">
                    <h4 class="fw-bold text-dark mb-4"><i class="fa-solid fa-clipboard-check text-success me-2"></i> Persyaratan Pendaftaran</h4>
                    <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                        <li class="d-flex align-items-start gap-3">
                            <i class="fa-solid fa-check text-success mt-1"></i>
                            <span>Usia minimal <strong>4 tahun</strong> (untuk jenjang Pra Ummi).</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <i class="fa-solid fa-check text-success mt-1"></i>
                            <span>Mengisi formulir biodata santri dan nomor kontak wali santri yang aktif.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <i class="fa-solid fa-check text-success mt-1"></i>
                            <span>Fotokopi Kartu Keluarga (KK) / Akta Kelahiran santri (1 lembar).</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <i class="fa-solid fa-check text-success mt-1"></i>
                            <span>Pas foto santri ukuran 3x4 (2 lembar).</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <i class="fa-solid fa-check text-success mt-1"></i>
                            <span>Bersedia mengikuti tata tertib, jadwal pertemuan, dan pembinaan karakter di RBQ Al Fatih.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Hubungi Panitia / Form Inquiry -->
            <div class="col-lg-6">
                <div class="p-4 p-md-5 rounded-4 border bg-white h-100 shadow-sm text-center d-flex flex-column justify-content-center">
                    <div class="mb-4">
                        <i class="fa-brands fa-whatsapp text-success fa-4x mb-3"></i>
                        <h4 class="fw-bold">Pendaftaran Praktis via WhatsApp</h4>
                        <p class="text-muted">
                            Hubungi panitia pendaftaran santri baru kami secara langsung untuk konfirmasi ketersediaan kuota kelas dan jadwal placement test.
                        </p>
                    </div>

                    <div class="p-3 bg-light rounded-4 border mb-4 text-start">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Waktu Layanan:</span>
                            <span class="fw-semibold small text-dark">Senin - Sabtu (08.00 - 17.00 WIB)</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Kontak Hotline:</span>
                            <span class="fw-bold text-success small">0812-3456-7890</span>
                        </div>
                    </div>

                    <a href="https://wa.me/6281234567890?text=Assalamu%27alaikum%20Panitia%20RBQ%20Al%20Fatih,%20saya%20ingin%20mendaftarkan%20anak%20saya%20sebagai%20santri%20baru." target="_blank" class="btn btn-success btn-lg rounded-pill fw-bold py-3 shadow">
                        <i class="fa-brands fa-whatsapp me-2 fs-5"></i> Hubungi Panitia Pendaftaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
