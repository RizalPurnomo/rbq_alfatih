<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library Auth_lib
 *
 * Mengelola autentikasi dan otorisasi Role-Based Access Control (RBAC)
 * untuk sistem RBQ Al Fatih. Peran yang didukung:
 * - admin: Akses penuh ke seluruh modul sistem
 * - keuangan: Mengelola pengeluaran kas utama, donasi, setoran, dan laporan keuangan
 * - wali_kelas: Mengelola input pembayaran kelas dan nilai raport kelas sendiri
 *
 * @package    RBQ Al Fatih
 * @subpackage Libraries
 * @category   Authentication & Authorization
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Auth_lib
{
    /**
     * Instance CodeIgniter super-object
     * @var object
     */
    protected $CI;

    /**
     * Constructor
     *
     * Inisialisasi CI instance dan session
     */
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->model('User_model');
    }

    /**
     * Memproses login user
     *
     * Memverifikasi username dan password hash. Jika valid dan akun aktif,
     * menyimpan identitas user ke dalam session.
     *
     * @param  string $username Username yang diinput
     * @param  string $password Password teks mentah
     * @return array            Array response ['status' => bool, 'message' => string, 'role' => string|null]
     */
    public function login($username, $password)
    {
        $user = $this->CI->User_model->get_by_username($username);

        if (!$user) {
            return [
                'status'  => false,
                'message' => 'Username tidak ditemukan.',
                'role'    => null
            ];
        }

        if ((int)$user->is_active !== 1) {
            return [
                'status'  => false,
                'message' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator.',
                'role'    => null
            ];
        }

        if (!password_verify($password, $user->password)) {
            return [
                'status'  => false,
                'message' => 'Password yang Anda masukkan salah.',
                'role'    => null
            ];
        }

        // Update last login
        $this->CI->User_model->update_last_login($user->id);

        // Set session data
        $session_data = [
            'user_id'    => (int)$user->id,
            'nama'       => $user->nama,
            'username'   => $user->username,
            'email'      => $user->email,
            'role'       => $user->role,
            'foto'       => $user->foto,
            'logged_in'  => true
        ];
        $this->CI->session->set_userdata($session_data);

        return [
            'status'  => true,
            'message' => 'Login berhasil.',
            'role'    => $user->role
        ];
    }

    /**
     * Memeriksa apakah user sudah login
     *
     * Jika belum login, redirect paksa ke halaman login dengan flash message
     *
     * @return void
     */
    public function check_login()
    {
        if (!$this->CI->session->userdata('logged_in')) {
            $this->CI->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
            redirect('auth/login');
            exit;
        }
    }

    /**
     * Memeriksa apakah role user diizinkan mengakses halaman
     *
     * @param  array|string $allowed_roles Role atau daftar role yang diizinkan (admin, keuangan, wali_kelas)
     * @return void
     */
    public function check_role($allowed_roles)
    {
        $this->check_login();

        if (!is_array($allowed_roles)) {
            $allowed_roles = [$allowed_roles];
        }

        $user_role = $this->CI->session->userdata('role');

        if (!in_array($user_role, $allowed_roles, true)) {
            $this->CI->session->set_flashdata('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
            redirect('dashboard');
            exit;
        }
    }

    /**
     * Mendapatkan ID user yang sedang login
     *
     * @return int|null
     */
    public function get_user_id()
    {
        return $this->CI->session->userdata('user_id');
    }

    /**
     * Mendapatkan role user yang sedang login
     *
     * @return string|null
     */
    public function get_role()
    {
        return $this->CI->session->userdata('role');
    }

    /**
     * Mendapatkan data user lengkap dari session
     *
     * @return array
     */
    public function get_user_data()
    {
        return [
            'id'       => $this->CI->session->userdata('user_id'),
            'nama'     => $this->CI->session->userdata('nama'),
            'username' => $this->CI->session->userdata('username'),
            'email'    => $this->CI->session->userdata('email'),
            'role'     => $this->CI->session->userdata('role'),
            'foto'     => $this->CI->session->userdata('foto')
        ];
    }

    /**
     * Memproses logout user dan menghancurkan session
     *
     * @return void
     */
    public function logout()
    {
        $this->CI->session->sess_destroy();
    }
}
