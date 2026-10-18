<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Pengajar_model
 *
 * Mengelola data profil tenaga pengajar (Asatidz dan Asatidzah) di RBQ Al Fatih:
 * - Data biodata, gelar, jabatan di lembaga
 * - Latar belakang pendidikan & almamater
 * - Lisensi/Sertifikasi Metode Ummi, Syahadah Tahfidz, dan Sanad
 * - Pengalaman mengajar dan portofolio
 * - Spesialisasi keahlian dan quote inspiratif
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Database Model
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.2
 */
class Pengajar_model extends CI_Model
{
    /** @var string Nama tabel pengajar */
    private $table = 'pengajar';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Mengambil seluruh data pengajar dengan opsi filter jenis kelamin & status aktif
     *
     * @param  string|null $jenis_kelamin Filter 'L' (Ikhwan) atau 'P' (Akhwat)
     * @param  bool        $only_active   Hanya ambil yang aktif (default TRUE)
     * @return array                      Daftar objek data pengajar
     */
    public function get_all($jenis_kelamin = null, $only_active = true)
    {
        $this->db->select('*');
        $this->db->from($this->table);

        if ($only_active) {
            $this->db->where('is_active', 1);
        }

        if (!empty($jenis_kelamin) && in_array(strtoupper($jenis_kelamin), ['L', 'P'])) {
            $this->db->where('jenis_kelamin', strtoupper($jenis_kelamin));
        }

        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('id', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Mengambil data satu pengajar berdasarkan ID
     *
     * @param  int $id ID pengajar
     * @return object|null Objek pengajar atau null jika tidak ditemukan
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => (int)$id])->row();
    }

    /**
     * Menambahkan data pengajar baru
     *
     * @param  array $data Data field pengajar
     * @return int|bool    ID pengajar yang baru ditambahkan atau false
     */
    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Memperbarui data profil pengajar
     *
     * @param  int   $id   ID pengajar
     * @param  array $data Data perubahan
     * @return bool        Status keberhasilan update
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, ['id' => (int)$id]);
    }

    /**
     * Menghapus data pengajar
     *
     * @param  int $id ID pengajar
     * @return bool    Status keberhasilan delete
     */
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => (int)$id]);
    }

    /**
     * Menghitung total pengajar aktif
     *
     * @return int Jumlah pengajar aktif
     */
    public function count_active()
    {
        return $this->db->where('is_active', 1)->count_all_results($this->table);
    }
}
