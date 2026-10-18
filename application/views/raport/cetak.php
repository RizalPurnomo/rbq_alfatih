<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Belajar (Raport) - <?= htmlspecialchars($raport->nama_lengkap); ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #fff;
            padding: 20px;
        }

        .raport-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 30px;
            background: #fff;
        }

        .header-kop {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .table-data-santri td {
            padding: 3px 6px;
            font-size: 0.95rem;
        }

        .table-nilai th, .table-nilai td {
            border: 1px solid #000 !important;
            padding: 6px 10px;
            font-size: 0.95rem;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .raport-container {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Print Navigasi -->
    <div class="text-center mb-4 no-print">
        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow">
            <i class="fa-solid fa-print me-1"></i> Cetak Dokumen Raport
        </button>
        <button onclick="window.close()" class="btn btn-light border rounded-pill px-3 ms-2">
            Tutup
        </button>
    </div>

    <div class="raport-container">
        <!-- KOP SURAT RESMI -->
        <div class="header-kop">
            <h3 class="fw-bold mb-1 text-uppercase">Rumah Belajar Quran (RBQ) Al Fatih</h3>
            <h5 class="fw-bold mb-1 text-uppercase">Pusat Pembelajaran Al-Quran Terstandar Metode Ummi</h5>
            <p class="small mb-0">Sekretariat: Jl. RBQ Al Fatih No. 01 &bull; Hotline: 0812-3456-7890 &bull; Website: rbqalfatih.com</p>
        </div>

        <div class="text-center mb-4">
            <h5 class="fw-bold text-uppercase text-decoration-underline mb-1">Laporan Hasil Pembelajaran Santri</h5>
            <small class="fw-bold">Tahun Ajaran <?= htmlspecialchars($raport->nama_tahun_ajaran); ?> - Semester <?= ucfirst(htmlspecialchars($raport->tipe_semester)); ?></small>
        </div>

        <!-- IDENTITAS SANTRI -->
        <table class="w-100 mb-4 table-data-santri">
            <tr>
                <td style="width: 22%;">Nama Lengkap Santri</td>
                <td style="width: 3%;">:</td>
                <td style="width: 35%;"><strong><?= htmlspecialchars($raport->nama_lengkap); ?></strong></td>
                <td style="width: 18%;">Tingkat / Jilid</td>
                <td style="width: 2%;">:</td>
                <td style="width: 20%;"><strong><?= htmlspecialchars($raport->nama_kelompok); ?></strong></td>
            </tr>
            <tr>
                <td>Tempat, Tgl Lahir</td>
                <td>:</td>
                <td><?= htmlspecialchars($raport->tempat_lahir ?: '-'); ?>, <?= !empty($raport->tanggal_lahir) ? date('d/m/Y', strtotime($raport->tanggal_lahir)) : '-'; ?></td>
                <td>Kelas</td>
                <td>:</td>
                <td><?= htmlspecialchars($raport->nama_kelas); ?></td>
            </tr>
            <tr>
                <td>Orang Tua / Wali</td>
                <td>:</td>
                <td><?= htmlspecialchars($raport->nama_wali); ?></td>
                <td>Wali Kelas</td>
                <td>:</td>
                <td><?= htmlspecialchars($raport->nama_wali_kelas ?: '-'); ?></td>
            </tr>
        </table>

        <!-- A. CAPAIAN NILAI AKADEMIK & RANKING -->
        <h6 class="fw-bold mb-2">A. Capaian Nilai Pembelajaran Al-Quran (Metode Ummi)</h6>
        <table class="table table-bordered table-nilai w-100 mb-4 text-center">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%;">Aspek Penilaian</th>
                    <th style="width: 20%;">Nilai Rata-rata</th>
                    <th style="width: 20%;">Predikat Huruf</th>
                    <th style="width: 20%;">Peringkat Kelas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-start">
                        <strong>Tartil & Munaqasyah Al-Quran</strong><br>
                        <small class="text-muted">(Fashohah, Tajwid, Ghunnah, Makharijul Huruf)</small>
                    </td>
                    <td class="fs-5 fw-bold"><?= number_format($raport->nilai_rata_rata, 1); ?></td>
                    <td class="fs-5 fw-bold">
                        <?php 
                        $avg = $raport->nilai_rata_rata;
                        if ($avg >= 85) echo 'A (Sangat Baik)';
                        elseif ($avg >= 75) echo 'B (Baik)';
                        elseif ($avg >= 65) echo 'C (Cukup)';
                        else echo 'D (Kurang)';
                        ?>
                    </td>
                    <td class="fs-5 fw-bold text-primary">
                        <?= !empty($raport->peringkat) ? 'Ke-' . $raport->peringkat : '-'; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- B. PENILAIAN KEPRIBADIAN & KARAKTER -->
        <h6 class="fw-bold mb-2">B. Penilaian Sikap & Kepribadian</h6>
        <table class="table table-bordered table-nilai w-100 mb-4 text-center">
            <thead class="table-light">
                <tr>
                    <th style="width: 10%;">No</th>
                    <th style="width: 50%;" class="text-start">Indikator Kepribadian</th>
                    <th style="width: 20%;">Predikat Nilai</th>
                    <th style="width: 20%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="text-start"><strong>Ketertiban</strong> (Adab bermajelis, kerapian mushaf & busana)</td>
                    <td class="fw-bold fs-6"><?= $raport->nilai_tertib; ?></td>
                    <td>
                        <?= ($raport->nilai_tertib === 'A') ? 'Sangat Baik' : (($raport->nilai_tertib === 'B') ? 'Baik' : 'Cukup'); ?>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-start"><strong>Kedisiplinan</strong> (Kehadiran tepat waktu & istiqomah belajar)</td>
                    <td class="fw-bold fs-6"><?= $raport->nilai_disiplin; ?></td>
                    <td>
                        <?= ($raport->nilai_disiplin === 'A') ? 'Sangat Baik' : (($raport->nilai_disiplin === 'B') ? 'Baik' : 'Cukup'); ?>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="text-start"><strong>Motivasi Belajar</strong> (Semangat menyimak, mengulang hafalan)</td>
                    <td class="fw-bold fs-6"><?= $raport->nilai_motivasi_belajar; ?></td>
                    <td>
                        <?= ($raport->nilai_motivasi_belajar === 'A') ? 'Sangat Baik' : (($raport->nilai_motivasi_belajar === 'B') ? 'Baik' : 'Cukup'); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- C. KETIDAKHADIRAN -->
        <div class="row g-3 mb-4">
            <div class="col-6">
                <h6 class="fw-bold mb-2">C. Rekapitulasi Absensi (Kehadiran)</h6>
                <table class="table table-bordered table-nilai w-100">
                    <tr>
                        <td style="width: 70%;">Sakit</td>
                        <td style="width: 30%;" class="text-center"><strong><?= $raport->jumlah_sakit; ?></strong> hari</td>
                    </tr>
                    <tr>
                        <td>Izin</td>
                        <td class="text-center"><strong><?= $raport->jumlah_izin; ?></strong> hari</td>
                    </tr>
                    <tr>
                        <td>Tanpa Keterangan (Alpa)</td>
                        <td class="text-center"><strong><?= $raport->jumlah_tanpa_keterangan; ?></strong> hari</td>
                    </tr>
                </table>
            </div>

            <!-- D. CATATAN WALI KELAS -->
            <div class="col-6">
                <h6 class="fw-bold mb-2">D. Catatan / Pesan Motivasi Wali Kelas</h6>
                <div class="p-3 border rounded-2 bg-light h-100" style="min-height: 110px;">
                    <p class="small fst-italic mb-0">
                        "<?= !empty($raport->catatan_wali_kelas) ? nl2br(htmlspecialchars($raport->catatan_wali_kelas)) : 'Alhamdulillah Ananda menunjukkan kemajuan yang membanggakan. Terus tingkatkan murajaah di rumah bersama orang tua.'; ?>"
                    </p>
                </div>
            </div>
        </div>

        <!-- TANDA TANGAN RESMI -->
        <div class="pt-4 mt-2">
            <div class="d-flex justify-content-between text-center" style="font-size: 0.95rem;">
                <div style="width: 30%;">
                    <p class="mb-5">Orang Tua / Wali Santri,</p>
                    <p class="fw-bold mb-0 text-decoration-underline">( <?= htmlspecialchars($raport->nama_wali); ?> )</p>
                </div>

                <div style="width: 30%;">
                    <p class="mb-5">Mengetahui,<br>Kepala RBQ Al Fatih</p>
                    <p class="fw-bold mb-0 text-decoration-underline">( Ust. H. Ahmad Dahlan, Lc. )</p>
                </div>

                <div style="width: 30%;">
                    <p class="mb-5">Tempat, <?= date('d F Y'); ?><br>Wali Kelas,</p>
                    <p class="fw-bold mb-0 text-decoration-underline">( <?= htmlspecialchars($raport->nama_wali_kelas ?: 'Wali Kelas'); ?> )</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
