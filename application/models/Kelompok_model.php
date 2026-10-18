<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Kelompok_model
 *
 * Mengelola data master kelompok/jilid metode Ummi pada tabel `kelompok`.
 * (Pra Ummi, Jilid 1, Jilid 2, Jilid 3, Jilid 4, Jilid 5, Jilid 6).
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Master Data
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Kelompok_model extends CI_Model
{
    /**
     * Nama tabel utama
     * @var string
     */
    protected $table = 'kelompok';

    /**
     * Mengambil semua kelompok/jilid terurut berdasarkan urutan tingkatan
     *
     * @return array Daftar objek kelompok
     */
    public function get_all()
    {
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Mengambil satu data kelompok berdasarkan ID
     *
     * @param  int $id ID kelompok
     * @return object|null Objek kelompok atau null
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
}
