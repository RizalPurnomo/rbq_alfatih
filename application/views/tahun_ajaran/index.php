<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-calendar-days text-success me-2"></i> Tahun Ajaran & Semester
        </h3>
        <p class="text-muted small mb-0">Kelola periode akademik dan tentukan semester aktif sebagai acuan data santri, kelas, dan raport.</p>
    </div>
    <div>
        <button type="button" class="btn btn-success rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahTA">
            <i class="fa-solid fa-plus me-1"></i> Tambah Tahun Ajaran
        </button>
    </div>
</div>

<div class="row g-4">
    <!-- Semester Aktif Saat Ini -->
    <div class="col-lg-12">
        <div class="card-custom p-4 border-start border-4 border-success bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success text-white p-3 rounded-circle">
                        <i class="fa-solid fa-calendar-check fa-2x"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold">Periode Aktif Operasional Sistem</small>
                        <h4 class="fw-bold text-dark mb-0">
                            Tahun Ajaran <?= isset($current_ta->nama) ? htmlspecialchars($current_ta->nama) : '2026/2027'; ?> 
                            &bull; Semester <span class="text-primary text-uppercase"><?= isset($current_semester->tipe) ? htmlspecialchars($current_semester->tipe) : 'Ganjil'; ?></span>
                        </h4>
                    </div>
                </div>
                <div>
                    <span class="badge bg-success px-3 py-2 rounded-pill fs-6"><i class="fa-solid fa-check me-1"></i> Sedang Berjalan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Semester & Tahun Ajaran -->
    <div class="col-lg-12">
        <div class="card-custom p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list-check text-primary me-2"></i> Daftar Semester Akademik</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Rentang Tanggal</th>
                            <th>Status Operasional</th>
                            <th style="width: 20%;" class="text-center">Aksi Pengaturan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($daftar_semester)): ?>
                            <?php $no = 1; foreach ($daftar_semester as $sem): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <strong class="text-dark">TA <?= htmlspecialchars($sem->nama_tahun_ajaran); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge <?= ($sem->tipe === 'ganjil') ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-dark'; ?> text-uppercase px-3 py-1 rounded-pill fw-bold">
                                            Semester <?= htmlspecialchars($sem->tipe); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('d M Y', strtotime($sem->tanggal_mulai)); ?> s.d. <?= date('d M Y', strtotime($sem->tanggal_selesai)); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php if ($sem->is_aktif == 1): ?>
                                            <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Aktif Sebagai Acuan</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($sem->is_aktif == 0): ?>
                                            <a href="<?= base_url('tahun_ajaran/set_aktif_semester/' . $sem->id); ?>" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="return confirm('Jadikan semester ini sebagai acuan aktif sistem?')">
                                                <i class="fa-solid fa-circle-check me-1"></i> Aktifkan Semester Ini
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-success rounded-pill px-3" disabled>
                                                <i class="fa-solid fa-check-double me-1"></i> Semester Terpilih
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
    </div>
</div>

<!-- Modal Tambah TA -->
<div class="modal fade" id="modalTambahTA" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('tahun_ajaran/simpan_ta'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-success"><i class="fa-solid fa-calendar-plus me-2"></i> Tambah Tahun Ajaran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Tahun Ajaran <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: 2027/2028" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="<?= date('Y-07-01'); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="<?= date('Y-06-30', strtotime('+1 year')); ?>" required>
                </div>
                <small class="text-muted d-block">
                    *Sistem akan otomatis membuat 2 semester (Ganjil & Genap) untuk tahun ajaran baru ini.
                </small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan Tahun Ajaran</button>
            </div>
        </form>
    </div>
</div>
