<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-cash-register text-success me-2"></i> Input Pembayaran Santri
        </h3>
        <p class="text-muted small mb-0">Catat pembayaran bulanan santri: SPP (tetap), Infaq (bebas), dan Tabungan (bebas).</p>
    </div>
    <div>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
            Tarif SPP Aktif: Rp <?= number_format($nominal_spp, 0, ',', '.'); ?> / Bulan
        </span>
    </div>
</div>

<!-- Filter Kelas & Periode Bulan/Tahun -->
<div class="card-custom p-3 p-md-4 mb-4">
    <form action="<?= base_url('kas/pembayaran'); ?>" method="GET" class="row g-3 align-items-end">
        <?php if ($this->session->userdata('role') === 'admin'): ?>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Pilih Kelas</label>
                <select name="kelas_id" class="form-select form-select-sm" required onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    <?php if (!empty($daftar_kelas)): ?>
                        <?php foreach ($daftar_kelas as $k): ?>
                            <option value="<?= $k->id; ?>" <?= ($kelas_id == $k->id) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($k->nama); ?> (<?= htmlspecialchars($k->nama_kelompok); ?> - Wali: <?= htmlspecialchars($k->nama_wali_kelas ?: '-'); ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        <?php else: ?>
            <input type="hidden" name="kelas_id" value="<?= $kelas_id; ?>">
        <?php endif; ?>

        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Bulan Pembayaran</label>
            <select name="bulan" class="form-select form-select-sm" onchange="this.form.submit()">
                <?php
                $nama_bulan = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                foreach ($nama_bulan as $num => $nama):
                ?>
                    <option value="<?= $num; ?>" <?= ($bulan_pilih == $num) ? 'selected' : ''; ?>><?= $nama; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label small fw-bold text-muted">Tahun</label>
            <input type="number" name="tahun" class="form-control form-control-sm" value="<?= $tahun_pilih; ?>" onchange="this.form.submit()">
        </div>

        <div class="col-md-3">
            <button type="button" class="btn btn-sm btn-success rounded-pill px-3 w-100" data-bs-toggle="modal" data-bs-target="#modalInputBayar" <?= empty($kelas_id) ? 'disabled' : ''; ?>>
                <i class="fa-solid fa-plus-circle me-1"></i> Catat Pembayaran
            </button>
        </div>
    </form>
</div>

<!-- Ringkasan Kas Kelas Belum Disetor -->
<?php if (!empty($kelas_id)): ?>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-custom p-3 border-start border-4 border-success">
                <small class="text-muted d-block fw-semibold">SPP Terhimpun</small>
                <h5 class="fw-bold text-success mb-0">Rp <?= number_format($rekap_belum_setor['total_spp'], 0, ',', '.'); ?></h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-3 border-start border-4 border-primary">
                <small class="text-muted d-block fw-semibold">Infaq Santri</small>
                <h5 class="fw-bold text-primary mb-0">Rp <?= number_format($rekap_belum_setor['total_infaq'], 0, ',', '.'); ?></h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-3 border-start border-4 border-warning">
                <small class="text-muted d-block fw-semibold">Tabungan Masuk</small>
                <h5 class="fw-bold text-warning mb-0">Rp <?= number_format($rekap_belum_setor['total_tabungan'], 0, ',', '.'); ?></h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-3 border-start border-4 border-dark">
                <small class="text-muted d-block fw-semibold">Total Kas Belum Disetor</small>
                <h5 class="fw-bold text-dark mb-0">Rp <?= number_format($rekap_belum_setor['total_kas'], 0, ',', '.'); ?></h5>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Tabel Riwayat Pembayaran Bulan Ini -->
<div class="card-custom p-4">
    <h5 class="fw-bold text-dark mb-3">
        <i class="fa-solid fa-receipt text-primary me-2"></i> Daftar Pembayaran Santri (<?= $nama_bulan[$bulan_pilih]; ?> <?= $tahun_pilih; ?>)
    </h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Santri</th>
                    <th>Tgl Bayar</th>
                    <th>SPP (Tetap)</th>
                    <th>Infaq</th>
                    <th>Tabungan</th>
                    <th>Total Dibayar</th>
                    <th>Status Setor</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($riwayat_bayar)): ?>
                    <?php $no = 1; foreach ($riwayat_bayar as $rb): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($rb->nama_santri); ?></td>
                            <td><?= date('d/m/Y', strtotime($rb->tanggal_bayar)); ?></td>
                            <td class="text-success fw-semibold">Rp <?= number_format($rb->nominal_spp, 0, ',', '.'); ?></td>
                            <td class="text-primary">Rp <?= number_format($rb->nominal_infaq, 0, ',', '.'); ?></td>
                            <td class="text-warning fw-semibold">Rp <?= number_format($rb->nominal_tabungan, 0, ',', '.'); ?></td>
                            <td class="fw-bold text-dark">
                                Rp <?= number_format($rb->nominal_spp + $rb->nominal_infaq + $rb->nominal_tabungan, 0, ',', '.'); ?>
                            </td>
                            <td>
                                <?php if ($rb->status_setor === 'sudah_setor'): ?>
                                    <span class="badge bg-success">Sudah Disetor</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Belum Disetor</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Input Pembayaran -->
<div class="modal fade" id="modalInputBayar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('kas/simpan_pembayaran'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-success"><i class="fa-solid fa-cash-register me-2"></i> Catat Pembayaran Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="kelas_id" value="<?= $kelas_id; ?>">
                <input type="hidden" name="bulan" value="<?= $bulan_pilih; ?>">
                <input type="hidden" name="tahun" value="<?= $tahun_pilih; ?>">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Pilih Santri <span class="text-danger">*</span></label>
                    <select name="santri_id" class="form-select" required>
                        <option value="">-- Pilih Santri --</option>
                        <?php if (!empty($daftar_santri)): ?>
                            <?php foreach ($daftar_santri as $st): ?>
                                <option value="<?= $st->id; ?>"><?= htmlspecialchars($st->nama_lengkap); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Pembayaran <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_bayar" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">1. Nominal SPP (Tetap) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="nominal_spp" class="form-control" value="<?= (int)$nominal_spp; ?>" required>
                    </div>
                    <small class="text-muted">Nominal baku SPP bulanan santri.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">2. Nominal Infaq (Bebas / Sukarela)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="nominal_infaq" class="form-control" placeholder="0" min="0">
                    </div>
                    <small class="text-muted">Infaq sukarela wali santri (bergabung dengan kas infaq utama).</small>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">3. Nominal Tabungan Santri (Bebas)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="nominal_tabungan" class="form-control" placeholder="0" min="0">
                    </div>
                    <small class="text-muted">Otomatis dicatat ke Modul Tabungan dan dapat diambil kembali oleh santri.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan Pembayaran</button>
            </div>
        </form>
    </div>
</div>
