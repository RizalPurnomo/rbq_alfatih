<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-money-bill-wave text-warning me-2"></i> Setor Kas ke Kas Utama
        </h3>
        <p class="text-muted small mb-0">Setorkan seluruh dana pembayaran santri yang telah dihimpun di kelas ke Kas Utama RBQ Al Fatih.</p>
    </div>
</div>

<?php if (!empty($kelas)): ?>
    <div class="row g-4 mb-4">
        <!-- Card Pengajuan Setoran -->
        <div class="col-lg-5">
            <div class="card-custom p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-paper-plane text-success me-2"></i> Pengajuan Setoran Bulan Ini</h5>

                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Kelas:</span>
                        <strong class="text-dark small"><?= htmlspecialchars($kelas->nama); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Periode Pembayaran:</span>
                        <span class="badge bg-primary text-uppercase"><?= date('F Y'); ?></span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Total Kas SPP:</span>
                        <span class="fw-semibold text-success small">Rp <?= number_format($rekap['total_spp'], 0, ',', '.'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Total Infaq Santri:</span>
                        <span class="fw-semibold text-primary small">Rp <?= number_format($rekap['total_infaq'], 0, ',', '.'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Total Tabungan Santri:</span>
                        <span class="fw-semibold text-warning small">Rp <?= number_format($rekap['total_tabungan'], 0, ',', '.'); ?></span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between">
                        <strong class="text-dark">Total Dana Disetor:</strong>
                        <strong class="text-dark fs-5">Rp <?= number_format($rekap['total_kas'], 0, ',', '.'); ?></strong>
                    </div>
                </div>

                <?php if ($rekap['total_kas'] > 0): ?>
                    <form action="<?= base_url('kas/simpan_setor'); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetorkan dana sebesar Rp <?= number_format($rekap['total_kas'], 0, ',', '.'); ?> ke Kas Utama?')">
                        <input type="hidden" name="kelas_id" value="<?= $kelas->id; ?>">
                        <input type="hidden" name="bulan" value="<?= $bulan; ?>">
                        <input type="hidden" name="tahun" value="<?= $tahun; ?>">
                        <input type="hidden" name="total_spp" value="<?= $rekap['total_spp']; ?>">
                        <input type="hidden" name="total_infaq" value="<?= $rekap['total_infaq']; ?>">
                        <input type="hidden" name="total_tabungan" value="<?= $rekap['total_tabungan']; ?>">

                        <button type="submit" class="btn btn-warning w-100 rounded-pill py-2 fw-bold text-dark shadow-sm">
                            <i class="fa-solid fa-paper-plane me-1"></i> Setorkan ke Kas Utama Sekarang
                        </button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-secondary small text-center mb-0 rounded-pill">
                        Tidak ada dana yang belum disetor untuk periode ini.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tabel Riwayat Setoran -->
        <div class="col-lg-7">
            <div class="card-custom p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Histori Setoran Kelas</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle datatable w-100">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Setor</th>
                                <th>Bulan / Tahun</th>
                                <th>Total Dana</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($riwayat_setor)): ?>
                                <?php $no = 1; foreach ($riwayat_setor as $rs): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= date('d/m/Y', strtotime($rs->tanggal_setor)); ?></td>
                                        <td>Bulan <?= $rs->bulan; ?>/<?= $rs->tahun; ?></td>
                                        <td class="fw-bold text-dark">
                                            Rp <?= number_format($rs->total_spp + $rs->total_infaq + $rs->total_tabungan, 0, ',', '.'); ?>
                                        </td>
                                        <td>
                                            <?php if ($rs->status === 'diterima'): ?>
                                                <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Diterima Keuangan</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> Menunggu Konfirmasi</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="card-custom p-5 text-center text-muted">
        <i class="fa-solid fa-chalkboard-user fa-3x mb-3 text-secondary"></i>
        <h5>Anda Belum Ditugaskan Sebagai Wali Kelas</h5>
        <p class="small">Silakan hubungi Administrator untuk penempatan kelas binaan Anda.</p>
    </div>
<?php endif; ?>
