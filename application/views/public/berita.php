<!-- Header Section -->
<section class="py-5 bg-light border-bottom">
    <div class="container text-center py-3">
        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Informasi & Kegiatan</span>
        <h1 class="fw-bold text-dark">Event & Berita RBQ Al Fatih</h1>
        <p class="text-muted lead max-w-2xl mx-auto mb-0">Ikuti perkembangan terbaru seputar kegiatan santri, agenda munaqasyah, kajian, dan pengumuman resmi.</p>
    </div>
</section>

<!-- Content Berita -->
<section class="py-5 bg-white">
    <div class="container py-3">
        <!-- Filter Kategori -->
        <div class="d-flex justify-content-center mb-5">
            <div class="btn-group p-1 bg-light rounded-pill border" role="group">
                <a href="<?= base_url('berita'); ?>" class="btn rounded-pill px-4 <?= empty($kategori_aktif) ? 'btn-success fw-bold' : 'btn-light text-muted'; ?>">Semua</a>
                <a href="<?= base_url('berita?kategori=berita'); ?>" class="btn rounded-pill px-4 <?= ($kategori_aktif === 'berita') ? 'btn-success fw-bold' : 'btn-light text-muted'; ?>">Berita</a>
                <a href="<?= base_url('berita?kategori=event'); ?>" class="btn rounded-pill px-4 <?= ($kategori_aktif === 'event') ? 'btn-success fw-bold' : 'btn-light text-muted'; ?>">Event & Agenda</a>
            </div>
        </div>

        <!-- Grid Berita -->
        <div class="row g-4">
            <?php if (!empty($daftar_berita)): ?>
                <?php foreach ($daftar_berita as $b): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border rounded-4 overflow-hidden shadow-sm hover-shadow transition">
                            <div class="bg-light p-4 text-center border-bottom" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid <?= $b->kategori === 'event' ? 'fa-calendar-check text-warning' : 'fa-newspaper text-emerald'; ?> fa-4x"></i>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge <?= $b->kategori === 'event' ? 'bg-warning text-dark' : 'bg-success'; ?> text-uppercase small">
                                        <?= htmlspecialchars($b->kategori); ?>
                                    </span>
                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> <?= date('d M Y', strtotime($b->tanggal_publish)); ?></small>
                                </div>
                                <h5 class="card-title fw-bold mb-2">
                                    <a href="<?= base_url('berita/' . $b->slug); ?>" class="text-dark text-decoration-none">
                                        <?= htmlspecialchars($b->judul); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?= word_limiter(strip_tags($b->konten), 22); ?>
                                </p>
                                <a href="<?= base_url('berita/' . $b->slug); ?>" class="text-success fw-bold small text-decoration-none mt-3">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fa-solid fa-folder-open text-muted fa-4x mb-3"></i>
                    <h5 class="fw-bold text-dark">Belum Ada Informasi</h5>
                    <p class="text-muted">Tidak ditemukan artikel pada kategori ini.</p>
                    <a href="<?= base_url('berita'); ?>" class="btn btn-emerald rounded-pill px-4">Kembali ke Semua Berita</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
