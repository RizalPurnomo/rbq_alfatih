<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model TahunAjaran_model
 *
 * Mengelola data master tahun ajaran pada tabel `tahun_ajaran`.
 * Menjadi induk dari data semester (ganjil/genap).
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Master Data
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class TahunAjaran_model extends CI_Model
{
    /**
     * Nama tabel utama
     * @var string
     */
    protected $table = 'tahun_ajaran';

    /**
     * Mengambil semua data tahun ajaran
     *
     * @return array Daftar objek tahun ajaran
     */
    public function get_all()
    {
        $this->db->order_by('tanggal_mulai', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Mengambil satu data tahun ajaran berdasarkan ID
     *
     * @param  int $id ID tahun ajaran
     * @return object|null Objek tahun ajaran atau null
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Mengambil tahun ajaran yang berstatus aktif
     *
     * @return object|null Objek tahun ajaran aktif atau null
     */
    public function get_aktif()
    {
        return $this->db->get_where($this->table, ['is_aktif' => 1])->row();
    }

    /**
     * Menambahkan data tahun ajaran baru
     *
     * @param  array $data Data tahun ajaran
     * @return int Insert ID
     */
    public function insert($data)
    {
        // Jika diset aktif, nonaktifkan tahun ajaran lainnya
        if (!empty($data['is_aktif'])) {
            $this->db->update($this->table, ['is_aktif' => 0]);
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Mengubah data tahun ajaran
     *
     * @param  int   $id   ID tahun ajaran
     * @param  array $data Data yang akan diubah
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
     * Mengatur status aktif untuk tahun ajaran tertentu
     *
     * @param  int $id ID tahun ajaran yang akan diaktifkan
     * @return bool
     */
    public function set_aktif($id)
    {
        // Nonaktifkan semua tahun ajaran terlebih dahulu
        $this->db->update($this->table, ['is_aktif' => 0]);
        // Aktifkan yang dipilih
        return $this->db->where('id', $id)->update($this->table, ['is_aktif' => 1]);
    }

    /**
     * Menghapus tahun ajaran
     *
     * @param  int $id ID tahun ajaran
     * @return bool
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
