<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-chalkboard text-primary me-2"></i> Manajemen Kelas RBQ Al Fatih
        </h3>
        <p class="text-muted small mb-0">Kelola pembagian kelas santri per kelompok jilid dan penetapan Ustadz/Ustadzah Wali Kelas.</p>
    </div>
    <div>
        <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
            <i class="fa-solid fa-plus me-1"></i> Buat Kelas Baru
        </button>
    </div>
</div>

<!-- Filter Semester -->
<div class="card-custom p-3 p-md-4 mb-4">
    <form action="<?= base_url('kelas'); ?>" method="GET" class="row g-3 align-items-end">
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
            <a href="<?= base_url('kelas'); ?>" class="btn btn-sm btn-light border rounded-pill px-3">
                Reset Filter
            </a>
        </div>
    </form>
</div>

<!-- Table Data Kelas -->
<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Kelas</th>
                    <th>Kelompok / Jilid</th>
                    <th>Tahun Ajaran & Semester</th>
                    <th>Wali Kelas</th>
                    <th style="width: 15%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_kelas)): ?>
                    <?php $no = 1; foreach ($daftar_kelas as $k): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <strong class="text-dark"><?= htmlspecialchars($k->nama); ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-bold">
                                    <?= htmlspecialchars($k->nama_kelompok); ?>
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">TA <?= htmlspecialchars($k->nama_tahun_ajaran); ?></span><br>
                                <span class="badge bg-primary-subtle text-primary text-uppercase"><?= htmlspecialchars($k->tipe_semester); ?></span>
                            </td>
                            <td>
                                <?php if (!empty($k->nama_wali_kelas)): ?>
                                    <div class="fw-semibold text-dark"><i class="fa-solid fa-chalkboard-user text-success me-1"></i> <?= htmlspecialchars($k->nama_wali_kelas); ?></div>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary">Belum Ditugaskan</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-warning" title="Edit Kelas" onclick='editKelas(<?= json_encode($k); ?>)'>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <a href="<?= base_url('kelas/hapus/' . $k->id); ?>" class="btn btn-outline-danger" title="Hapus Kelas" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('kelas/simpan'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-plus-circle me-2"></i> Tambah Kelas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Kelas 1A, Jilid 2 Reguler" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Kelompok / Jilid Metode Ummi <span class="text-danger">*</span></label>
                    <select name="kelompok_id" class="form-select" required>
                        <option value="">-- Pilih Kelompok / Jilid --</option>
                        <?php if (!empty($daftar_kelompok)): ?>
                            <?php foreach ($daftar_kelompok as $klp): ?>
                                <option value="<?= $klp->id; ?>"><?= htmlspecialchars($klp->nama); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Semester <span class="text-danger">*</span></label>
                    <select name="semester_id" class="form-select" required>
                        <?php if (!empty($daftar_semester)): ?>
                            <?php foreach ($daftar_semester as $sem): ?>
                                <option value="<?= $sem->id; ?>" <?= ($sem->is_aktif == 1) ? 'selected' : ''; ?>>
                                    TA <?= htmlspecialchars($sem->nama_tahun_ajaran); ?> - Semester <?= ucfirst(htmlspecialchars($sem->tipe)); ?> <?= ($sem->is_aktif == 1) ? '(Aktif)' : ''; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tugaskan Wali Kelas (Ustadz/Ustadzah)</label>
                    <select name="wali_kelas_id" class="form-select">
                        <option value="">-- Pilih Wali Kelas --</option>
                        <?php if (!empty($daftar_wali_kelas)): ?>
                            <?php foreach ($daftar_wali_kelas as $wk): ?>
                                <option value="<?= $wk->id; ?>"><?= htmlspecialchars($wk->nama); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div class="modal fade" id="modalEditKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('kelas/update'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-warning"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="kelas_id" id="edit_kelas_id">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="edit_nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Kelompok / Jilid Metode Ummi <span class="text-danger">*</span></label>
                    <select name="kelompok_id" id="edit_kelompok_id" class="form-select" required>
                        <?php if (!empty($daftar_kelompok)): ?>
                            <?php foreach ($daftar_kelompok as $klp): ?>
                                <option value="<?= $klp->id; ?>"><?= htmlspecialchars($klp->nama); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Semester <span class="text-danger">*</span></label>
                    <select name="semester_id" id="edit_semester_id" class="form-select" required>
                        <?php if (!empty($daftar_semester)): ?>
                            <?php foreach ($daftar_semester as $sem): ?>
                                <option value="<?= $sem->id; ?>">
                                    TA <?= htmlspecialchars($sem->nama_tahun_ajaran); ?> - Semester <?= ucfirst(htmlspecialchars($sem->tipe)); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Wali Kelas</label>
                    <select name="wali_kelas_id" id="edit_wali_kelas_id" class="form-select">
                        <option value="">-- Belum Ditugaskan --</option>
                        <?php if (!empty($daftar_wali_kelas)): ?>
                            <?php foreach ($daftar_wali_kelas as $wk): ?>
                                <option value="<?= $wk->id; ?>"><?= htmlspecialchars($wk->nama); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning text-dark fw-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editKelas(k) {
        document.getElementById('edit_kelas_id').value = k.id;
        document.getElementById('edit_nama').value = k.nama;
        document.getElementById('edit_kelompok_id').value = k.kelompok_id;
        document.getElementById('edit_semester_id').value = k.semester_id;
        document.getElementById('edit_wali_kelas_id').value = k.wali_kelas_id || '';
        new bootstrap.Modal(document.getElementById('modalEditKelas')).show();
    }
</script>
