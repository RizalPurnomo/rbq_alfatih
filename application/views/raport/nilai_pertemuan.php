<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-pen-to-square text-success me-2"></i> Input Nilai Pertemuan Bulanan
        </h3>
        <p class="text-muted small mb-0">Input evaluasi capaian bacaan dan tartil santri pada setiap pertemuan belajar per bulan.</p>
    </div>
</div>

<!-- Filter Kelas, Bulan, dan Pertemuan -->
<div class="card-custom p-3 p-md-4 mb-4">
    <form action="<?= base_url('raport/nilai_pertemuan'); ?>" method="GET" class="row g-3 align-items-end">
        <?php if ($this->session->userdata('role') === 'admin'): ?>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Pilih Kelas</label>
                <select name="kelas_id" class="form-select form-select-sm" required onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    <?php if (!empty($daftar_kelas)): ?>
                        <?php foreach ($daftar_kelas as $k): ?>
                            <option value="<?= $k->id; ?>" <?= ($kelas_id == $k->id) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($k->nama); ?> (<?= htmlspecialchars($k->nama_kelompok); ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        <?php else: ?>
            <input type="hidden" name="kelas_id" value="<?= $kelas_id; ?>">
        <?php endif; ?>

        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Bulan</label>
            <select name="bulan" class="form-select form-select-sm" onchange="this.form.submit()">
                <?php
                $nama_bulan = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                foreach ($nama_bulan as $num => $nama):
                ?>
                    <option value="<?= $num; ?>" <?= ($bulan_pilih == $num) ? 'selected' : ''; ?>><?= $nama; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Pertemuan Ke-</label>
            <select name="pertemuan_ke" class="form-select form-select-sm" onchange="this.form.submit()">
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <option value="<?= $i; ?>" <?= ($pertemuan_pilih == $i) ? 'selected' : ''; ?>>Pertemuan Ke-<?= $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 w-100">
                <i class="fa-solid fa-filter me-1"></i> Tampilkan
            </button>
        </div>
    </form>
</div>

<!-- Form Input Batch Nilai -->
<?php if (!empty($kelas_id)): ?>
    <form action="<?= base_url('raport/simpan_nilai_pertemuan'); ?>" method="POST" class="card-custom p-4">
        <input type="hidden" name="kelas_id" value="<?= $kelas_id; ?>">
        <input type="hidden" name="semester_id" value="<?= $current_semester ? $current_semester->id : 1; ?>">
        <input type="hidden" name="bulan" value="<?= $bulan_pilih; ?>">
        <input type="hidden" name="tahun" value="<?= $tahun_pilih; ?>">
        <input type="hidden" name="pertemuan_ke" value="<?= $pertemuan_pilih; ?>">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0">
                Daftar Santri & Nilai Pertemuan Ke-<?= $pertemuan_pilih; ?> (<?= $nama_bulan[$bulan_pilih]; ?> <?= $tahun_pilih; ?>)
            </h5>
            <button type="submit" class="btn btn-success rounded-pill px-4 btn-sm shadow-sm">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Seluruh Nilai
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 45%;">Nama Lengkap Santri</th>
                        <th style="width: 25%;">Kelompok Jilid</th>
                        <th style="width: 25%;">Nilai Pertemuan (Skala 0 - 100)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($daftar_santri)): ?>
                        <?php $no = 1; foreach ($daftar_santri as $s): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-bold text-dark"><?= htmlspecialchars($s->nama_lengkap); ?></td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                        <?= htmlspecialchars($s->nama_kelompok ?: 'Jilid Ummi'); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm" style="max-width: 150px;">
                                        <input type="number" step="0.1" min="0" max="100" name="nilai[<?= $s->id; ?>]" class="form-control fw-bold text-center" value="<?= isset($nilai_map[$s->id]) ? $nilai_map[$s->id] : ''; ?>" placeholder="0 - 100">
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada santri aktif di kelas ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3 pt-3 border-top">
            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Seluruh Nilai
            </button>
        </div>
    </form>
<?php endif; ?>
