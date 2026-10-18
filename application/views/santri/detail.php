<div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
    <div>
        <a href="<?= base_url('santri'); ?>" class="btn btn-sm btn-light border rounded-pill px-3 mb-2">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Santri
        </a>
        <h3 class="fw-bold text-dark mb-0">
            <?= htmlspecialchars($santri->nama_lengkap); ?>
            <?php if ($santri->status === 'aktif'): ?>
                <span class="badge bg-success fs-6 align-middle ms-2">Aktif</span>
            <?php else: ?>
                <span class="badge bg-danger fs-6 align-middle ms-2">Keluar</span>
            <?php endif; ?>
        </h3>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-success rounded-pill px-3 btn-sm" data-bs-toggle="modal" data-bs-target="#modalNaikJilid">
            <i class="fa-solid fa-arrow-trend-up me-1"></i> Catat Kenaikan Jilid
        </button>
        <a href="<?= base_url('santri/edit/' . $santri->id); ?>" class="btn btn-warning rounded-pill px-3 btn-sm text-dark">
            <i class="fa-solid fa-pen-to-square me-1"></i> Edit Data
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Kolom Kiri: Ringkasan Santri -->
    <div class="col-lg-4">
        <div class="card-custom p-4 text-center mb-4">
            <div class="bg-success-subtle text-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="fa-solid fa-user-graduate fa-3x"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($santri->nama_lengkap); ?></h5>
            <p class="text-muted small mb-3">Panggilan: <strong><?= htmlspecialchars($santri->nama_panggilan ?: '-'); ?></strong></p>

            <div class="p-3 bg-light rounded-3 text-start mb-3 border">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Kelompok / Jilid:</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold">
                        <?= htmlspecialchars($santri->nama_kelompok ?: 'Belum Ada'); ?>
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Kelas:</span>
                    <span class="fw-bold text-dark small"><?= htmlspecialchars($santri->nama_kelas ?: '-'); ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small">Wali Kelas:</span>
                    <span class="small text-muted"><?= htmlspecialchars($santri->nama_wali_kelas ?: '-'); ?></span>
                </div>
            </div>

            <?php if ($santri->status === 'keluar'): ?>
                <div class="alert alert-danger p-3 small text-start rounded-3 mb-0">
                    <strong>Informasi Keluar:</strong><br>
                    Tanggal: <?= date('d M Y', strtotime($santri->tanggal_keluar)); ?><br>
                    Alasan: <?= htmlspecialchars($santri->alasan_keluar); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-custom p-4">
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-id-badge text-primary me-2"></i> Biodata Lengkap</h6>
            <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                <li class="d-flex justify-content-between border-bottom pb-2">
                    <span class="text-muted">Jenis Kelamin:</span>
                    <span class="fw-semibold"><?= ($santri->jenis_kelamin === 'L') ? 'Laki-laki' : 'Perempuan'; ?></span>
                </li>
                <li class="d-flex justify-content-between border-bottom pb-2">
                    <span class="text-muted">Tempat, Tgl Lahir:</span>
                    <span class="fw-semibold">
                        <?= htmlspecialchars($santri->tempat_lahir ?: '-'); ?>, <?= !empty($santri->tanggal_lahir) ? date('d/m/Y', strtotime($santri->tanggal_lahir)) : '-'; ?>
                    </span>
                </li>
                <li class="d-flex justify-content-between border-bottom pb-2">
                    <span class="text-muted">Nama Orang Tua/Wali:</span>
                    <span class="fw-semibold"><?= htmlspecialchars($santri->nama_wali); ?></span>
                </li>
                <li class="d-flex justify-content-between border-bottom pb-2">
                    <span class="text-muted">No. HP/WA Wali:</span>
                    <span class="fw-semibold"><?= htmlspecialchars($santri->no_hp_wali ?: '-'); ?></span>
                </li>
                <li class="d-flex justify-content-between border-bottom pb-2">
                    <span class="text-muted">Tanggal Masuk RBQ:</span>
                    <span class="fw-semibold"><?= date('d M Y', strtotime($santri->tanggal_masuk)); ?></span>
                </li>
                <li class="pt-1">
                    <span class="text-muted d-block mb-1">Alamat:</span>
                    <span class="fw-semibold"><?= nl2br(htmlspecialchars($santri->alamat ?: '-')); ?></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Kolom Kanan: Histori Riwayat Jilid -->
    <div class="col-lg-8">
        <div class="card-custom p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-clock-rotate-left text-success me-2"></i> Riwayat Perubahan Jilid Santri
                </h5>
                <span class="badge bg-light text-muted border">Metode Ummi</span>
            </div>
            <p class="small text-muted mb-4">
                Setiap kenaikan tingkat jilid tercatat secara kronologis beserta periode tahun ajaran dan semester aktif.
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Tanggal Kenaikan</th>
                            <th>Tingkatan Jilid</th>
                            <th>Periode Semester</th>
                            <th>Keterangan / Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($riwayat_jilid)): ?>
                            <?php $no = 1; foreach ($riwayat_jilid as $rj): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td class="fw-semibold"><?= date('d F Y', strtotime($rj->tanggal_perubahan)); ?></td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-bold">
                                            <?= htmlspecialchars($rj->nama_kelompok); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-dark fw-semibold">TA <?= htmlspecialchars($rj->nama_tahun_ajaran); ?></small><br>
                                        <small class="badge bg-primary-subtle text-primary text-uppercase"><?= htmlspecialchars($rj->tipe_semester); ?></small>
                                    </td>
                                    <td class="small text-secondary">
                                        <?= htmlspecialchars($rj->keterangan ?: 'Kenaikan Jilid'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat jilid yang tercatat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Naik Jilid -->
<div class="modal fade" id="modalNaikJilid" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('santri/naik_jilid'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-success"><i class="fa-solid fa-arrow-trend-up me-2"></i> Catat Kenaikan Jilid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="santri_id" value="<?= $santri->id; ?>">

                <p class="small text-muted mb-3">Catat hasil munaqasyah / evaluasi kenaikan tingkat jilid Metode Ummi untuk santri <strong><?= htmlspecialchars($santri->nama_lengkap); ?></strong>.</p>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tingkat Jilid Baru <span class="text-danger">*</span></label>
                    <select name="kelompok_id" class="form-select" required>
                        <option value="">-- Pilih Jilid Baru --</option>
                        <?php if (!empty($daftar_kelompok)): ?>
                            <?php foreach ($daftar_kelompok as $klp): ?>
                                <option value="<?= $klp->id; ?>" <?= ($santri->kelompok_id == $klp->id) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($klp->nama); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Kenaikan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_perubahan" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Catatan Hasil Evaluasi</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Lulus evaluasi tartil munaqasyah jilid 2, makhraj fasih."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan Kenaikan Jilid</button>
            </div>
        </form>
    </div>
</div>
