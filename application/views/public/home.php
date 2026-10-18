<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="badge-ummi mb-3">
                    <i class="fa-solid fa-star text-warning"></i> Metode Pengajaran Resmi Terstandar Ummi
                </span>
                <h1 class="display-5 fw-extrabold text-dark mb-3" style="line-height: 1.25;">
                    Mendidik Generasi Pecinta Al-Quran yang <span class="text-success">Fasih, Tartil & Berakhlak</span>
                </h1>
                <p class="lead text-muted mb-4" style="font-size: 1.15rem;">
                    Selamat datang di <strong>Rumah Belajar Quran (RBQ) Al Fatih</strong>. Kami menghadirkan pendidikan Al-Quran berkualitas berjenjang dari <strong>Pra Ummi hingga Jilid 6</strong> dengan suasana belajar yang menyenangkan, penuh kasih sayang, dan terpantau secara digital.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= base_url('pendaftaran'); ?>" class="btn btn-emerald btn-lg px-4 shadow-sm">
                        <i class="fa-solid fa-user-plus me-2"></i> Daftar Santri Baru
                    </a>
                    <a href="<?= base_url('tentang'); ?>" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">
                        <i class="fa-solid fa-circle-info me-2"></i> Pelajari Metode Ummi
                    </a>
                </div>

                <!-- Info Semester Aktif -->
                <?php if (!empty($semester_aktif)): ?>
                    <div class="mt-4 pt-3 border-top border-2 border-emerald-subtle d-flex align-items-center gap-3">
                        <div class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                            <i class="fa-solid fa-calendar-check me-1"></i> Tahun Ajaran <?= htmlspecialchars($semester_aktif->nama_tahun_ajaran); ?>
                        </div>
                        <span class="small text-muted fw-semibold">
                            Semester: <span class="badge bg-primary text-uppercase"><?= htmlspecialchars($semester_aktif->tipe); ?></span>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-5 text-center">
                <div class="position-relative p-4 rounded-4 shadow-lg bg-white border">
                    <div class="p-3 bg-light rounded-4 mb-3">
                        <i class="fa-solid fa-quran text-success fa-5x my-3"></i>
                        <h4 class="fw-bold mb-1">Metode Ummi Foundation</h4>
                        <p class="small text-muted mb-0">Mudah, Menyenangkan, dan Menyentuh Hati</p>
                    </div>
                    <div class="row g-2 text-start">
                        <div class="col-6">
                            <div class="p-2 border rounded-3 bg-white">
                                <small class="text-muted d-block">Tingkatan</small>
                                <strong class="text-dark">7 Jilid Lengkap</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded-3 bg-white">
                                <small class="text-muted d-block">Monitoring</small>
                                <strong class="text-success">Raport Digital</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded-3 bg-white">
                                <small class="text-muted d-block">Guru</small>
                                <strong class="text-dark">Bersertifikat Ummi</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded-3 bg-white">
                                <small class="text-muted d-block">Sistem</small>
                                <strong class="text-primary">Kas & Tabungan</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jenjang Metode Ummi Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center max-w-2xl mx-auto mb-5">
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold text-uppercase">Kurikulum Berjenjang</span>
            <h2 class="fw-bold text-dark mt-2 mb-3">Tingkatan Pembelajaran Metode Ummi di RBQ Al Fatih</h2>
            <p class="text-muted">Setiap santri dikelompokkan sesuai kemampuan membaca dan perkembangannya tercatat secara sistematis dalam sistem riwayat jilid santri.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4 col-lg-3">
                <div class="jilid-card">
                    <div class="badge bg-secondary-subtle text-secondary mb-3 px-3 py-2 rounded-pill fw-bold">Tahap Awal</div>
                    <h5 class="fw-bold text-dark">Pra Ummi</h5>
                    <p class="small text-muted mb-0">Pengenalan huruf tunggal hijaiyah berharakat fathah secara langsung tanpa mengeja.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="jilid-card">
                    <div class="badge bg-success-subtle text-success mb-3 px-3 py-2 rounded-pill fw-bold">Tingkat 1</div>
                    <h5 class="fw-bold text-dark">Jilid 1</h5>
                    <p class="small text-muted mb-0">Pengenalan huruf berharakat fathah bersambung dan membedakan makharijul huruf.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="jilid-card">
                    <div class="badge bg-success-subtle text-success mb-3 px-3 py-2 rounded-pill fw-bold">Tingkat 2</div>
                    <h5 class="fw-bold text-dark">Jilid 2</h5>
                    <p class="small text-muted mb-0">Pengenalan harakat kasrah, dhammah, tanwin (fathatain, kasratain, dhammatain).</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="jilid-card">
                    <div class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-bold">Tingkat 3</div>
                    <h5 class="fw-bold text-dark">Jilid 3</h5>
                    <p class="small text-muted mb-0">Mengenal bacaan panjang (Mad Thabi'i), angka arab, serta jeda nafas waqaf.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="jilid-card">
                    <div class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-bold">Tingkat 4</div>
                    <h5 class="fw-bold text-dark">Jilid 4</h5>
                    <p class="small text-muted mb-0">Pengenalan sukun (mati), qolqolah, dan huruf lin dengan pengucapan benar.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="jilid-card">
                    <div class="badge bg-warning-subtle text-warning mb-3 px-3 py-2 rounded-pill fw-bold">Tingkat 5</div>
                    <h5 class="fw-bold text-dark">Jilid 5</h5>
                    <p class="small text-muted mb-0">Pengenalan tasydid, ghunnah musyaddadah, serta hukum idgham dan ikhfa.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="jilid-card">
                    <div class="badge bg-danger-subtle text-danger mb-3 px-3 py-2 rounded-pill fw-bold">Tingkat 6</div>
                    <h5 class="fw-bold text-dark">Jilid 6</h5>
                    <p class="small text-muted mb-0">Hukum tajwid lanjutan, waqaf washil, idzhar, iqlab, hingga persiapan Al-Quran besar.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="jilid-card border-success bg-success-subtle">
                    <div class="badge bg-success text-white mb-3 px-3 py-2 rounded-pill fw-bold">Tahap Lanjut</div>
                    <h5 class="fw-bold text-success">Al-Quran & Ghorib</h5>
                    <p class="small text-muted mb-0">Tadarrus Al-Quran 30 juz, tahsin ghorib musykilat, dan munaqasyah wisuda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-5 bg-light border-top border-bottom">
    <div class="container py-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill fw-bold text-uppercase">Kenapa Memilih Kami</span>
                <h2 class="fw-bold text-dark mt-2 mb-3">Keunggulan Belajar di RBQ Al Fatih</h2>
                <p class="text-muted mb-4">Kami tidak hanya mengajarkan cara membaca Al-Quran, namun juga menanamkan akhlak mulia dan kedisiplinan ibadah sehari-hari.</p>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex gap-3">
                        <div class="text-success fs-4"><i class="fa-solid fa-circle-check"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Metodologi Teruji & Terstandar Ummi</h6>
                            <p class="small text-muted mb-0">Pendekatan klasikal baca simak yang memastikan setiap anak mendapat perhatian guru.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="text-success fs-4"><i class="fa-solid fa-circle-check"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Rasio Santri & Guru Ideal</h6>
                            <p class="small text-muted mb-0">Setiap kelas didampingi 1 orang wali kelas yang memantau perkembangan harian.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="text-success fs-4"><i class="fa-solid fa-circle-check"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Laporan Perkembangan Terbuka & Raport Berkala</h6>
                            <p class="small text-muted mb-0">Nilai dievaluasi setiap pertemuan bulanan dengan ledger nilai transparan dan raport semester.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <i class="fa-solid fa-wallet fa-2x text-emerald mb-3"></i>
                            <h5 class="fw-bold">Kas & SPP Terkelola</h5>
                            <p class="small text-muted mb-0">Pencatatan kas transparan dari SPP tetap, infaq suka rela, dan penyaluran bisyaroh guru secara amanah.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <i class="fa-solid fa-piggy-bank fa-2x text-warning mb-3"></i>
                            <h5 class="fw-bold">Edukasi Tabungan Santri</h5>
                            <p class="small text-muted mb-0">Melatih santri gemar menabung yang dihimpun saat bayaran dan dapat ditarik sewaktu-waktu oleh santri.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <i class="fa-solid fa-clipboard-user fa-2x text-primary mb-3"></i>
                            <h5 class="fw-bold">Evaluasi Kepribadian</h5>
                            <p class="small text-muted mb-0">Penilaian akhlak santri meliputi aspek ketertiban, kedisiplinan, dan motivasi belajar pada raport.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <i class="fa-solid fa-map-location-dot fa-2x text-danger mb-3"></i>
                            <h5 class="fw-bold">Lokasi Nyaman & Strategis</h5>
                            <p class="small text-muted mb-0">Suasana belajar kondusif dan mudah dijangkau melalui Google Maps resmi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profil Pengajar Preview Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 rounded-pill fw-bold text-uppercase">
                    <i class="fa-solid fa-certificate me-1"></i> Pengajar Berkompeten
                </span>
                <h2 class="fw-bold text-dark mt-2 mb-0">Tenaga Pendidik & Asatidz RBQ Al Fatih</h2>
                <p class="text-muted small mt-1 mb-0">Dibimbing langsung oleh ustadz dan ustadzah bersertifikasi resmi Metode Ummi Foundation & bersanad.</p>
            </div>
            <div>
                <a href="<?= base_url('pengajar'); ?>" class="btn btn-emerald rounded-pill px-4">
                    Lihat Semua Pengajar <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($pengajar_preview)): ?>
                <?php foreach (array_slice($pengajar_preview, 0, 3) as $p): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                            <div class="p-4 text-center" style="background: linear-gradient(180deg, #ecfdf5 0%, #ffffff 100%);">
                                <div class="avatar-placeholder rounded-circle shadow-sm border border-3 border-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 90px; height: 90px; background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); color: #ffffff;">
                                    <i class="fa-solid <?= ($p->jenis_kelamin === 'L') ? 'fa-user-tie' : 'fa-user-nurse'; ?> fa-2x"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($p->nama); ?></h5>
                                <?php if (!empty($p->gelar)): ?>
                                    <p class="text-emerald fw-semibold small mb-2"><?= htmlspecialchars($p->gelar); ?></p>
                                <?php endif; ?>
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1 rounded-pill small">
                                    <?= htmlspecialchars($p->jabatan); ?>
                                </span>
                            </div>
                            <div class="card-body px-4 py-3 pt-0 d-flex flex-column">
                                <p class="small text-muted mb-3 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 40px;">
                                    <?= htmlspecialchars($p->pengalaman); ?>
                                </p>
                                <div class="mt-auto pt-3 border-top">
                                    <a href="<?= base_url('pengajar'); ?>" class="btn btn-outline-emerald btn-sm w-100 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-user-graduate me-1"></i> Lihat Portofolio Pengajar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Event & Berita Terbaru Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <span class="badge bg-emerald-subtle text-emerald px-3 py-2 rounded-pill fw-bold text-uppercase">Kabar Terbaru</span>
                <h2 class="fw-bold text-dark mt-2 mb-0">Event & Berita RBQ Al Fatih</h2>
            </div>
            <div>
                <a href="<?= base_url('berita'); ?>" class="btn btn-outline-secondary rounded-pill px-4">
                    Lihat Semua Berita <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($berita_terbaru)): ?>
                <?php foreach ($berita_terbaru as $b): ?>
                    <div class="col-md-4">
                        <div class="card h-100 border rounded-4 overflow-hidden shadow-sm hover-shadow transition">
                            <div class="bg-light p-4 text-center border-bottom" style="height: 160px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid <?= $b->kategori === 'event' ? 'fa-calendar-days text-warning' : 'fa-newspaper text-emerald'; ?> fa-3x"></i>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge <?= $b->kategori === 'event' ? 'bg-warning text-dark' : 'bg-success'; ?> text-uppercase small">
                                        <?= htmlspecialchars($b->kategori); ?>
                                    </span>
                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> <?= date('d M Y', strtotime($b->tanggal_publish)); ?></small>
                                </div>
                                <h5 class="card-title fw-bold mb-2">
                                    <a href="<?= base_url('berita/' . $b->slug); ?>" class="text-dark text-decoration-none hover-primary">
                                        <?= htmlspecialchars($b->judul); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?= word_limiter(strip_tags($b->konten), 18); ?>
                                </p>
                                <a href="<?= base_url('berita/' . $b->slug); ?>" class="text-success fw-bold small text-decoration-none mt-2">
                                    Baca Selengkapnya <i class="fa-solid fa-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-4 text-muted">
                    <p>Belum ada artikel berita yang dipublikasikan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5" style="background: linear-gradient(135deg, #0f766e 0%, #134e4a 100%);">
    <div class="container py-4 text-center text-white">
        <h2 class="display-6 fw-bold mb-3">Mari Daftarkan Putra-Putri Anda Sekarang</h2>
        <p class="lead text-emerald-light mb-4 max-w-2xl mx-auto" style="opacity: 0.9;">
            Wujudkan cita-cita memiliki generasi hafidz dan pecinta Quran sejak usia dini bersama kami di Rumah Belajar Quran Al Fatih.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="<?= base_url('pendaftaran'); ?>" class="btn btn-warning btn-lg px-4 rounded-pill fw-bold text-dark shadow">
                <i class="fa-solid fa-file-pen me-2"></i> Info Pendaftaran Santri
            </a>
            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-outline-light btn-lg px-4 rounded-pill fw-semibold">
                <i class="fa-brands fa-whatsapp me-2"></i> Konsultasi via WhatsApp
            </a>
        </div>
    </div>
</section>
