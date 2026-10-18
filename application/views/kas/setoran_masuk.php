<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-hand-holding-dollar text-success me-2"></i> Verifikasi Setoran Kas Kelas
        </h3>
        <p class="text-muted small mb-0">Konfirmasi penerimaan setoran uang kas bulanan dari ustadz/ustadzah wali kelas ke Kas Utama.</p>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Kelas</th>
                    <th>Wali Kelas Penyetor</th>
                    <th>Periode</th>
                    <th>SPP</th>
                    <th>Infaq</th>
                    <th>Tabungan</th>
                    <th>Total Setoran</th>
                    <th>Status</th>
                    <th style="width: 15%;" class="text-center">Aksi Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_setoran)): ?>
                    <?php $no = 1; foreach ($daftar_setoran as $ds): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($ds->nama_kelas); ?></td>
                            <td><?= htmlspecialchars($ds->nama_penyetor); ?></td>
                            <td>Bulan <?= $ds->bulan; ?>/<?= $ds->tahun; ?></td>
                            <td class="text-success fw-semibold">Rp <?= number_format($ds->total_spp, 0, ',', '.'); ?></td>
                            <td class="text-primary">Rp <?= number_format($ds->total_infaq, 0, ',', '.'); ?></td>
                            <td class="text-warning fw-semibold">Rp <?= number_format($ds->total_tabungan, 0, ',', '.'); ?></td>
                            <td class="fw-bold text-dark">
                                Rp <?= number_format($ds->total_spp + $ds->total_infaq + $ds->total_tabungan, 0, ',', '.'); ?>
                            </td>
                            <td>
                                <?php if ($ds->status === 'diterima'): ?>
                                    <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Diterima</span>
                                    <small class="text-muted d-block"><?= htmlspecialchars($ds->nama_penerima ?: 'Keuangan'); ?></small>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> Menunggu Verifikasi</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($ds->status === 'pending'): ?>
                                    <a href="<?= base_url('kas/konfirmasi_setor/' . $ds->id); ?>" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Konfirmasi bahwa dana setoran ini telah fisik/transfer diterima di Kas Utama?')">
                                        <i class="fa-solid fa-circle-check me-1"></i> Terima Setoran
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-light border rounded-pill px-3 text-muted" disabled>
                                        <i class="fa-solid fa-check-double me-1"></i> Terverifikasi
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
