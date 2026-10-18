<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-newspaper text-primary me-2"></i> Manajemen Event & Berita
        </h3>
        <p class="text-muted small mb-0">Publikasikan informasi kegiatan dan pengumuman ke Website Profil RBQ Al Fatih.</p>
    </div>
    <div>
        <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBerita">
            <i class="fa-solid fa-plus me-1"></i> Tulis Berita Baru
        </button>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Judul Berita / Event</th>
                    <th>Kategori</th>
                    <th>Tanggal Publish</th>
                    <th>Penulis</th>
                    <th style="width: 15%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_berita)): ?>
                    <?php $no = 1; foreach ($daftar_berita as $b): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <strong class="text-dark"><?= htmlspecialchars($b->judul); ?></strong>
                            </td>
                            <td>
                                <span class="badge <?= ($b->kategori === 'event') ? 'bg-warning text-dark' : 'bg-success'; ?> text-uppercase">
                                    <?= htmlspecialchars($b->kategori); ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($b->tanggal_publish)); ?></td>
                            <td class="small text-muted"><?= htmlspecialchars($b->nama_penulis); ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('berita/' . $b->slug); ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Lihat di Web">
                                    <i class="fa-solid fa-globe"></i>
                                </a>
                                <a href="<?= base_url('berita_admin/hapus/' . $b->id); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Hapus" onclick="return confirm('Hapus berita ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Berita -->
<div class="modal fade" id="modalTambahBerita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('berita_admin/simpan'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-pen-nib me-2"></i> Tulis Berita / Event Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Kegiatan Munaqasyah Santri Angkatan Ke-5" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Kategori Artikel <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select" required>
                            <option value="berita">Berita & Informasi</option>
                            <option value="event">Event & Agenda Kegiatan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Tanggal Publikasi</label>
                        <input type="date" name="tanggal_publish" class="form-control" value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Isi Konten Artikel <span class="text-danger">*</span></label>
                    <textarea name="konten" class="form-control" rows="6" placeholder="Tuliskan berita lengkap..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Publikasikan Berita</button>
            </div>
        </form>
    </div>
</div>
