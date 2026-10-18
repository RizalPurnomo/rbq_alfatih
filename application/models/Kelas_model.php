<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Kelas_model
 *
 * Mengelola data kelas santri pada tabel `kelas`.
 * Setiap kelas terikat pada satu kelompok jilid, satu semester, dan dibimbing oleh satu wali kelas.
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Akademik
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Kelas_model extends CI_Model
{
    /**
     * Nama tabel utama
     * @var string
     */
    protected $table = 'kelas';

    /**
     * Mengambil daftar kelas lengkap dengan relasi kelompok, semester, dan wali kelas
     *
     * @param  int|null $semester_id Filter semester opsional
     * @return array                 Daftar objek kelas
     */
    public function get_all($semester_id = null)
    {
        $this->db->select('k.*, klp.nama as nama_kelompok, klp.urutan as urutan_kelompok, s.tipe as tipe_semester, ta.nama as nama_tahun_ajaran, u.nama as nama_wali_kelas');
        $this->db->from($this->table . ' k');
        $this->db->join('kelompok klp', 'klp.id = k.kelompok_id', 'inner');
        $this->db->join('semester s', 's.id = k.semester_id', 'inner');
        $this->db->join('tahun_ajaran ta', 'ta.id = s.tahun_ajaran_id', 'inner');
        $this->db->join('users u', 'u.id = k.wali_kelas_id', 'left');

        if (!empty($semester_id)) {
            $this->db->where('k.semester_id', $semester_id);
        }

        $this->db->order_by('klp.urutan', 'ASC');
        $this->db->order_by('k.nama', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil satu kelas berdasarkan ID beserta detail relasinya
     *
     * @param  int $id ID kelas
     * @return object|null Objek kelas atau null
     */
    public function get_by_id($id)
    {
        $this->db->select('k.*, klp.nama as nama_kelompok, klp.urutan as urutan_kelompok, s.tipe as tipe_semester, ta.nama as nama_tahun_ajaran, u.nama as nama_wali_kelas');
        $this->db->from($this->table . ' k');
        $this->db->join('kelompok klp', 'klp.id = k.kelompok_id', 'inner');
        $this->db->join('semester s', 's.id = k.semester_id', 'inner');
        $this->db->join('tahun_ajaran ta', 'ta.id = s.tahun_ajaran_id', 'inner');
        $this->db->join('users u', 'u.id = k.wali_kelas_id', 'left');
        $this->db->where('k.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Menyimpan data kelas baru
     *
     * @param  array $data Data kelas (nama, kelompok_id, semester_id, wali_kelas_id)
     * @return int         Insert ID
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Memperbarui data kelas
     *
     * @param  int   $id   ID kelas
     * @param  array $data Data baru
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Menghapus kelas
     *
     * @param  int $id ID kelas
     * @return bool
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
