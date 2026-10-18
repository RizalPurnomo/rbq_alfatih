<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-user-gear text-dark me-2"></i> Manajemen Pengguna & Hak Akses
        </h3>
        <p class="text-muted small mb-0">Kelola akun administrator, bendahara keuangan, dan ustadz/ustadzah wali kelas.</p>
    </div>
    <div>
        <button type="button" class="btn btn-dark rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="fa-solid fa-user-plus me-1"></i> Tambah Pengguna Baru
        </button>
    </div>
</div>

<!-- Table Data Users -->
<div class="card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle datatable w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Peran (Role)</th>
                    <th>Status Akun</th>
                    <th>Terakhir Login</th>
                    <th style="width: 10%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_users)): ?>
                    <?php $no = 1; foreach ($daftar_users as $u): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($u->nama); ?></td>
                            <td><code><?= htmlspecialchars($u->username); ?></code></td>
                            <td><?= htmlspecialchars($u->email ?: '-'); ?></td>
                            <td>
                                <span class="badge <?php 
                                    if ($u->role === 'admin') echo 'bg-danger';
                                    elseif ($u->role === 'keuangan') echo 'bg-warning text-dark';
                                    else echo 'bg-success';
                                ?> text-uppercase">
                                    <?= str_replace('_', ' ', htmlspecialchars($u->role)); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($u->is_active == 1): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted">
                                <?= !empty($u->last_login) ? date('d/m/Y H:i', strtotime($u->last_login)) : 'Belum pernah'; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-warning" title="Edit Akun" onclick='editUser(<?= json_encode($u); ?>)'>
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('users/simpan'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-user-plus me-2"></i> Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Ustadz Fauzan Al-Hafidz" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" placeholder="username_tanpa_spasi" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@contoh.com">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 5 karakter" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Peran (Role) <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <option value="wali_kelas">Wali Kelas (Ustadz / Ustadzah)</option>
                        <option value="keuangan">Keuangan (Kas Utama & Laporan)</option>
                        <option value="admin">Administrator (Akses Penuh)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-dark">Daftarkan Pengguna</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('users/update'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-warning"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id" id="edit_user_id">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="edit_nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Email</label>
                    <input type="email" name="email" id="edit_email" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Ganti Password (Kosongkan bila tidak diubah)</label>
                    <input type="password" name="password" class="form-control" placeholder="Password baru">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Peran (Role) <span class="text-danger">*</span></label>
                    <select name="role" id="edit_role" class="form-select" required>
                        <option value="wali_kelas">Wali Kelas</option>
                        <option value="keuangan">Keuangan</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Status Akun</label>
                    <select name="is_active" id="edit_is_active" class="form-select">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning text-dark fw-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editUser(u) {
        document.getElementById('edit_user_id').value = u.id;
        document.getElementById('edit_nama').value = u.nama;
        document.getElementById('edit_email').value = u.email || '';
        document.getElementById('edit_role').value = u.role;
        document.getElementById('edit_is_active').value = u.is_active;
        new bootstrap.Modal(document.getElementById('modalEditUser')).show();
    }
</script>
