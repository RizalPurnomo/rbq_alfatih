<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Santri_model
 *
 * Mengelola data induk santri pada tabel `santri`, relasi penempatan kelas pada tabel `kelas_santri`,
 * dan catatan historis kenaikan jilid pada tabel `riwayat_jilid`.
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Santri
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Santri_model extends CI_Model
{
    /**
     * Nama tabel santri utama
     * @var string
     */
    protected $table = 'santri';

    /**
     * Mengambil daftar santri dengan filter fleksibel (status, kelas, semester, kelompok)
     *
     * @param  array $filter Array filter ['status', 'semester_id', 'kelas_id', 'kelompok_id']
     * @return array        Daftar santri beserta info kelas dan jilid saat ini
     */
    public function get_all($filter = [])
    {
        $this->db->select('s.*, k.nama as nama_kelas, klp.nama as nama_kelompok, klp.urutan as urutan_kelompok, u.nama as nama_wali_kelas');
        $this->db->from($this->table . ' s');

        // Join kelas aktif melalui kelas_santri
        if (!empty($filter['semester_id'])) {
            $this->db->join('kelas_santri ks', 'ks.santri_id = s.id AND ks.tanggal_keluar_kelas IS NULL', 'left');
            $this->db->join('kelas k', 'k.id = ks.kelas_id AND k.semester_id = ' . (int)$filter['semester_id'], 'left');
        } else {
            $this->db->join('kelas_santri ks', 'ks.santri_id = s.id AND ks.tanggal_keluar_kelas IS NULL', 'left');
            $this->db->join('kelas k', 'k.id = ks.kelas_id', 'left');
        }

        $this->db->join('kelompok klp', 'klp.id = k.kelompok_id', 'left');
        $this->db->join('users u', 'u.id = k.wali_kelas_id', 'left');

        if (!empty($filter['status'])) {
            $this->db->where('s.status', $filter['status']);
        }

        if (!empty($filter['kelas_id'])) {
            $this->db->where('k.id', $filter['kelas_id']);
        }

        if (!empty($filter['kelompok_id'])) {
            $this->db->where('k.kelompok_id', $filter['kelompok_id']);
        }

        $this->db->order_by('s.nama_lengkap', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil satu data detail santri berdasarkan ID
     *
     * @param  int      $id          ID santri
     * @param  int|null $semester_id ID semester aktif untuk mengambil kelas saat ini
     * @return object|null           Objek santri atau null
     */
    public function get_by_id($id, $semester_id = null)
    {
        $this->db->select('s.*, k.id as kelas_id, k.nama as nama_kelas, klp.id as kelompok_id, klp.nama as nama_kelompok, u.nama as nama_wali_kelas');
        $this->db->from($this->table . ' s');

        if (!empty($semester_id)) {
            $this->db->join('kelas_santri ks', 'ks.santri_id = s.id AND ks.tanggal_keluar_kelas IS NULL', 'left');
            $this->db->join('kelas k', 'k.id = ks.kelas_id AND k.semester_id = ' . (int)$semester_id, 'left');
        } else {
            $this->db->join('kelas_santri ks', 'ks.santri_id = s.id AND ks.tanggal_keluar_kelas IS NULL', 'left');
            $this->db->join('kelas k', 'k.id = ks.kelas_id', 'left');
        }

        $this->db->join('kelompok klp', 'klp.id = k.kelompok_id', 'left');
        $this->db->join('users u', 'u.id = k.wali_kelas_id', 'left');
        $this->db->where('s.id', $id);

        return $this->db->get()->row();
    }

    /**
     * Menyimpan data santri baru
     *
     * @param  array $data Data santri
     * @return int         Insert ID santri
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Mengupdate profil santri
     *
     * @param  int   $id   ID santri
     * @param  array $data Data update
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Menandai santri sebagai keluar dari RBQ Al Fatih
     *
     * @param  int    $id             ID santri
     * @param  string $tanggal_keluar Tanggal santri keluar
     * @param  string $alasan_keluar  Alasan santri keluar
     * @return bool
     */
    public function set_keluar($id, $tanggal_keluar, $alasan_keluar)
    {
        return $this->db->where('id', $id)->update($this->table, [
            'status'         => 'keluar',
            'tanggal_keluar' => $tanggal_keluar,
            'alasan_keluar'  => $alasan_keluar
        ]);
    }

    /**
     * Mengaktifkan kembali santri yang sebelumnya keluar
     *
     * @param  int $id ID santri
     * @return bool
     */
    public function set_aktif($id)
    {
        return $this->db->where('id', $id)->update($this->table, [
            'status'         => 'aktif',
            'tanggal_keluar' => null,
            'alasan_keluar'  => null
        ]);
    }

    /**
     * Menempatkan santri ke dalam kelas tertentu
     *
     * @param  int    $santri_id ID santri
     * @param  int    $kelas_id  ID kelas
     * @param  string $tanggal   Tanggal masuk kelas
     * @return int               Insert ID kelas_santri
     */
    public function assign_kelas($santri_id, $kelas_id, $tanggal = null)
    {
        $tanggal_masuk = !empty($tanggal) ? $tanggal : date('Y-m-d');

        // Nonaktifkan keanggotaan kelas sebelumnya jika ada
        $this->db->where('santri_id', $santri_id)
            ->where('tanggal_keluar_kelas IS NULL', null, false)
            ->update('kelas_santri', ['tanggal_keluar_kelas' => $tanggal_masuk]);

        // Insert relasi kelas baru
        $this->db->insert('kelas_santri', [
            'santri_id'           => $santri_id,
            'kelas_id'            => $kelas_id,
            'tanggal_masuk_kelas' => $tanggal_masuk
        ]);

        return $this->db->insert_id();
    }

    /**
     * Mengambil riwayat catatan jilid seorang santri
     *
     * @param  int   $santri_id ID santri
     * @return array            Daftar riwayat perubahan jilid terurut kronologis
     */
    public function get_riwayat_jilid($santri_id)
    {
        $this->db->select('rj.*, klp.nama as nama_kelompok, s.tipe as tipe_semester, ta.nama as nama_tahun_ajaran');
        $this->db->from('riwayat_jilid rj');
        $this->db->join('kelompok klp', 'klp.id = rj.kelompok_id', 'inner');
        $this->db->join('semester s', 's.id = rj.semester_id', 'inner');
        $this->db->join('tahun_ajaran ta', 'ta.id = s.tahun_ajaran_id', 'inner');
        $this->db->where('rj.santri_id', $santri_id);
        $this->db->order_by('rj.tanggal_perubahan', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mencatat perubahan jilid santri ke tabel riwayat_jilid
     *
     * @param  int    $santri_id    ID santri
     * @param  int    $kelompok_id  ID kelompok/jilid baru
     * @param  int    $semester_id  ID semester saat perubahan terjadi
     * @param  string $tanggal      Tanggal perubahan
     * @param  string $keterangan   Keterangan evaluasi / catatan kenaikan jilid
     * @return int                  Insert ID riwayat_jilid
     */
    public function tambah_riwayat_jilid($santri_id, $kelompok_id, $semester_id, $tanggal = null, $keterangan = null)
    {
        $data = [
            'santri_id'         => $santri_id,
            'kelompok_id'       => $kelompok_id,
            'semester_id'       => $semester_id,
            'tanggal_perubahan' => !empty($tanggal) ? $tanggal : date('Y-m-d'),
            'keterangan'        => $keterangan
        ];
        $this->db->insert('riwayat_jilid', $data);
        return $this->db->insert_id();
    }

    /**
     * Mengambil semua riwayat perubahan jilid seluruh santri (untuk monitoring admin)
     *
     * @param  int|null $semester_id Filter semester
     * @return array                 Daftar riwayat jilid lengkap
     */
    public function get_all_riwayat_jilid($semester_id = null)
    {
        $this->db->select('rj.*, st.nama_lengkap as nama_santri, klp.nama as nama_kelompok, s.tipe as tipe_semester, ta.nama as nama_tahun_ajaran');
        $this->db->from('riwayat_jilid rj');
        $this->db->join('santri st', 'st.id = rj.santri_id', 'inner');
        $this->db->join('kelompok klp', 'klp.id = rj.kelompok_id', 'inner');
        $this->db->join('semester s', 's.id = rj.semester_id', 'inner');
        $this->db->join('tahun_ajaran ta', 'ta.id = s.tahun_ajaran_id', 'inner');

        if (!empty($semester_id)) {
            $this->db->where('rj.semester_id', $semester_id);
        }

        $this->db->order_by('rj.tanggal_perubahan', 'DESC');
        return $this->db->get()->result();
    }
}
