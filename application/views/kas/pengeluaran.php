<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-money-bill-transfer text-danger me-2"></i> Pengeluaran Kas Utama
        </h3>
        <p class="text-muted small mb-0">Catat pengeluaran kas resmi: Bisyaroh Guru (dari Kas SPP) dan Operasional/Pokja/Buku (dari Kas Infaq).</p>
    </div>
    <?php if ($this->session->userdata('role') === 'keuangan'): ?>
        <div>
            <button type="button" class="btn btn-danger rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPengeluaran">
                <i class="fa-solid fa-plus me-1"></i> Catat Pengeluaran Baru
            </button>
        </div>
    <?php endif; ?>
</div>

<!-- Info Saldo Kas Utama -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card-custom p-4 border-start border-4 border-success bg-white">
            <small class="text-muted fw-bold d-block mb-1">Saldo Kas SPP (Kas Utama)</small>
            <h3 class="fw-bold text-success mb-1">Rp <?= number_format($saldo_kas['saldo_spp'], 0, ',', '.'); ?></h3>
            <span class="badge bg-success-subtle text-success">Peruntukan: Pembayaran Bisyaroh Guru</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-custom p-4 border-start border-4 border-primary bg-white">
            <small class="text-muted fw-bold d-block mb-1">Saldo Kas Infaq & Donatur (Kas Utama)</small>
            <h3 class="fw-bold text-primary mb-1">Rp <?= number_format($saldo_kas['saldo_infaq'], 0, ',', '.'); ?></h3>
            <span class="badge bg-primary-subtle text-primary">Peruntukan: Kas Pokja, Beli Buku, Operasional</span>
        </div>
    </div>
</div>

<!-- Table Pengeluaran -->
<div class="card-custom p-4">
    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-file-invoice text-danger me-2"></i> Riwayat Pengeluaran Kas Utama</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Tanggal</th>
                    <th>Sumber Dana</th>
                    <th>Jenis Pengeluaran</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Dicatat Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_pengeluaran)): ?>
                    <?php $no = 1; foreach ($daftar_pengeluaran as $p): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d/m/Y', strtotime($p->tanggal)); ?></td>
                            <td>
                                <span class="badge <?= ($p->kategori_sumber === 'spp') ? 'bg-success' : 'bg-primary'; ?> text-uppercase">
                                    Kas <?= htmlspecialchars($p->kategori_sumber); ?>
                                </span>
                            </td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($p->jenis_pengeluaran); ?></td>
                            <td class="text-danger fw-bold">Rp <?= number_format($p->nominal, 0, ',', '.'); ?></td>
                            <td class="small text-secondary"><?= htmlspecialchars($p->keterangan ?: '-'); ?></td>
                            <td class="small text-muted"><?= htmlspecialchars($p->nama_pencatat); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Catat Pengeluaran -->
<div class="modal fade" id="modalPengeluaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('kas/simpan_pengeluaran'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-danger"><i class="fa-solid fa-money-bill-transfer me-2"></i> Catat Pengeluaran Kas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Sumber Dana Kas <span class="text-danger">*</span></label>
                    <select name="kategori_sumber" class="form-select" required>
                        <option value="spp">Kas SPP (Khusus Bisyaroh Guru)</option>
                        <option value="infaq">Kas Infaq & Donasi (Kas Pokja, Buku, Operasional)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Jenis / Nama Pengeluaran <span class="text-danger">*</span></label>
                    <input type="text" name="jenis_pengeluaran" class="form-control" placeholder="Contoh: Bisyaroh Ustadz Bulan Ini, Pembelian Buku Jilid 1-6" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nominal Pengeluaran <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="nominal" class="form-control" placeholder="0" min="1" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Transaksi <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan bukti kwitansi/nota"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Simpan Pengeluaran</button>
            </div>
        </form>
    </div>
</div>
