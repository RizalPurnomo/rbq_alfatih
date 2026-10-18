<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-piggy-bank text-warning me-2"></i> Tabungan Santri RBQ Al Fatih
        </h3>
        <p class="text-muted small mb-0">Himpunan tabungan santri yang disetor saat pembayaran bulanan dan dapat diambil sewaktu-waktu.</p>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Santri</th>
                    <th>Kelompok / Jilid</th>
                    <th>Kelas</th>
                    <th>Total Saldo Tabungan</th>
                    <th style="width: 15%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_tabungan)): ?>
                    <?php $no = 1; foreach ($daftar_tabungan as $t): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($t->nama_santri); ?></td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                    <?= htmlspecialchars($t->nama_kelompok ?: 'Belum Ada'); ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($t->nama_kelas ?: '-'); ?></td>
                            <td class="fw-bold text-warning fs-6">
                                Rp <?= number_format($t->saldo, 0, ',', '.'); ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('tabungan/detail/' . $t->santri_id); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="fa-solid fa-book me-1"></i> Buku Tabungan
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
