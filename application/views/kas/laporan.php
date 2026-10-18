<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-chart-line text-success me-2"></i> Laporan Keuangan Kas Utama
        </h3>
        <p class="text-muted small mb-0">Ringkasan menyeluruh pemasukan SPP, infaq & donasi, serta rincian pengeluaran kas utama.</p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
            <i class="fa-solid fa-print me-1"></i> Cetak Laporan
        </button>
    </div>
</div>

<!-- Posisi Kas Utama -->
<div class="row g-4 mb-4">
    <!-- Kas SPP -->
    <div class="col-lg-6">
        <div class="card-custom p-4 border-start border-4 border-success bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-success mb-0"><i class="fa-solid fa-coins me-2"></i> KAS SPP (Honor / Bisyaroh Guru)</h5>
                <span class="badge bg-success-subtle text-success">Kategori SPP</span>
            </div>
            <div class="p-3 bg-light rounded-3 mb-3 border">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Setoran SPP Diterima:</span>
                    <strong class="text-success small">Rp <?= number_format($saldo_kas['total_spp_masuk'], 0, ',', '.'); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Pengeluaran Bisyaroh Guru:</span>
                    <strong class="text-danger small">(Rp <?= number_format($saldo_kas['total_pengeluaran_spp'], 0, ',', '.'); ?>)</strong>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                    <strong class="text-dark">Sisa Saldo Kas SPP:</strong>
                    <strong class="text-success fs-5">Rp <?= number_format($saldo_kas['saldo_spp'], 0, ',', '.'); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Kas Infaq & Donatur -->
    <div class="col-lg-6">
        <div class="card-custom p-4 border-start border-4 border-primary bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-primary mb-0"><i class="fa-solid fa-hand-holding-heart me-2"></i> KAS INFAQ & DONATUR (Operasional)</h5>
                <span class="badge bg-primary-subtle text-primary">Kategori Infaq</span>
            </div>
            <div class="p-3 bg-light rounded-3 mb-3 border">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted small">Infaq Santri (Setoran Kelas):</span>
                    <span class="text-dark small">Rp <?= number_format($saldo_kas['infaq_santri'], 0, ',', '.'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Donasi Donatur Umum:</span>
                    <span class="text-dark small">Rp <?= number_format($saldo_kas['infaq_donasi'], 0, ',', '.'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Pengeluaran Operasional/Pokja/Buku:</span>
                    <strong class="text-danger small">(Rp <?= number_format($saldo_kas['total_pengeluaran_infaq'], 0, ',', '.'); ?>)</strong>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                    <strong class="text-dark">Sisa Saldo Kas Infaq:</strong>
                    <strong class="text-primary fs-5">Rp <?= number_format($saldo_kas['saldo_infaq'], 0, ',', '.'); ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grand Total Kas Utama -->
<div class="card-custom p-4 text-center bg-gradient-success-subtle border mb-4" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);">
    <small class="text-muted fw-bold text-uppercase d-block mb-1">Total Likuiditas Saldo Kas Utama RBQ Al Fatih</small>
    <h2 class="display-6 fw-bold text-success mb-0">Rp <?= number_format($saldo_kas['total_saldo_utama'], 0, ',', '.'); ?></h2>
</div>
