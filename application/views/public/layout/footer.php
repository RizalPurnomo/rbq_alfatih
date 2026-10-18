    <!-- Footer -->
    <footer class="footer-rbq">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-book-quran fa-2x text-warning"></i>
                        <h4 class="text-white mb-0 fw-bold">RBQ Al Fatih</h4>
                    </div>
                    <p class="small text-secondary mb-3">
                        Rumah Belajar Quran (RBQ) Al Fatih berkomitmen mencetak generasi qurani yang bertilawah tartil, bertahfidz mutqin, dan berakhlak mulia melalui pengajaran standar <strong>Metode Ummi</strong>.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-youtube"></i></a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Tautan Cepat</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="<?= base_url(); ?>"><i class="fa-solid fa-chevron-right me-1 text-warning"></i> Beranda</a></li>
                        <li><a href="<?= base_url('tentang'); ?>"><i class="fa-solid fa-chevron-right me-1 text-warning"></i> Tentang Kami</a></li>
                        <li><a href="<?= base_url('visi-misi'); ?>"><i class="fa-solid fa-chevron-right me-1 text-warning"></i> Visi & Misi</a></li>
                        <li><a href="<?= base_url('pengajar'); ?>"><i class="fa-solid fa-chevron-right me-1 text-warning"></i> Profil Pengajar</a></li>
                        <li><a href="<?= base_url('pendaftaran'); ?>"><i class="fa-solid fa-chevron-right me-1 text-warning"></i> Info Pendaftaran</a></li>
                        <li><a href="<?= base_url('berita'); ?>"><i class="fa-solid fa-chevron-right me-1 text-warning"></i> Event & Berita</a></li>
                        <li><a href="<?= base_url('kontak'); ?>"><i class="fa-solid fa-chevron-right me-1 text-warning"></i> Hubungi Kami</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Jenjang Metode Ummi</h6>
                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-1 mb-0">
                        <li><i class="fa-solid fa-check text-success me-2"></i> Pra Ummi (Pengenalan Huruf Hijaiyah)</li>
                        <li><i class="fa-solid fa-check text-success me-2"></i> Jilid 1 & 2 (Fathah, Kasrah, Dhammah)</li>
                        <li><i class="fa-solid fa-check text-success me-2"></i> Jilid 3 & 4 (Mad, Sukun, Tasydid)</li>
                        <li><i class="fa-solid fa-check text-success me-2"></i> Jilid 5 & 6 (Ghunnah, Tajwid Lanjutan)</li>
                        <li><i class="fa-solid fa-check text-success me-2"></i> Al-Quran & Ghorib / Tajwid</li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-bold mb-3">Sekretariat & Lokasi</h6>
                    <p class="small text-secondary mb-2">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i> Rumah Belajar Quran Al Fatih
                    </p>
                    <p class="small text-secondary mb-3">
                        <i class="fa-solid fa-map-location-dot text-warning me-2"></i>
                        <a href="https://maps.app.goo.gl/6aJ7jQ7tJwVJyrQF7" target="_blank" class="text-decoration-underline">Buka Google Maps Resmi</a>
                    </p>
                    <p class="small text-secondary mb-1">
                        <i class="fa-solid fa-phone text-success me-2"></i> 0812-3456-7890
                    </p>
                    <p class="small text-secondary mb-0">
                        <i class="fa-solid fa-envelope text-info me-2"></i> info@rbqalfatih.com
                    </p>
                </div>
            </div>

            <hr class="border-secondary opacity-25">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 pt-2">
                <p class="small text-secondary mb-0">&copy; <?= date('Y'); ?> <strong>Rumah Belajar Quran (RBQ) Al Fatih</strong>. All rights reserved.</p>
                <div class="small text-secondary">
                    <a href="<?= base_url('login'); ?>" class="text-secondary"><i class="fa-solid fa-lock me-1"></i> Portal Aplikasi Internal</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
