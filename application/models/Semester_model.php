<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Semester_model
 *
 * Mengelola data master semester (ganjil/genap) pada tabel `semester`.
 * Menjadi acuan utama bagi pembagian kelas santri, riwayat kenaikan jilid,
 * dan penerbitan raport.
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Master Data
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Semester_model extends CI_Model
{
    /**
     * Nama tabel utama
     * @var string
     */
    protected $table = 'semester';

    /**
     * Mengambil seluruh data semester lengkap dengan informasi tahun ajaran
     *
     * @param  int|null $tahun_ajaran_id Filter opsional berdasarkan tahun ajaran
     * @return array                     Daftar objek semester
     */
    public function get_all($tahun_ajaran_id = null)
    {
        $this->db->select('s.*, ta.nama as nama_tahun_ajaran');
        $this->db->from($this->table . ' s');
        $this->db->join('tahun_ajaran ta', 'ta.id = s.tahun_ajaran_id', 'inner');

        if (!empty($tahun_ajaran_id)) {
            $this->db->where('s.tahun_ajaran_id', $tahun_ajaran_id);
        }

        $this->db->order_by('s.tanggal_mulai', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil semester yang saat ini berstatus aktif
     * Lengkap dengan data tahun ajaran induk
     *
     * @return object|null Objek semester aktif beserta detailnya
     */
    public function get_aktif()
    {
        $this->db->select('s.*, ta.nama as nama_tahun_ajaran');
        $this->db->from($this->table . ' s');
        $this->db->join('tahun_ajaran ta', 'ta.id = s.tahun_ajaran_id', 'inner');
        $this->db->where('s.is_aktif', 1);
        return $this->db->get()->row();
    }

    /**
     * Mengambil satu data semester berdasarkan ID
     *
     * @param  int $id ID semester
     * @return object|null Objek semester
     */
    public function get_by_id($id)
    {
        $this->db->select('s.*, ta.nama as nama_tahun_ajaran');
        $this->db->from($this->table . ' s');
        $this->db->join('tahun_ajaran ta', 'ta.id = s.tahun_ajaran_id', 'inner');
        $this->db->where('s.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Menambahkan semester baru
     *
     * @param  array $data Data semester
     * @return int Insert ID
     */
    public function insert($data)
    {
        if (!empty($data['is_aktif'])) {
            $this->db->update($this->table, ['is_aktif' => 0]);
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Mengupdate data semester
     *
     * @param  int   $id   ID semester
     * @param  array $data Data baru
     * @return bool
     */
    public function update($id, $data)
    {
        if (!empty($data['is_aktif'])) {
            $this->db->where('id !=', $id)->update($this->table, ['is_aktif' => 0]);
        }
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Mengaktifkan semester tertentu
     * Otomatis menonaktifkan semester lain
     *
     * @param  int $id ID semester yang akan diaktifkan
     * @return bool
     */
    public function set_aktif($id)
    {
        // Nonaktifkan seluruh semester
        $this->db->update($this->table, ['is_aktif' => 0]);
        // Aktifkan semester terpilih
        $updated = $this->db->where('id', $id)->update($this->table, ['is_aktif' => 1]);

        // Aktifkan juga tahun ajaran induknya
        $sem = $this->get_by_id($id);
        if ($sem) {
            $this->load->model('TahunAjaran_model');
            $this->TahunAjaran_model->set_aktif($sem->tahun_ajaran_id);
        }

        return $updated;
    }

    /**
     * Menghapus semester
     *
     * @param  int $id ID semester
     * @return bool
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
