<!-- Hero Banner Section -->
<section class="py-5" style="background: linear-gradient(135deg, #064e3b 0%, #0f766e 50%, #115e59 100%); color: #ffffff;">
    <div class="container py-4 text-center">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3">
            <i class="fa-solid fa-award me-1"></i> Tenaga Pengajar Terstandarisasi
        </span>
        <h1 class="display-6 fw-extrabold mb-3 text-white">Profil Asatidz & Tenaga Pendidik</h1>
        <p class="lead text-light opacity-90 max-w-2xl mx-auto" style="font-size: 1.1rem; max-width: 750px;">
            Mengenal lebih dekat para ustadz dan ustadzah di <strong>RBQ Al Fatih</strong> yang berdedikasi membimbing ananda dengan <strong>Metode Ummi</strong>, bersertifikasi resmi, berilmu syar'i, dan berakhlak mulia.
        </p>
    </div>
</section>

<!-- Filter Kategori & Direktori Pengajar -->
<section class="py-5 bg-light">
    <div class="container py-3">

        <!-- Bar Filter & Counter -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 gap-3 bg-white p-3 rounded-4 shadow-sm border">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-users text-emerald fs-4"></i>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">Daftar Asatidz</h6>
                    <small class="text-muted">Total <?= count($daftar_pengajar); ?> Tenaga Pengajar Aktif</small>
                </div>
            </div>

            <!-- Tombol Filter -->
            <div class="btn-group p-1 bg-light rounded-pill border" role="group">
                <a href="<?= base_url('pengajar'); ?>" class="btn btn-sm rounded-pill px-3 fw-semibold <?= empty($filter_jk) ? 'btn-emerald text-white' : 'btn-light text-muted'; ?>">
                    <i class="fa-solid fa-list me-1"></i> Semua Pengajar
                </a>
                <a href="<?= base_url('pengajar?filter=L'); ?>" class="btn btn-sm rounded-pill px-3 fw-semibold <?= (isset($filter_jk) && $filter_jk === 'L') ? 'btn-emerald text-white' : 'btn-light text-muted'; ?>">
                    <i class="fa-solid fa-user me-1"></i> Asatidz (Ikhwan)
                </a>
                <a href="<?= base_url('pengajar?filter=P'); ?>" class="btn btn-sm rounded-pill px-3 fw-semibold <?= (isset($filter_jk) && $filter_jk === 'P') ? 'btn-emerald text-white' : 'btn-light text-muted'; ?>">
                    <i class="fa-solid fa-user-nurse me-1"></i> Asatidzah (Akhwat)
                </a>
            </div>
        </div>

        <!-- Grid Pengajar -->
        <?php if (!empty($daftar_pengajar)): ?>
            <div class="row g-4">
                <?php foreach ($daftar_pengajar as $p): ?>
                    <?php
                        $badges = array_filter(array_map('trim', explode(',', (string)$p->spesialisasi)));
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative teacher-card">
                            
                            <!-- Card Header Visual -->
                            <div class="p-4 text-center position-relative" style="background: linear-gradient(180deg, #ecfdf5 0%, #ffffff 100%);">
                                <span class="position-absolute top-0 end-0 mt-3 me-3 badge <?= ($p->jenis_kelamin === 'L') ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle'; ?> rounded-pill px-3 py-1 fw-bold">
                                    <i class="fa-solid <?= ($p->jenis_kelamin === 'L') ? 'fa-mars' : 'fa-venus'; ?> me-1"></i>
                                    <?= ($p->jenis_kelamin === 'L') ? 'Ikhwan' : 'Akhwat'; ?>
                                </span>

                                <!-- Avatar / Foto -->
                                <div class="avatar-wrapper mx-auto mb-3">
                                    <?php if (!empty($p->foto) && file_exists(FCPATH . 'uploads/pengajar/' . $p->foto)): ?>
                                        <img src="<?= base_url('uploads/pengajar/' . $p->foto); ?>" alt="<?= htmlspecialchars($p->nama); ?>" class="rounded-circle shadow-sm border border-3 border-white object-fit-cover" style="width: 110px; height: 110px;">
                                    <?php else: ?>
                                        <div class="avatar-placeholder rounded-circle shadow-sm border border-3 border-white d-flex align-items-center justify-content-center mx-auto" style="width: 110px; height: 110px; background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); color: #ffffff;">
                                            <i class="fa-solid <?= ($p->jenis_kelamin === 'L') ? 'fa-user-tie' : 'fa-user-nurse'; ?> fa-3x"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($p->nama); ?></h5>
                                <?php if (!empty($p->gelar)): ?>
                                    <p class="text-emerald fw-semibold small mb-1"><?= htmlspecialchars($p->gelar); ?></p>
                                <?php endif; ?>
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1 rounded-pill small">
                                    <?= htmlspecialchars($p->jabatan); ?>
                                </span>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body px-4 py-3 d-flex flex-column">
                                <!-- Pendidikan -->
                                <div class="mb-3">
                                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                        <i class="fa-solid fa-graduation-cap text-emerald me-1"></i> Pendidikan
                                    </small>
                                    <p class="small text-dark fw-medium mb-0 text-truncate" title="<?= htmlspecialchars($p->pendidikan); ?>">
                                        <?= htmlspecialchars($p->pendidikan); ?>
                                    </p>
                                </div>

                                <!-- Pengalaman Ringkas -->
                                <div class="mb-3">
                                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                        <i class="fa-solid fa-briefcase text-emerald me-1"></i> Pengalaman Mengajar
                                    </small>
                                    <p class="small text-muted mb-0 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 40px;">
                                        <?= htmlspecialchars($p->pengalaman); ?>
                                    </p>
                                </div>

                                <!-- Skill Badges -->
                                <?php if (!empty($badges)): ?>
                                    <div class="mb-3 mt-auto">
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php foreach (array_slice($badges, 0, 3) as $b): ?>
                                                <span class="badge bg-light text-secondary border rounded-pill small fw-normal" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-circle-check text-success me-1"></i><?= htmlspecialchars($b); ?>
                                                </span>
                                            <?php endforeach; ?>
                                            <?php if (count($badges) > 3): ?>
                                                <span class="badge bg-light text-muted border rounded-pill small" style="font-size: 0.75rem;">+<?= count($badges) - 3; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Tombol Modal Detail -->
                                <div class="pt-3 border-top mt-2">
                                    <button type="button" class="btn btn-outline-emerald w-100 rounded-pill btn-sm fw-semibold btn-detail-pengajar" data-id="<?= $p->id; ?>">
                                        <i class="fa-solid fa-address-card me-1"></i> Lihat Profil Lengkap
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5 bg-white rounded-4 border">
                <i class="fa-solid fa-user-slash text-muted fa-3x mb-3"></i>
                <h5 class="fw-bold">Belum Ada Data Pengajar</h5>
                <p class="text-muted small">Data pengajar untuk kategori yang dipilih belum tersedia.</p>
                <a href="<?= base_url('pengajar'); ?>" class="btn btn-emerald btn-sm rounded-pill">Lihat Semua Pengajar</a>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5" style="background: linear-gradient(135deg, #0f766e 0%, #064e3b 100%); color: #ffffff;">
    <div class="container py-4 text-center">
        <h2 class="fw-extrabold text-white mb-3">Ingin Ananda Dibimbing oleh Asatidz Terstandar Metode Ummi?</h2>
        <p class="lead text-light opacity-90 max-w-2xl mx-auto mb-4" style="max-width: 700px;">
            Pendaftaran santri baru RBQ Al Fatih telah dibuka. Kuota kelas terbatas untuk menjamin rasio pengajaran yang optimal dan kondusif.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="<?= base_url('pendaftaran'); ?>" class="btn btn-gold btn-lg px-4 shadow">
                <i class="fa-solid fa-file-signature me-2"></i> Info Pendaftaran Santri Baru
            </a>
            <a href="<?= base_url('kontak'); ?>" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                <i class="fa-solid fa-comments me-2"></i> Konsultasi via WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- Modal Pop-Up Detail Profil Pengajar -->
<div class="modal fade" id="modalDetailPengajar" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            
            <!-- Modal Header dengan Background Emerald -->
            <div class="modal-header border-0 p-4 text-white position-relative" style="background: linear-gradient(135deg, #064e3b 0%, #0f766e 100%);">
                <div class="d-flex align-items-center gap-3 w-100">
                    <div id="modalAvatarBox" class="rounded-circle bg-white text-emerald d-flex align-items-center justify-content-center shadow" style="width: 70px; height: 70px; font-size: 2rem; flex-shrink: 0;">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <span id="modalJabatanBadge" class="badge bg-warning text-dark px-3 py-1 rounded-pill small fw-bold mb-1 d-inline-block"></span>
                        <h4 class="modal-title fw-extrabold text-white mb-0" id="modalNama"></h4>
                        <small id="modalGelar" class="text-light opacity-90 fw-medium"></small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4 bg-light">
                <div class="row g-4">
                    
                    <!-- Kolom Kiri: Riwayat Pendidikan & Sertifikasi -->
                    <div class="col-md-6">
                        <div class="bg-white p-3 rounded-4 border shadow-sm h-100">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="fa-solid fa-graduation-cap text-emerald me-2"></i> Pendidikan & Almamater
                            </h6>
                            <p id="modalPendidikan" class="small text-muted mb-4"></p>

                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="fa-solid fa-certificate text-warning me-2"></i> Sertifikasi & Sanad
                            </h6>
                            <div id="modalSertifikasiBox" class="small text-muted"></div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Pengalaman, Keahlian, Quote -->
                    <div class="col-md-6">
                        <div class="bg-white p-3 rounded-4 border shadow-sm h-100 d-flex flex-column">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="fa-solid fa-briefcase text-emerald me-2"></i> Pengalaman Mengajar
                            </h6>
                            <p id="modalPengalaman" class="small text-muted mb-3"></p>

                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                                <i class="fa-solid fa-tags text-primary me-2"></i> Spesialisasi & Keahlian
                            </h6>
                            <div id="modalBadgesBox" class="d-flex flex-wrap gap-1 mb-3"></div>

                            <!-- Quote / Mutiara Kata -->
                            <div class="mt-auto p-3 rounded-3 border-start border-4 border-warning bg-warning-subtle">
                                <small class="fw-bold text-dark d-block mb-1">
                                    <i class="fa-solid fa-quote-left text-warning me-1"></i> Quote Pengajar:
                                </small>
                                <p id="modalQuote" class="small fst-italic text-dark mb-0"></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 p-3 bg-white justify-content-between">
                <div class="small text-muted">
                    <i class="fa-solid fa-shield-halved text-success me-1"></i> Tenaga Pengajar Resmi RBQ Al Fatih
                </div>
                <button type="button" class="btn btn-secondary rounded-pill btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

<!-- Styling Tambahan Khusus Kartu Pengajar -->
<style>
    .teacher-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }
    .teacher-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px -10px rgba(15, 118, 110, 0.2) !important;
        border-color: #0f766e;
    }
    .btn-outline-emerald {
        color: #0f766e;
        border-color: #0f766e;
        background: transparent;
        transition: all 0.2s;
    }
    .btn-outline-emerald:hover {
        color: #ffffff;
        background-color: #0f766e;
    }
