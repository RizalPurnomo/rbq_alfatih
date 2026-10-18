<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-chalkboard-user text-primary me-2"></i> Manajemen Profil Pengajar (Asatidz)
        </h3>
        <p class="text-muted small mb-0">Kelola direktori profil ustadz/ustadzah, pendidikan, sertifikasi Ummi, dan pengalaman mengajar yang tampil di Website Profil publik.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('pengajar'); ?>" target="_blank" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fa-solid fa-globe me-1"></i> Lihat Halaman Web
        </a>
        <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengajar">
            <i class="fa-solid fa-plus me-1"></i> Tambah Pengajar Baru
        </button>
    </div>
</div>

<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Foto</th>
                    <th>Nama & Gelar</th>
                    <th>Gender</th>
                    <th>Jabatan / Peran</th>
                    <th>Pendidikan</th>
                    <th>Spesialisasi</th>
                    <th>Status</th>
                    <th style="width: 14%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_pengajar)): ?>
                    <?php $no = 1; foreach ($daftar_pengajar as $p): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?php if (!empty($p->foto) && file_exists(FCPATH . 'uploads/pengajar/' . $p->foto)): ?>
                                    <img src="<?= base_url('uploads/pengajar/' . $p->foto); ?>" class="rounded-circle object-fit-cover shadow-sm border" style="width: 44px; height: 44px;" alt="Avatar">
                                <?php else: ?>
                                    <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center text-white" style="width: 44px; height: 44px; background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); font-size: 1.1rem;">
                                        <i class="fa-solid <?= ($p->jenis_kelamin === 'L') ? 'fa-user-tie' : 'fa-user-nurse'; ?>"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong class="text-dark d-block"><?= htmlspecialchars($p->nama); ?></strong>
                                <?php if (!empty($p->gelar)): ?>
                                    <small class="text-emerald fw-semibold"><?= htmlspecialchars($p->gelar); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?= ($p->jenis_kelamin === 'L') ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle'; ?> rounded-pill small">
                                    <i class="fa-solid <?= ($p->jenis_kelamin === 'L') ? 'fa-mars' : 'fa-venus'; ?> me-1"></i>
                                    <?= ($p->jenis_kelamin === 'L') ? 'Ikhwan' : 'Akhwat'; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill small">
                                    <?= htmlspecialchars($p->jabatan); ?>
                                </span>
                            </td>
                            <td class="small text-muted" style="max-width: 180px;">
                                <div class="text-truncate" title="<?= htmlspecialchars($p->pendidikan); ?>">
                                    <?= htmlspecialchars($p->pendidikan); ?>
                                </div>
                            </td>
                            <td class="small" style="max-width: 160px;">
                                <?php 
                                    $tags = array_filter(array_map('trim', explode(',', (string)$p->spesialisasi)));
                                    if (!empty($tags)):
                                ?>
                                    <span class="badge bg-light text-dark border rounded-pill">
                                        <?= htmlspecialchars($tags[0]); ?>
                                    </span>
                                    <?php if (count($tags) > 1): ?>
                                        <span class="badge bg-light text-muted border rounded-pill">+<?= count($tags) - 1; ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('pengajar_admin/toggle_status/' . $p->id); ?>" class="text-decoration-none" title="Klik untuk mengubah status aktif/non-aktif">
                                    <?php if ($p->is_active): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                            <i class="fa-solid fa-circle-check me-1"></i> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill">
                                            <i class="fa-solid fa-circle-xmark me-1"></i> Disembunyikan
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-2 btn-edit-pengajar" 
                                            data-id="<?= $p->id; ?>"
                                            data-nama="<?= htmlspecialchars($p->nama); ?>"
                                            data-gelar="<?= htmlspecialchars($p->gelar); ?>"
                                            data-jk="<?= $p->jenis_kelamin; ?>"
                                            data-jabatan="<?= htmlspecialchars($p->jabatan); ?>"
                                            data-pendidikan="<?= htmlspecialchars($p->pendidikan); ?>"
                                            data-sertifikasi="<?= htmlspecialchars($p->sertifikasi); ?>"
                                            data-pengalaman="<?= htmlspecialchars($p->pengalaman); ?>"
                                            data-spesialisasi="<?= htmlspecialchars($p->spesialisasi); ?>"
                                            data-quote="<?= htmlspecialchars($p->quote); ?>"
                                            data-hp="<?= htmlspecialchars($p->kontak_hp); ?>"
                                            data-email="<?= htmlspecialchars($p->email); ?>"
                                            data-urutan="<?= $p->urutan; ?>"
                                            title="Edit Data Pengajar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <a href="<?= base_url('pengajar_admin/hapus/' . $p->id); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Hapus Pengajar" onclick="return confirm('Apakah Anda yakin ingin menghapus data pengajar ini?')">
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

