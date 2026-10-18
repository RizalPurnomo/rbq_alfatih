<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model User_model
 *
 * Mengelola manipulasi data pengguna (users) pada tabel `users`.
 * Mendukung autentikasi, manajemen pengguna, dan relasi peran (admin, keuangan, wali_kelas).
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Users
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class User_model extends CI_Model
{
    /**
     * Nama tabel utama
     * @var string
     */
    protected $table = 'users';

    /**
     * Mengambil satu user berdasarkan username
     *
     * @param  string $username Username user
     * @return object|null       Objek user atau null bila tidak ditemukan
     */
    public function get_by_username($username)
    {
        return $this->db->get_where($this->table, ['username' => $username])->row();
    }

    /**
     * Mengambil satu user berdasarkan ID
     *
     * @param  int $id ID user
     * @return object|null Objek user atau null bila tidak ditemukan
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Mengambil semua user dengan filter role opsional
     *
     * @param  string|null $role Filter role ('admin', 'keuangan', 'wali_kelas')
     * @return array             Daftar objek user
     */
    public function get_all($role = null)
    {
        if (!empty($role)) {
            $this->db->where('role', $role);
        }
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Mengambil daftar user dengan peran wali kelas aktif
     * Digunakan untuk dropdown pemilihan wali kelas
     *
     * @return array Daftar user ber-role 'wali_kelas' yang aktif
     */
    public function get_wali_kelas_list()
    {
        $this->db->where('role', 'wali_kelas');
        $this->db->where('is_active', 1);
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Menyimpan data user baru ke database
     *
     * @param  array $data Data user (nama, username, email, password, role, is_active)
     * @return int|bool    Insert ID jika berhasil, false jika gagal
     */
    public function insert($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Mengupdate data user yang ada
     *
     * @param  int   $id   ID user yang akan diperbarui
     * @param  array $data Data yang akan diperbarui
     * @return bool        True bila berhasil, false bila gagal
     */
    public function update($id, $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Memperbarui timestamp login terakhir
     *
     * @param  int $id ID user
     * @return bool    True bila berhasil
     */
    public function update_last_login($id)
    {
        return $this->db->where('id', $id)->update($this->table, [
            'last_login' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Menghapus user berdasarkan ID
     *
     * @param  int $id ID user
     * @return bool    True bila berhasil
     */
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
