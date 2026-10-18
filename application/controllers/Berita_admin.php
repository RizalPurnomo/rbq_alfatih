<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Berita_admin
 *
 * Mengelola publikasi event dan berita oleh Administrator:
 * - Menampilkan daftar berita / event
 * - Menambah artikel baru
 * - Mengubah dan menghapus artikel
 *
 * Hak Akses: Administrator
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Berita & Event
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Berita_admin extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();
        $this->auth_lib->check_role('admin');

        $this->load->model('Berita_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
    }

    /**
     * Menampilkan daftar berita
     *
     * @return void
     */
    public function index()
    {
        $data['title']            = 'Manajemen Event & Berita - RBQ Al Fatih';
        $data['active_menu']      = 'berita_admin';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_berita']    = $this->Berita_model->get_all();

        $this->load->view('layout/header', $data);
        $this->load->view('berita_admin/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan artikel baru
     *
     * @return void
     */
    public function simpan()
    {
        $this->form_validation->set_rules('judul', 'Judul Berita', 'trim|required');
        $this->form_validation->set_rules('konten', 'Isi Konten', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('berita_admin');
            return;
        }

        $data = [
            'judul'           => $this->input->post('judul', TRUE),
            'kategori'        => $this->input->post('kategori', TRUE) ?: 'berita',
            'konten'          => $this->input->post('konten', TRUE),
            'tanggal_publish' => $this->input->post('tanggal_publish', TRUE) ?: date('Y-m-d'),
            'is_published'    => 1,
            'dibuat_oleh'     => $this->session->userdata('user_id')
        ];

        $this->Berita_model->insert($data);
        $this->session->set_flashdata('success', 'Berita berhasil dipublikasikan ke Website Profil.');
        redirect('berita_admin');
    }

    /**
     * Menghapus berita
     *
     * @param  int $id ID berita
     * @return void
     */
    public function hapus($id)
    {
        $this->Berita_model->delete($id);
        $this->session->set_flashdata('success', 'Berita berhasil dihapus.');
        redirect('berita_admin');
    }
}
