<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-chalkboard-user text-success me-2"></i> Santri Kelas Binaan Saya
        </h3>
        <p class="text-muted small mb-0">Pantau seluruh santri di kelas Anda pada semester aktif saat ini.</p>
    </div>
</div>

<?php if (!empty($kelas)): ?>
    <div class="card-custom p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($kelas->nama); ?></h5>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                    <?= htmlspecialchars($kelas->nama_kelompok ?: 'Metode Ummi'); ?>
                </span>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('kas/pembayaran'); ?>" class="btn btn-outline-success rounded-pill px-3 btn-sm">
                    <i class="fa-solid fa-cash-register me-1"></i> Input Pembayaran SPP
                </a>
                <a href="<?= base_url('raport/nilai_pertemuan'); ?>" class="btn btn-outline-primary rounded-pill px-3 btn-sm">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Input Nilai
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle datatable w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Lengkap Santri</th>
                        <th>L/P</th>
                        <th>Nama Orang Tua / Wali</th>
                        <th>Kontak HP/WA</th>
                        <th>Status Belajar</th>
                        <th style="width: 15%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($daftar_santri)): ?>
                        <?php $no = 1; foreach ($daftar_santri as $s): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-bold text-dark"><?= htmlspecialchars($s->nama_lengkap); ?></td>
                                <td>
                                    <span class="badge <?= ($s->jenis_kelamin === 'L') ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger'; ?>">
                                        <?= ($s->jenis_kelamin === 'L') ? 'Laki-laki' : 'Perempuan'; ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($s->nama_wali); ?></td>
                                <td><?= htmlspecialchars($s->no_hp_wali ?: '-'); ?></td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('santri/detail/' . $s->id); ?>" class="btn btn-sm btn-outline-info rounded-pill px-3">
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
<?php else: ?>
    <div class="card-custom p-5 text-center text-muted">
        <i class="fa-solid fa-chalkboard-user fa-3x mb-3 text-secondary"></i>
        <h5>Anda Belum Ditugaskan Sebagai Wali Kelas di Semester Ini</h5>
        <p class="small">Silakan berkoordinasi dengan Administrator untuk penetapan kelas binaan.</p>
    </div>
<?php endif; ?>
