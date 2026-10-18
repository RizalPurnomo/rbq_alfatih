<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Raport_model
 *
 * Mengelola penilaian santri di RBQ Al Fatih:
 * - Pencatatan nilai santri per pertemuan bulanan
 * - Kompilasi ledger nilai rata-rata semester
 * - Perhitungan peringkat/ranking kelas otomatis
 * - Penilaian kepribadian (Tertib, Disiplin, Motivasi Belajar: A, B, C, D)
 * - Rekapitulasi absensi kehadiran santri (Sakit, Izin, Alpa)
 * - Pembuatan dan pencetakan raport semester
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Akademik & Penilaian
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Raport_model extends CI_Model
{
    /**
     * Menyimpan atau mengupdate nilai santri per pertemuan
     *
     * @param  array $data Data nilai pertemuan
     * @return bool
     */
    public function simpan_nilai_pertemuan($data)
    {
        // Cek apakah data sudah ada
        $cek = $this->db->get_where('nilai_pertemuan', [
            'santri_id'    => $data['santri_id'],
            'kelas_id'     => $data['kelas_id'],
            'semester_id'  => $data['semester_id'],
            'bulan'        => $data['bulan'],
            'pertemuan_ke' => $data['pertemuan_ke']
        ])->row();

        if ($cek) {
            return $this->db->where('id', $cek->id)->update('nilai_pertemuan', $data);
        } else {
            return $this->db->insert('nilai_pertemuan', $data);
        }
    }

    /**
     * Mengambil daftar nilai pertemuan untuk satu kelas pada bulan dan pertemuan tertentu
     *
     * @param  int $kelas_id     ID kelas
     * @param  int $semester_id  ID semester
     * @param  int $bulan        Bulan (1-12)
     * @param  int $pertemuan_ke Pertemuan ke- (1, 2, 3, dst)
     * @return array
     */
    public function get_nilai_pertemuan_kelas($kelas_id, $semester_id, $bulan, $pertemuan_ke)
    {
        return $this->db->get_where('nilai_pertemuan', [
            'kelas_id'     => $kelas_id,
            'semester_id'  => $semester_id,
            'bulan'        => $bulan,
            'pertemuan_ke' => $pertemuan_ke
        ])->result();
    }

    /**
     * Mengkalkulasi ledger nilai dan ranking seluruh santri dalam suatu kelas per semester
     *
     * Menghitung nilai rata-rata dari seluruh nilai pertemuan bulanan dan menyusun peringkat 1 s.d. n.
     *
     * @param  int $kelas_id    ID kelas
     * @param  int $semester_id ID semester
     * @return array            Daftar santri beserta rata-rata dan peringkatnya
     */
    public function generate_ledger_kelas($kelas_id, $semester_id)
    {
        // 1. Ambil seluruh santri dalam kelas
        $santri_list = $this->db->select('s.id as santri_id, s.nama_lengkap')
            ->from('kelas_santri ks')
            ->join('santri s', 's.id = ks.santri_id', 'inner')
            ->where('ks.kelas_id', $kelas_id)
            ->where('ks.tanggal_keluar_kelas IS NULL', null, false)
            ->get()->result();

        $ledger_temp = [];

        foreach ($santri_list as $s) {
            // Hitung rata-rata nilai pertemuan
            $avg_row = $this->db->select_avg('nilai', 'rata_rata')
                ->where('santri_id', $s->santri_id)
                ->where('kelas_id', $kelas_id)
                ->where('semester_id', $semester_id)
                ->get('nilai_pertemuan')->row();

            $rata_rata = !empty($avg_row->rata_rata) ? round((float)$avg_row->rata_rata, 2) : 0.00;

            $ledger_temp[] = [
                'santri_id'       => $s->santri_id,
                'nama_lengkap'    => $s->nama_lengkap,
                'nilai_rata_rata' => $rata_rata
            ];
        }

        // Urutkan nilai tertinggi ke terendah untuk penentuan peringkat
        usort($ledger_temp, function($a, $b) {
            return $b['nilai_rata_rata'] <=> $a['nilai_rata_rata'];
        });

        // Simpan / update ke tabel `ledger_nilai`
        $rank = 1;
        $final_ledger = [];

        foreach ($ledger_temp as $item) {
            $peringkat = ($item['nilai_rata_rata'] > 0) ? $rank++ : null;

            $data_ledger = [
                'santri_id'       => $item['santri_id'],
                'kelas_id'        => $kelas_id,
                'semester_id'     => $semester_id,
                'nilai_rata_rata' => $item['nilai_rata_rata'],
                'peringkat'       => $peringkat
            ];

            $cek = $this->db->get_where('ledger_nilai', [
                'santri_id'   => $item['santri_id'],
                'kelas_id'    => $kelas_id,
                'semester_id' => $semester_id
            ])->row();

            if ($cek) {
                $this->db->where('id', $cek->id)->update('ledger_nilai', $data_ledger);
            } else {
                $this->db->insert('ledger_nilai', $data_ledger);
            }

            $item['peringkat'] = $peringkat;
            $final_ledger[] = (object)$item;
        }

        return $final_ledger;
    }

    /**
     * Menyimpan atau mengupdate raport semester santri
     *
     * @param  array $data Data raport santri
     * @return bool
     */
    public function simpan_raport($data)
    {
        $cek = $this->db->get_where('raport', [
            'santri_id'   => $data['santri_id'],
            'kelas_id'    => $data['kelas_id'],
            'semester_id' => $data['semester_id']
        ])->row();

        if ($cek) {
            return $this->db->where('id', $cek->id)->update('raport', $data);
        } else {
            return $this->db->insert('raport', $data);
        }
    }

    /**
     * Mengambil satu raport lengkap santri untuk dicetak
     *
     * @param  int $santri_id   ID santri
     * @param  int $kelas_id    ID kelas
     * @param  int $semester_id ID semester
     * @return object|null
     */
    public function get_raport_detail($santri_id, $kelas_id, $semester_id)
    {
        $this->db->select('r.*, s.nama_lengkap, s.tempat_lahir, s.tanggal_lahir, s.nama_wali, k.nama as nama_kelas, klp.nama as nama_kelompok, sem.tipe as tipe_semester, ta.nama as nama_tahun_ajaran, u.nama as nama_wali_kelas');
        $this->db->from('raport r');
        $this->db->join('santri s', 's.id = r.santri_id', 'inner');
        $this->db->join('kelas k', 'k.id = r.kelas_id', 'inner');
        $this->db->join('kelompok klp', 'klp.id = k.kelompok_id', 'inner');
        $this->db->join('semester sem', 'sem.id = r.semester_id', 'inner');
        $this->db->join('tahun_ajaran ta', 'ta.id = sem.tahun_ajaran_id', 'inner');
        $this->db->join('users u', 'u.id = k.wali_kelas_id', 'left');
        $this->db->where('r.santri_id', $santri_id);
        $this->db->where('r.kelas_id', $kelas_id);
        $this->db->where('r.semester_id', $semester_id);
        return $this->db->get()->row();
    }
}
