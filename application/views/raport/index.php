<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-graduation-cap text-success me-2"></i> Ledger & Raport Santri RBQ Al Fatih
        </h3>
        <p class="text-muted small mb-0">Pantau ledger penilaian bulanan dan status penerbitan raport semester seluruh kelas.</p>
    </div>
</div>

<div class="card-custom p-4">
    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-chalkboard text-primary me-2"></i> Pilih Kelas untuk Melihat Ledger & Raport</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Kelas</th>
                    <th>Kelompok / Jilid</th>
                    <th>Wali Kelas</th>
                    <th>Semester</th>
                    <th style="width: 20%;" class="text-center">Aksi Buka Raport</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_kelas)): ?>
                    <?php $no = 1; foreach ($daftar_kelas as $k): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong class="text-dark"><?= htmlspecialchars($k->nama); ?></strong></td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-bold">
                                    <?= htmlspecialchars($k->nama_kelompok); ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($k->nama_wali_kelas ?: 'Belum ditugaskan'); ?></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary text-uppercase"><?= htmlspecialchars($k->tipe_semester); ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('raport/kelas_saya?kelas_id=' . $k->id); ?>" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="fa-solid fa-file-signature me-1"></i> Buka Ledger & Raport
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
