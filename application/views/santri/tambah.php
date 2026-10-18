<div class="mb-4">
    <a href="<?= base_url('santri'); ?>" class="btn btn-sm btn-light border rounded-pill px-3 mb-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Santri
    </a>
    <h3 class="fw-bold text-dark mb-1">
        <i class="fa-solid fa-user-plus text-success me-2"></i> Tambah Santri Baru
    </h3>
    <p class="text-muted small mb-0">Lengkapi formulir biodata dan tentukan tingkatan jilid awal metode Ummi.</p>
</div>

<div class="card-custom p-4 p-md-5">
    <form action="<?= base_url('santri/simpan'); ?>" method="POST">
        <!-- Section 1: Data Santri -->
        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="fa-solid fa-id-card text-primary me-2"></i> 1. Identitas Santri
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <label class="form-label small fw-bold">Nama Lengkap Santri <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Muhammad Fatih Al-Ayyubi" value="<?= set_value('nama_lengkap'); ?>" required autofocus>
                <?= form_error('nama_lengkap', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Nama Panggilan</label>
                <input type="text" name="nama_panggilan" class="form-control" placeholder="Contoh: Fatih" value="<?= set_value('nama_panggilan'); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota Kelahiran" value="<?= set_value('tempat_lahir'); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?= set_value('tanggal_lahir'); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="L" <?= set_select('jenis_kelamin', 'L', true); ?>>Laki-laki</option>
                    <option value="P" <?= set_select('jenis_kelamin', 'P'); ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat tempat tinggal santri"><?= set_value('alamat'); ?></textarea>
            </div>
        </div>

        <!-- Section 2: Data Orang Tua / Wali -->
        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="fa-solid fa-users text-warning me-2"></i> 2. Data Orang Tua / Wali Santri
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nama Orang Tua / Wali <span class="text-danger">*</span></label>
                <input type="text" name="nama_wali" class="form-control" placeholder="Nama Ayah / Ibu / Wali" value="<?= set_value('nama_wali'); ?>" required>
                <?= form_error('nama_wali', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nomor HP / WhatsApp Aktif</label>
                <input type="text" name="no_hp_wali" class="form-control" placeholder="Contoh: 081234567890" value="<?= set_value('no_hp_wali'); ?>">
                <small class="text-muted">Digunakan untuk informasi kegiatan dan laporan keuangan/SPP.</small>
            </div>
        </div>

        <!-- Section 3: Penempatan Akademik & Metode Ummi -->
        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="fa-solid fa-book-quran text-success me-2"></i> 3. Penempatan Awal Metode Ummi & Kelas
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tanggal Masuk RBQ <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_masuk" class="form-control" value="<?= set_value('tanggal_masuk', date('Y-m-d')); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Kelompok / Jilid Awal <span class="text-danger">*</span></label>
                <select name="kelompok_id" class="form-select" required>
                    <option value="">-- Pilih Jilid Hasil Placement --</option>
                    <?php if (!empty($daftar_kelompok)): ?>
                        <?php foreach ($daftar_kelompok as $klp): ?>
                            <option value="<?= $klp->id; ?>" <?= set_select('kelompok_id', $klp->id, ($klp->urutan == 1)); ?>>
                                <?= htmlspecialchars($klp->nama); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <small class="text-muted">Akan langsung dicatat di riwayat jilid santri.</small>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Penempatan Kelas (Semester Aktif)</label>
                <select name="kelas_id" class="form-select">
                    <option value="">-- Belum Masuk Kelas --</option>
                    <?php if (!empty($daftar_kelas)): ?>
                        <?php foreach ($daftar_kelas as $kls): ?>
                            <option value="<?= $kls->id; ?>" <?= set_select('kelas_id', $kls->id); ?>>
                                <?= htmlspecialchars($kls->nama); ?> (<?= htmlspecialchars($kls->nama_kelompok); ?> - Wali: <?= htmlspecialchars($kls->nama_wali_kelas ?: '-'); ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="<?= base_url('santri'); ?>" class="btn btn-light border rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-success rounded-pill px-4">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Data Santri
            </button>
        </div>
    </form>
</div>
