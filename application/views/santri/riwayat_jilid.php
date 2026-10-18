<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-clock-rotate-left text-success me-2"></i> Riwayat Perubahan Jilid Santri
        </h3>
        <p class="text-muted small mb-0">Catatan perkembangan tingkatan jilid Metode Ummi seluruh santri dari waktu ke waktu.</p>
    </div>
</div>

<!-- Filter Semester -->
<div class="card-custom p-3 p-md-4 mb-4">
    <form action="<?= base_url('santri/riwayat_jilid'); ?>" method="GET" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label small fw-bold text-muted">Filter Berdasarkan Semester</label>
            <select name="semester_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- Semua Periode Semester --</option>
                <?php if (!empty($daftar_semester)): ?>
                    <?php foreach ($daftar_semester as $sem): ?>
                        <option value="<?= $sem->id; ?>" <?= ($filter_semester == $sem->id) ? 'selected' : ''; ?>>
                            TA <?= htmlspecialchars($sem->nama_tahun_ajaran); ?> - Semester <?= ucfirst(htmlspecialchars($sem->tipe)); ?> <?= ($sem->is_aktif == 1) ? '(Aktif)' : ''; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-md-3">
            <a href="<?= base_url('santri/riwayat_jilid'); ?>" class="btn btn-sm btn-light border rounded-pill px-3">
                Reset Filter
            </a>
        </div>
    </form>
</div>

<!-- Table Riwayat Jilid -->
<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Santri</th>
                    <th>Tanggal Perubahan</th>
                    <th>Tingkatan Jilid Baru</th>
                    <th>Tahun Ajaran & Semester</th>
                    <th>Catatan / Keterangan</th>
                    <th style="width: 10%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_riwayat)): ?>
                    <?php $no = 1; foreach ($daftar_riwayat as $r): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <a href="<?= base_url('santri/detail/' . $r->santri_id); ?>" class="fw-bold text-dark text-decoration-none">
                                    <?= htmlspecialchars($r->nama_santri); ?>
                                </a>
                            </td>
                            <td><?= date('d F Y', strtotime($r->tanggal_perubahan)); ?></td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-bold">
                                    <?= htmlspecialchars($r->nama_kelompok); ?>
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">TA <?= htmlspecialchars($r->nama_tahun_ajaran); ?></span><br>
                                <span class="badge bg-primary-subtle text-primary text-uppercase"><?= htmlspecialchars($r->tipe_semester); ?></span>
                            </td>
                            <td class="small text-secondary">
                                <?= htmlspecialchars($r->keterangan ?: '-'); ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('santri/detail/' . $r->santri_id); ?>" class="btn btn-sm btn-outline-info rounded-pill px-3" title="Lihat Profil">
                                    <i class="fa-solid fa-eye me-1"></i> Profil
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
