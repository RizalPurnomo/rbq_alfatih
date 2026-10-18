<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Users
 *
 * Mengelola akun pengguna sistem RBQ Al Fatih:
 * - Menampilkan daftar user dan peran (admin, keuangan, wali_kelas)
 * - Menambahkan akun baru
 * - Mengubah data akun dan role
 * - Mengaktifkan / menonaktifkan akun
 *
 * Hak Akses: Administrator
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Pengguna
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Users extends MY_Controller
{
    /**
     * Constructor
     *
     * Memeriksa otentikasi role 'admin'
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();
        $this->auth_lib->check_role('admin');

        $this->load->model('User_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
    }

    /**
     * Menampilkan daftar pengguna
     *
     * @return void
     */
    public function index()
    {
        $data['title']            = 'Manajemen Pengguna - RBQ Al Fatih';
        $data['active_menu']      = 'users';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_users']     = $this->User_model->get_all();

        $this->load->view('layout/header', $data);
        $this->load->view('users/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan pengguna baru
     *
     * @return void
     */
    public function simpan()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('role', 'Peran / Hak Akses', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('users');
            return;
        }

        $data = [
            'nama'      => $this->input->post('nama', TRUE),
            'username'  => $this->input->post('username', TRUE),
            'email'     => $this->input->post('email', TRUE) ?: null,
            'password'  => $this->input->post('password', TRUE),
            'role'      => $this->input->post('role', TRUE),
            'is_active' => 1
        ];

        $this->User_model->insert($data);
        $this->session->set_flashdata('success', 'Pengguna ' . $data['username'] . ' berhasil didaftarkan.');
        redirect('users');
    }

    /**
     * Mengubah data pengguna
     *
     * @return void
     */
    public function update()
    {
        $id = (int)$this->input->post('user_id', TRUE);

        $data = [
            'nama'      => $this->input->post('nama', TRUE),
            'email'     => $this->input->post('email', TRUE) ?: null,
            'role'      => $this->input->post('role', TRUE),
            'is_active' => (int)$this->input->post('is_active', TRUE)
        ];

        $password = $this->input->post('password', TRUE);
        if (!empty($password)) {
            $data['password'] = $password;
        }

        $this->User_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui.');
        redirect('users');
    }
}
