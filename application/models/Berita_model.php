<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Berita_model
 *
 * Mengelola data event dan berita pada tabel `berita`.
 * Ditampilkan di website profil publik serta widget dashboard.
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   News & Events
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Berita_model extends CI_Model
{
    /**
     * Nama tabel utama
     * @var string
     */
    protected $table = 'berita';

    /**
     * Mengambil daftar berita yang sudah dipublikasikan (untuk website profil)
     *
     * @param  int         $limit    Batas jumlah berita yang diambil
     * @param  string|null $kategori Filter kategori ('event' atau 'berita')
     * @return array                 Daftar objek berita
     */
    public function get_published($limit = 6, $kategori = null)
    {
        $this->db->select('b.*, u.nama as nama_penulis');
        $this->db->from($this->table . ' b');
        $this->db->join('users u', 'u.id = b.dibuat_oleh', 'left');
        $this->db->where('b.is_published', 1);

        if (!empty($kategori)) {
            $this->db->where('b.kategori', $kategori);
        }

        $this->db->order_by('b.tanggal_publish', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    /**
     * Mengambil satu berita berdasarkan slug
     *
     * @param  string $slug Slug berita
     * @return object|null  Objek berita atau null jika tidak ditemukan
     */
    public function get_by_slug($slug)
    {
        $this->db->select('b.*, u.nama as nama_penulis');
        $this->db->from($this->table . ' b');
        $this->db->join('users u', 'u.id = b.dibuat_oleh', 'left');
        $this->db->where('b.slug', $slug);
        $this->db->where('b.is_published', 1);
        return $this->db->get()->row();
    }

    /**
     * Mengambil semua berita (untuk manajemen admin)
     *
     * @return array Daftar semua objek berita
     */
    public function get_all()
    {
        $this->db->select('b.*, u.nama as nama_penulis');
        $this->db->from($this->table . ' b');
        $this->db->join('users u', 'u.id = b.dibuat_oleh', 'left');
        $this->db->order_by('b.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Menyimpan data berita baru
     *
     * @param  array $data Data berita
     * @return int         Insert ID
     */
    public function insert($data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = url_title($data['judul'], '-', TRUE) . '-' . time();
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Memperbarui data berita
     *
     * @param  int   $id   ID berita
     * @param  array $data Data baru
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Menghapus berita berdasarkan ID
     *
     * @param  int $id ID berita
     * @return bool
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