<!-- Modal Tambah Pengajar -->
<div class="modal fade" id="modalTambahPengajar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('pengajar_admin/simpan'); ?>" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i> Tambah Data Pengajar Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Ustadz Ahmad Fauzi" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Gelar Akademik / Syar'i</label>
                        <input type="text" name="gelar" class="form-control" placeholder="Contoh: S.Pd.I, Al-Hafizh">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="L">Ikhwan (Laki-laki)</option>
                            <option value="P">Akhwat (Perempuan)</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Jabatan / Peran di RBQ <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Koordinator Tahfidz / Wali Kelas Jilid 2" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="1" min="1">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Pendidikan Terakhir & Almamater <span class="text-danger">*</span></label>
                        <input type="text" name="pendidikan" class="form-control" placeholder="Contoh: S1 Pendidikan Agama Islam - Universitas PTIQ Jakarta & Pesantren Krapyak" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Lisensi & Sertifikasi (Pisahkan dengan koma)</label>
                        <input type="text" name="sertifikasi" class="form-control" placeholder="Contoh: Sertifikasi Guru Metode Ummi Foundation, Syahadah Tahfidz 30 Juz, Sanad Matan Al-Jazariyyah">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Pengalaman Mengajar & Rekam Jejak <span class="text-danger">*</span></label>
                        <textarea name="pengalaman" class="form-control" rows="3" placeholder="Tuliskan pengalaman mengajar tahsin/tahfidz anak, bimbingan munaqosyah, dll..." required></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Keahlian & Spesialisasi (Skill Badges, pisahkan dengan koma)</label>
                        <input type="text" name="spesialisasi" class="form-control" placeholder="Contoh: Metode Ummi Certified, Tahfidz 30 Juz, Makharijul Huruf, Karakter Anak">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Quote / Pesan Inspiratif Pengajar</label>
                        <textarea name="quote" class="form-control" rows="2" placeholder="Contoh: Sebaik-baik kalian adalah yang belajar Al-Quran dan mengajarkannya."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">No. WhatsApp / HP</label>
                        <input type="text" name="kontak_hp" class="form-control" placeholder="0812xxxxxxxx">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@rbqalfatih.sch.id">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Foto Profil (Opsional, JPG/PNG/WebP, Max 3MB)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika ingin menggunakan avatar default syar'i.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Simpan Data Pengajar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pengajar -->
<div class="modal fade" id="modalEditPengajar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('pengajar_admin/update'); ?>" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-pen me-2"></i> Edit Profil Pengajar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Gelar Akademik / Syar'i</label>
                        <input type="text" name="gelar" id="edit_gelar" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="edit_jk" class="form-select" required>
                            <option value="L">Ikhwan (Laki-laki)</option>
                            <option value="P">Akhwat (Perempuan)</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Jabatan / Peran di RBQ <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" id="edit_jabatan" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Urutan Tampil</label>
                        <input type="number" name="urutan" id="edit_urutan" class="form-control" min="1">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Pendidikan Terakhir & Almamater <span class="text-danger">*</span></label>
                        <input type="text" name="pendidikan" id="edit_pendidikan" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Lisensi & Sertifikasi (Pisahkan dengan koma)</label>
                        <input type="text" name="sertifikasi" id="edit_sertifikasi" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Pengalaman Mengajar & Rekam Jejak <span class="text-danger">*</span></label>
                        <textarea name="pengalaman" id="edit_pengalaman" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Keahlian & Spesialisasi (Skill Badges, pisahkan dengan koma)</label>
                        <input type="text" name="spesialisasi" id="edit_spesialisasi" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Quote / Pesan Inspiratif Pengajar</label>
                        <textarea name="quote" id="edit_quote" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">No. WhatsApp / HP</label>
                        <input type="text" name="kontak_hp" id="edit_hp" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold">Ubah Foto Profil (Opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Pilih file baru jika ingin mengganti foto yang sudah ada.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning"><i class="fa-solid fa-save me-1"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit-pengajar');
    const modalEditEl = document.getElementById('modalEditPengajar');
    const modalEdit   = new bootstrap.Modal(modalEditEl);

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_id').value           = this.dataset.id;
            document.getElementById('edit_nama').value         = this.dataset.nama || '';
            document.getElementById('edit_gelar').value        = this.dataset.gelar || '';
            document.getElementById('edit_jk').value           = this.dataset.jk || 'L';
            document.getElementById('edit_jabatan').value      = this.dataset.jabatan || '';
            document.getElementById('edit_pendidikan').value   = this.dataset.pendidikan || '';
            document.getElementById('edit_sertifikasi').value  = this.dataset.sertifikasi || '';
            document.getElementById('edit_pengalaman').value   = this.dataset.pengalaman || '';
            document.getElementById('edit_spesialisasi').value = this.dataset.spesialisasi || '';
            document.getElementById('edit_quote').value        = this.dataset.quote || '';
            document.getElementById('edit_hp').value           = this.dataset.hp || '';
            document.getElementById('edit_email').value        = this.dataset.email || '';
            document.getElementById('edit_urutan').value       = this.dataset.urutan || '1';

            modalEdit.show();
        });
    });
});
</script>
