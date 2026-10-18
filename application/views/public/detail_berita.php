<!-- Header Section -->
<section class="py-5 bg-light border-bottom">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('berita'); ?>" class="text-decoration-none">Event & Berita</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 300px;" aria-current="page"><?= htmlspecialchars($berita->judul); ?></li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge <?= $berita->kategori === 'event' ? 'bg-warning text-dark' : 'bg-success'; ?> text-uppercase small">
                <?= htmlspecialchars($berita->kategori); ?>
            </span>
            <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> Dipublikasikan: <?= date('d F Y', strtotime($berita->tanggal_publish)); ?></small>
            <?php if (!empty($berita->nama_penulis)): ?>
                <small class="text-muted"><i class="fa-regular fa-user me-1 ms-2"></i> Oleh: <?= htmlspecialchars($berita->nama_penulis); ?></small>
            <?php endif; ?>
        </div>
        <h1 class="fw-bold text-dark display-6"><?= htmlspecialchars($berita->judul); ?></h1>
    </div>
</section>

<!-- Content Detail -->
<section class="py-5 bg-white">
    <div class="container py-3">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="p-4 p-md-5 bg-light rounded-4 border mb-4 text-center">
                    <i class="fa-solid <?= $berita->kategori === 'event' ? 'fa-calendar-check text-warning' : 'fa-newspaper text-emerald'; ?> fa-5x mb-3"></i>
                    <h5 class="text-muted"><?= htmlspecialchars($berita->judul); ?></h5>
                </div>

                <div class="article-content leading-relaxed text-secondary fs-5" style="line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($berita->konten)); ?>
                </div>

                <div class="pt-4 mt-5 border-top d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('berita'); ?>" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Berita
                    </a>
                </div>
            </div>

            <!-- Sidebar Berita Terkait -->
            <div class="col-lg-4">
                <div class="p-4 bg-light rounded-4 border shadow-sm">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-clock-rotate-left text-success me-2"></i> Berita Lainnya</h5>
                    <div class="d-flex flex-column gap-3">
                        <?php if (!empty($berita_terkait)): ?>
                            <?php foreach ($berita_terkait as $bt): ?>
                                <?php if ($bt->id != $berita->id): ?>
                                    <div class="border-bottom pb-2">
                                        <small class="text-muted d-block mb-1"><i class="fa-regular fa-calendar me-1"></i> <?= date('d M Y', strtotime($bt->tanggal_publish)); ?></small>
                                        <a href="<?= base_url('berita/' . $bt->slug); ?>" class="fw-semibold text-dark text-decoration-none hover-primary">
                                            <?= htmlspecialchars($bt->judul); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