</style>

<!-- JavaScript Interaktif Modal Detail Pengajar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailButtons = document.querySelectorAll('.btn-detail-pengajar');
    const modal = new bootstrap.Modal(document.getElementById('modalDetailPengajar'));

    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            if (!id) return;

            // Fetch detail pengajar via AJAX
            fetch('<?= base_url("profil/ajax_detail_pengajar/"); ?>' + id)
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        const data = res.data;

                        document.getElementById('modalNama').textContent = data.nama;
                        document.getElementById('modalGelar').textContent = data.gelar ? data.gelar : '';
                        document.getElementById('modalJabatanBadge').textContent = data.jabatan;
                        document.getElementById('modalPendidikan').textContent = data.pendidikan;
                        document.getElementById('modalPengalaman').textContent = data.pengalaman;
                        document.getElementById('modalQuote').textContent = data.quote ? ('"' + data.quote + '"') : '"Mendidik generasi pecinta Al-Quran dengan ikhlas dan teladan."';

                        // Avatar
                        const avatarBox = document.getElementById('modalAvatarBox');
                        if (data.foto) {
                            avatarBox.innerHTML = '<img src="<?= base_url('uploads/pengajar/'); ?>' + data.foto + '" class="rounded-circle object-fit-cover w-100 h-100" alt="' + data.nama + '">';
                        } else {
                            const iconClass = data.jenis_kelamin === 'L' ? 'fa-user-tie' : 'fa-user-nurse';
                            avatarBox.innerHTML = '<i class="fa-solid ' + iconClass + '"></i>';
                        }

                        // Sertifikasi (pisahkan koma jika ada)
                        const sertifBox = document.getElementById('modalSertifikasiBox');
                        if (data.sertifikasi) {
                            const sertifList = data.sertifikasi.split(',').map(s => s.trim()).filter(s => s.length > 0);
                            let sertifHtml = '<ul class="list-unstyled mb-0">';
                            sertifList.forEach(s => {
                                sertifHtml += '<li class="mb-2 d-flex align-items-start gap-2"><i class="fa-solid fa-award text-success mt-1"></i> <span>' + s + '</span></li>';
                            });
                            sertifHtml += '</ul>';
                            sertifBox.innerHTML = sertifHtml;
                        } else {
                            sertifBox.innerHTML = '<span class="text-muted fst-italic">Informasi sertifikasi belum ditambahkan.</span>';
                        }

                        // Skill Badges
                        const badgesBox = document.getElementById('modalBadgesBox');
                        badgesBox.innerHTML = '';
                        if (data.spesialisasi) {
                            const badges = data.spesialisasi.split(',').map(b => b.trim()).filter(b => b.length > 0);
                            badges.forEach(b => {
                                const badgeEl = document.createElement('span');
                                badgeEl.className = 'badge bg-light text-dark border rounded-pill px-2 py-1 small';
                                badgeEl.innerHTML = '<i class="fa-solid fa-check text-emerald me-1"></i>' + b;
                                badgesBox.appendChild(badgeEl);
                            });
                        }

                        // Tampilkan modal
                        modal.show();
                    } else {
                        alert(res.message || 'Gagal mengambil detail profil.');
                    }
                })
                .catch(err => {
                    console.error('Error fetching detail pengajar:', err);
                    alert('Terjadi kesalahan saat memuat data profil pengajar.');
                });
        });
    });
});
</script>
