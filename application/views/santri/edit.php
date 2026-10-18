<div class="mb-4">
    <a href="<?= base_url('santri/detail/' . $santri->id); ?>" class="btn btn-sm btn-light border rounded-pill px-3 mb-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Profil
    </a>
    <h3 class="fw-bold text-dark mb-1">
        <i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit Data Santri: <?= htmlspecialchars($santri->nama_lengkap); ?>
    </h3>
    <p class="text-muted small mb-0">Perbarui biodata santri dan mutasi kelas bila diperlukan.</p>
</div>

<div class="card-custom p-4 p-md-5">
    <form action="<?= base_url('santri/update/' . $santri->id); ?>" method="POST">
        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="fa-solid fa-id-card text-primary me-2"></i> 1. Identitas Santri
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <label class="form-label small fw-bold">Nama Lengkap Santri <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?= set_value('nama_lengkap', $santri->nama_lengkap); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Nama Panggilan</label>
                <input type="text" name="nama_panggilan" class="form-control" value="<?= set_value('nama_panggilan', $santri->nama_panggilan); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="<?= set_value('tempat_lahir', $santri->tempat_lahir); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?= set_value('tanggal_lahir', $santri->tanggal_lahir); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                    <option value="L" <?= ($santri->jenis_kelamin === 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= ($santri->jenis_kelamin === 'P') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="2"><?= set_value('alamat', $santri->alamat); ?></textarea>
            </div>
        </div>

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="fa-solid fa-users text-warning me-2"></i> 2. Data Orang Tua / Wali
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nama Orang Tua / Wali <span class="text-danger">*</span></label>
                <input type="text" name="nama_wali" class="form-control" value="<?= set_value('nama_wali', $santri->nama_wali); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Nomor HP / WhatsApp Aktif</label>
                <input type="text" name="no_hp_wali" class="form-control" value="<?= set_value('no_hp_wali', $santri->no_hp_wali); ?>">
            </div>
        </div>

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="fa-solid fa-chalkboard text-success me-2"></i> 3. Penempatan Kelas
        </h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Pilih Kelas di Semester Aktif</label>
                <select name="kelas_id" class="form-select">
                    <option value="">-- Tanpa Kelas --</option>
                    <?php if (!empty($daftar_kelas)): ?>
                        <?php foreach ($daftar_kelas as $kls): ?>
                            <option value="<?= $kls->id; ?>" <?= ($santri->kelas_id == $kls->id) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($kls->nama); ?> (<?= htmlspecialchars($kls->nama_kelompok); ?> - Wali: <?= htmlspecialchars($kls->nama_wali_kelas ?: '-'); ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="<?= base_url('santri/detail/' . $santri->id); ?>" class="btn btn-light border rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-warning rounded-pill px-4 text-dark fw-bold">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
