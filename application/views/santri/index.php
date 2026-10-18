<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-users text-success me-2"></i> Data Santri RBQ Al Fatih
        </h3>
        <p class="text-muted small mb-0">Kelola informasi santri aktif, penempatan kelas, dan santri keluar.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('santri/tambah'); ?>" class="btn btn-success rounded-pill px-3 shadow-sm">
            <i class="fa-solid fa-user-plus me-1"></i> Tambah Santri Baru
        </a>
    </div>
</div>

<!-- Filter Box -->
<div class="card-custom p-3 p-md-4 mb-4">
    <form action="<?= base_url('santri'); ?>" method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Status Santri</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="aktif" <?= ($filter_status === 'aktif') ? 'selected' : ''; ?>>Santri Aktif</option>
                <option value="keluar" <?= ($filter_status === 'keluar') ? 'selected' : ''; ?>>Santri Keluar</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Filter Kelompok / Jilid</label>
            <select name="kelompok_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- Semua Kelompok / Jilid --</option>
                <?php if (!empty($daftar_kelompok)): ?>
                    <?php foreach ($daftar_kelompok as $klp): ?>
                        <option value="<?= $klp->id; ?>" <?= ($filter_kelompok == $klp->id) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($klp->nama); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Filter Kelas</label>
            <select name="kelas_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- Semua Kelas --</option>
                <?php if (!empty($daftar_kelas)): ?>
                    <?php foreach ($daftar_kelas as $kls): ?>
                        <option value="<?= $kls->id; ?>" <?= ($filter_kelas == $kls->id) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($kls->nama); ?> (<?= htmlspecialchars($kls->nama_kelompok); ?>)
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 flex-grow-1">
                <i class="fa-solid fa-filter me-1"></i> Terapkan
            </button>
            <a href="<?= base_url('santri'); ?>" class="btn btn-sm btn-light border rounded-pill px-3">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Table Data Santri -->
<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Santri</th>
                    <th>L/P</th>
                    <th>Kelompok / Jilid</th>
                    <th>Kelas & Wali Kelas</th>
                    <th>Wali Santri / No HP</th>
                    <th>Status</th>
                    <th style="width: 15%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_santri)): ?>
                    <?php $no = 1; foreach ($daftar_santri as $s): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <a href="<?= base_url('santri/detail/' . $s->id); ?>" class="fw-bold text-dark text-decoration-none">
                                    <?= htmlspecialchars($s->nama_lengkap); ?>
                                </a>
                                <?php if (!empty($s->nama_panggilan)): ?>
                                    <small class="text-muted d-block">(<?= htmlspecialchars($s->nama_panggilan); ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?= ($s->jenis_kelamin === 'L') ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger'; ?>">
                                    <?= ($s->jenis_kelamin === 'L') ? 'Laki-laki' : 'Perempuan'; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                    <?= !empty($s->nama_kelompok) ? htmlspecialchars($s->nama_kelompok) : '<em class="text-muted">Belum ada</em>'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($s->nama_kelas)): ?>
                                    <div class="fw-semibold text-dark"><?= htmlspecialchars($s->nama_kelas); ?></div>
                                    <small class="text-muted"><i class="fa-solid fa-chalkboard-user me-1"></i> <?= htmlspecialchars($s->nama_wali_kelas ?: 'Belum ditugaskan'); ?></small>
                                <?php else: ?>
                                    <span class="text-muted small"><em>Belum masuk kelas</em></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= htmlspecialchars($s->nama_wali); ?></div>
                                <small class="text-muted"><?= htmlspecialchars($s->no_hp_wali ?: '-'); ?></small>
                            </td>
                            <td>
                                <?php if ($s->status === 'aktif'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Keluar</span>
                                    <?php if (!empty($s->tanggal_keluar)): ?>
                                        <small class="d-block text-muted"><?= date('d/m/Y', strtotime($s->tanggal_keluar)); ?></small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('santri/detail/' . $s->id); ?>" class="btn btn-outline-info" title="Lihat Profil">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('santri/edit/' . $s->id); ?>" class="btn btn-outline-warning" title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <?php if ($s->status === 'aktif'): ?>
                                        <button type="button" class="btn btn-outline-danger" title="Tandai Keluar" onclick="modalKeluar(<?= $s->id; ?>, '<?= htmlspecialchars(addslashes($s->nama_lengkap)); ?>')">
                                            <i class="fa-solid fa-user-xmark"></i>
                                        </button>
                                    <?php else: ?>
                                        <a href="<?= base_url('santri/aktifkan/' . $s->id); ?>" class="btn btn-outline-success" title="Aktifkan Kembali" onclick="return confirm('Aktifkan kembali santri ini?')">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Santri Keluar -->
<div class="modal fade" id="modalKeluarSantri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('santri/keluar'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-danger"><i class="fa-solid fa-user-xmark me-2"></i> Konfirmasi Santri Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="santri_id" id="keluar_santri_id">
                <p>Apakah Anda yakin menandai santri <strong id="keluar_nama_santri"></strong> sebagai santri keluar?</p>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Alasan Keluar</label>
                    <textarea name="alasan_keluar" class="form-control" rows="3" placeholder="Contoh: Pindah domisili luar kota, lulus, dll." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Tandai Santri Keluar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function modalKeluar(id, nama) {
        document.getElementById('keluar_santri_id').value = id;
        document.getElementById('keluar_nama_santri').innerText = nama;
        new bootstrap.Modal(document.getElementById('modalKeluarSantri')).show();
    }
</script>
