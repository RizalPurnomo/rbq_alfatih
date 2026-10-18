<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-heart-circle-plus text-primary me-2"></i> Penerimaan Donasi Umum
        </h3>
        <p class="text-muted small mb-0">Catat sumbangan sukarela dari para donatur yang otomatis digabungkan dengan Kas Infaq Utama.</p>
    </div>
    <?php if ($this->session->userdata('role') === 'keuangan'): ?>
        <div>
            <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDonasi">
                <i class="fa-solid fa-plus me-1"></i> Catat Donasi Baru
            </button>
        </div>
    <?php endif; ?>
</div>

<!-- Table Donasi -->
<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Donatur / Hamba Allah</th>
                    <th>Tanggal Donasi</th>
                    <th>Nominal</th>
                    <th>Keterangan / Akad</th>
                    <th>Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_donasi)): ?>
                    <?php $no = 1; foreach ($daftar_donasi as $d): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($d->nama_donatur); ?></td>
                            <td><?= date('d/m/Y', strtotime($d->tanggal)); ?></td>
                            <td class="text-success fw-bold">Rp <?= number_format($d->nominal, 0, ',', '.'); ?></td>
                            <td class="small text-secondary"><?= htmlspecialchars($d->keterangan ?: 'Infaq / Sedekah operasional'); ?></td>
                            <td class="small text-muted"><?= htmlspecialchars($d->nama_pencatat); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Donasi -->
<div class="modal fade" id="modalDonasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('kas/simpan_donasi'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-heart-circle-plus me-2"></i> Input Donasi Donatur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Donatur <span class="text-danger">*</span></label>
                    <input type="text" name="nama_donatur" class="form-control" placeholder="Nama Donatur atau Hamba Allah" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nominal Donasi (Bebas) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="nominal" class="form-control" placeholder="0" min="1" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Diterima <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Keterangan / Akad Sedekah</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Donasi perlengkapan meja belajar santri, dll."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Donasi</button>
            </div>
        </form>
    </div>
</div>
