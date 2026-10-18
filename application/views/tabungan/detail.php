<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
    <div>
        <a href="<?= base_url('tabungan'); ?>" class="btn btn-sm btn-light border rounded-pill px-3 mb-2">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Rekap Tabungan
        </a>
        <h3 class="fw-bold text-dark mb-0">
            <i class="fa-solid fa-book-bookmark text-primary me-2"></i> Buku Tabungan: <?= htmlspecialchars($santri->nama_lengkap); ?>
        </h3>
    </div>
    <div>
        <button type="button" class="btn btn-warning rounded-pill px-4 fw-bold text-dark shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTarikTabungan" <?= ($saldo_saat_ini <= 0) ? 'disabled' : ''; ?>>
            <i class="fa-solid fa-hand-holding-dollar me-1"></i> Tarik / Ambil Tabungan
        </button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-5">
        <div class="card-custom p-4 bg-gradient-warning-subtle border-warning h-100" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
            <small class="text-muted fw-bold d-block mb-1">Total Saldo Tabungan Tersedia</small>
            <h2 class="display-6 fw-bold text-warning-emphasis mb-2">Rp <?= number_format($saldo_saat_ini, 0, ',', '.'); ?></h2>
            <p class="small text-secondary mb-0">Santri dapat mengambil tabungan sewaktu-waktu sesuai kebutuhan.</p>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card-custom p-4 h-100">
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-tag text-primary me-2"></i> Informasi Santri</h6>
            <div class="row g-2 small">
                <div class="col-sm-6">
                    <span class="text-muted d-block">Nama Wali:</span>
                    <strong><?= htmlspecialchars($santri->nama_wali); ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Kontak Wali:</span>
                    <strong><?= htmlspecialchars($santri->no_hp_wali ?: '-'); ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Kelas / Jilid:</span>
                    <strong><?= htmlspecialchars($santri->nama_kelas ?: '-'); ?> (<?= htmlspecialchars($santri->nama_kelompok ?: '-'); ?>)</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Wali Kelas:</span>
                    <strong><?= htmlspecialchars($santri->nama_wali_kelas ?: '-'); ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Mutasi Masuk & Keluar -->
<div class="card-custom p-4">
    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list-ol text-primary me-2"></i> Riwayat Mutasi Tabungan</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Tanggal</th>
                    <th>Jenis Mutasi</th>
                    <th>Nominal</th>
                    <th>Sisa Saldo Setelah Transaksi</th>
                    <th>Keterangan</th>
                    <th>Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($riwayat_mutasi)): ?>
                    <?php $no = 1; foreach ($riwayat_mutasi as $rm): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d/m/Y', strtotime($rm->tanggal)); ?></td>
                            <td>
                                <?php if ($rm->tipe === 'masuk'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                        <i class="fa-solid fa-arrow-down me-1"></i> Setoran Masuk
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill">
                                        <i class="fa-solid fa-arrow-up me-1"></i> Penarikan Keluar
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold <?= ($rm->tipe === 'masuk') ? 'text-success' : 'text-danger'; ?>">
                                <?= ($rm->tipe === 'masuk') ? '+' : '-'; ?> Rp <?= number_format($rm->nominal, 0, ',', '.'); ?>
                            </td>
                            <td class="fw-bold text-dark">Rp <?= number_format($rm->saldo_setelah, 0, ',', '.'); ?></td>
                            <td class="small text-secondary"><?= htmlspecialchars($rm->keterangan ?: '-'); ?></td>
                            <td class="small text-muted"><?= htmlspecialchars($rm->nama_pencatat); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Penarikan Tabungan -->
<div class="modal fade" id="modalTarikTabungan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('tabungan/proses_tarik'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-warning-emphasis"><i class="fa-solid fa-hand-holding-dollar me-2"></i> Penarikan Tabungan Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="santri_id" value="<?= $santri->id; ?>">

                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <small class="text-muted d-block">Saldo Tersedia:</small>
                    <strong class="text-success fs-5">Rp <?= number_format($saldo_saat_ini, 0, ',', '.'); ?></strong>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nominal Penarikan <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="nominal" class="form-control" max="<?= (int)$saldo_saat_ini; ?>" min="1" placeholder="Masukkan jumlah uang yang ditarik" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Pengambilan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Keperluan / Keterangan Penarikan <span class="text-danger">*</span></label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Pembelian perlengkapan wisuda, kebutuhan santri, dll." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning text-dark fw-bold">Konfirmasi Penarikan</button>
            </div>
        </form>
    </div>
</div>
