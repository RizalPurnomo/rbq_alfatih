<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-file-signature text-success me-2"></i> Ledger Nilai & Raport Semester
        </h3>
        <p class="text-muted small mb-0">Ledger otomatis menghitung nilai rata-rata dari seluruh pertemuan dan menentukan peringkat santri dalam kelas.</p>
    </div>
</div>

<?php if ($this->session->userdata('role') === 'admin' && !empty($daftar_kelas)): ?>
    <div class="card-custom p-3 mb-4">
        <form action="<?= base_url('raport/kelas_saya'); ?>" method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <select name="kelas_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Ganti Pilihan Kelas --</option>
                    <?php foreach ($daftar_kelas as $k): ?>
                        <option value="<?= $k->id; ?>" <?= (isset($kelas->id) && $kelas->id == $k->id) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($k->nama); ?> (<?= htmlspecialchars($k->nama_kelompok); ?> - Wali: <?= htmlspecialchars($k->nama_wali_kelas ?: '-'); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php if (!empty($kelas)): ?>
    <div class="card-custom p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">Kelas: <?= htmlspecialchars($kelas->nama); ?></h5>
                <small class="text-muted">
                    Wali Kelas: <strong><?= htmlspecialchars($kelas->nama_wali_kelas ?: '-'); ?></strong> &bull; 
                    Semester: <span class="badge bg-primary text-uppercase"><?= htmlspecialchars($current_semester->tipe); ?></span> TA <?= htmlspecialchars($current_ta->nama); ?>
                </small>
            </div>
            <div>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                    Total Santri: <?= count($ledger); ?> Orang
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle datatable w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">Ranking</th>
                        <th>Nama Santri</th>
                        <th>Rata-rata Nilai</th>
                        <th>Penilaian Kepribadian</th>
                        <th>Absensi (S / I / A)</th>
                        <th>Status Raport</th>
                        <th style="width: 20%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ledger)): ?>
                        <?php foreach ($ledger as $l): ?>
                            <?php $rap = isset($raport_map[$l->santri_id]) ? $raport_map[$l->santri_id] : null; ?>
                            <tr>
                                <td class="text-center">
                                    <?php if (!empty($l->peringkat)): ?>
                                        <span class="badge <?= ($l->peringkat <= 3) ? 'bg-warning text-dark fs-6' : 'bg-light text-muted border'; ?> rounded-pill px-3 py-1">
                                            #<?= $l->peringkat; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong class="text-dark"><?= htmlspecialchars($l->nama_lengkap); ?></strong>
                                </td>
                                <td>
                                    <span class="fw-bold fs-6 text-success"><?= number_format($l->nilai_rata_rata, 1); ?></span>
                                </td>
                                <td>
                                    <?php if ($rap): ?>
                                        <span class="badge bg-light text-dark border me-1" title="Tertib">T: <?= $rap->nilai_tertib; ?></span>
                                        <span class="badge bg-light text-dark border me-1" title="Disiplin">D: <?= $rap->nilai_disiplin; ?></span>
                                        <span class="badge bg-light text-dark border" title="Motivasi Belajar">M: <?= $rap->nilai_motivasi_belajar; ?></span>
                                    <?php else: ?>
                                        <span class="text-muted small"><em>Belum dinilai</em></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($rap): ?>
                                        <small class="text-muted">
                                            S: <strong><?= $rap->jumlah_sakit; ?></strong> | 
                                            I: <strong><?= $rap->jumlah_izin; ?></strong> | 
                                            A: <strong><?= $rap->jumlah_tanpa_keterangan; ?></strong>
                                        </small>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($rap && $rap->status === 'final'): ?>
                                        <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Siap Cetak</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" title="Input Kepribadian & Absensi" onclick='modalEvaluasi(<?= json_encode($l); ?>, <?= json_encode($rap); ?>)'>
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Evaluasi
                                        </button>
                                        <?php if ($rap && $rap->status === 'final'): ?>
                                            <a href="<?= base_url('raport/cetak/' . $l->santri_id . '/' . $kelas->id . '/' . $current_semester->id); ?>" target="_blank" class="btn btn-outline-success" title="Cetak Raport">
                                                <i class="fa-solid fa-print"></i>
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
<?php else: ?>
    <div class="card-custom p-5 text-center text-muted">
        <i class="fa-solid fa-chalkboard fa-3x mb-3 text-secondary"></i>
        <h5>Silakan Pilih Kelas Terlebih Dahulu</h5>
        <p class="small">Pilih kelas binaan Anda untuk menampilkan ledger nilai dan menerbitkan raport semester.</p>
    </div>
<?php endif; ?>

<!-- Modal Evaluasi Kepribadian & Absensi -->
<div class="modal fade" id="modalEvaluasiRaport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('raport/simpan_raport_santri'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-success"><i class="fa-solid fa-pen-to-square me-2"></i> Evaluasi Raport Santri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="santri_id" id="eval_santri_id">
                <input type="hidden" name="kelas_id" value="<?= isset($kelas->id) ? $kelas->id : ''; ?>">
                <input type="hidden" name="semester_id" value="<?= isset($current_semester->id) ? $current_semester->id : ''; ?>">
                <input type="hidden" name="nilai_rata_rata" id="eval_rata_rata">
                <input type="hidden" name="peringkat" id="eval_peringkat">

                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <h6 class="fw-bold mb-1" id="eval_nama_santri"></h6>
                    <small class="text-muted">Nilai Rata-rata: <strong class="text-success" id="eval_text_rata_rata"></strong> &bull; Peringkat: <strong class="text-primary" id="eval_text_peringkat"></strong></small>
                </div>

                <h6 class="fw-bold text-dark border-bottom pb-1 mb-2">Penilaian Kepribadian (Nilai A, B, C, D)</h6>
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <label class="form-label small fw-bold">1. Tertib</label>
                        <select name="nilai_tertib" id="eval_tertib" class="form-select form-select-sm" required>
                            <option value="A">A (Sangat Baik)</option>
                            <option value="B">B (Baik)</option>
                            <option value="C">C (Cukup)</option>
                            <option value="D">D (Kurang)</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-bold">2. Disiplin</label>
                        <select name="nilai_disiplin" id="eval_disiplin" class="form-select form-select-sm" required>
                            <option value="A">A (Sangat Baik)</option>
                            <option value="B">B (Baik)</option>
                            <option value="C">C (Cukup)</option>
                            <option value="D">D (Kurang)</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-bold">3. Motivasi Belajar</label>
                        <select name="nilai_motivasi_belajar" id="eval_motivasi" class="form-select form-select-sm" required>
                            <option value="A">A (Sangat Baik)</option>
                            <option value="B">B (Baik)</option>
                            <option value="C">C (Cukup)</option>
                            <option value="D">D (Kurang)</option>
                        </select>
                    </div>
                </div>

                <h6 class="fw-bold text-dark border-bottom pb-1 mb-2">Kehadiran / Absensi (1 Semester)</h6>
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <label class="form-label small fw-bold">Sakit (Hari)</label>
                        <input type="number" min="0" name="jumlah_sakit" id="eval_sakit" class="form-control form-control-sm" value="0">
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-bold">Izin (Hari)</label>
                        <input type="number" min="0" name="jumlah_izin" id="eval_izin" class="form-control form-control-sm" value="0">
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-bold">Tanpa Ket. (Hari)</label>
                        <input type="number" min="0" name="jumlah_tanpa_keterangan" id="eval_alpa" class="form-control form-control-sm" value="0">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Catatan Wali Kelas</label>
                    <textarea name="catatan_wali_kelas" id="eval_catatan" class="form-control" rows="2" placeholder="Pesan motivasi untuk ananda dan orang tua..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan & Finalisasi Raport</button>
            </div>
        </form>
    </div>
</div>

<script>
    function modalEvaluasi(ledgerItem, raportData) {
        document.getElementById('eval_santri_id').value = ledgerItem.santri_id;
        document.getElementById('eval_nama_santri').innerText = ledgerItem.nama_lengkap;
        document.getElementById('eval_rata_rata').value = ledgerItem.nilai_rata_rata;
        document.getElementById('eval_text_rata_rata').innerText = ledgerItem.nilai_rata_rata;
        document.getElementById('eval_peringkat').value = ledgerItem.peringkat || '';
        document.getElementById('eval_text_peringkat').innerText = ledgerItem.peringkat ? '#' + ledgerItem.peringkat : '-';

        if (raportData) {
            document.getElementById('eval_tertib').value = raportData.nilai_tertib || 'A';
            document.getElementById('eval_disiplin').value = raportData.nilai_disiplin || 'A';
            document.getElementById('eval_motivasi').value = raportData.nilai_motivasi_belajar || 'A';
            document.getElementById('eval_sakit').value = raportData.jumlah_sakit || 0;
            document.getElementById('eval_izin').value = raportData.jumlah_izin || 0;
            document.getElementById('eval_alpa').value = raportData.jumlah_tanpa_keterangan || 0;
            document.getElementById('eval_catatan').value = raportData.catatan_wali_kelas || '';
        } else {
            document.getElementById('eval_tertib').value = 'A';
            document.getElementById('eval_disiplin').value = 'A';
            document.getElementById('eval_motivasi').value = 'A';
            document.getElementById('eval_sakit').value = 0;
            document.getElementById('eval_izin').value = 0;
            document.getElementById('eval_alpa').value = 0;
            document.getElementById('eval_catatan').value = '';
        }

        new bootstrap.Modal(document.getElementById('modalEvaluasiRaport')).show();
    }
</script>
