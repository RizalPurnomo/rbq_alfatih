<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Auth
 *
 * Mengelola proses autentikasi sistem RBQ Al Fatih:
 * - Menampilkan formulir login
 * - Memvalidasi kredensial pengguna
 * - Menetapkan session role (Admin, Keuangan, Wali Kelas)
 * - Menghancurkan session saat logout
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Authentication
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Auth extends MY_Controller
{
    /**
     * Constructor
     *
     * Memuat library autentikasi internal
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
    }

    /**
     * Halaman Login Pengguna
     *
     * Menampilkan form login serta memproses otentikasi saat form disubmit via POST.
     * Jika user sudah dalam keadaan login, otomatis dialihkan ke dashboard.
     *
     * @return void
     */
    public function login()
    {
        // Jika sudah login, langsung ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
            return;
        }

        // Validasi form login
        $this->form_validation->set_rules('username', 'Username', 'trim|required', [
            'required' => '%s wajib diisi.'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => '%s wajib diisi.'
        ]);

        if ($this->form_validation->run() === TRUE) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $result = $this->auth_lib->login($username, $password);

            if ($result['status'] === TRUE) {
                $this->session->set_flashdata('success', 'Selamat datang kembali, ' . $this->session->userdata('nama') . '!');
                redirect('dashboard');
                return;
            } else {
                $this->session->set_flashdata('error', $result['message']);
                redirect('login');
                return;
            }
        }

        $data['title'] = 'Login Sistem - RBQ Al Fatih';
        $this->load->view('auth/login', $data);
    }

    /**
     * Memproses Logout Pengguna
     *
     * Menghapus seluruh session data dan mengalihkan kembali ke form login.
     *
     * @return void
     */
    public function logout()
    {
        $this->auth_lib->logout();
        $this->session->set_flashdata('success', 'Anda telah berhasil keluar dari sistem.');
        redirect('login');
    }
}
