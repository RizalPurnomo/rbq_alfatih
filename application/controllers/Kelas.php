<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Kelas
 *
 * Mengelola data kelas santri di RBQ Al Fatih:
 * - Menampilkan daftar kelas pada semester aktif
 * - Menambahkan kelas baru dalam kelompok/jilid tertentu
 * - Menetapkan (assign) ustadz/ustadzah wali kelas
 * - Mengubah dan menghapus data kelas
 *
 * Hak Akses: Administrator
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Akademik
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Kelas extends CI_Controller
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

        $this->load->model('Kelas_model');
        $this->load->model('Kelompok_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
        $this->load->model('User_model');
    }

    /**
     * Menampilkan daftar seluruh kelas pada semester aktif
     *
     * @return void
     */
    public function index()
    {
        $sem_aktif   = $this->Semester_model->get_aktif();
        $semester_id = $this->input->get('semester_id', TRUE) ?: ($sem_aktif ? $sem_aktif->id : null);

        $data['title']            = 'Manajemen Kelas - RBQ Al Fatih';
        $data['active_menu']      = 'kelas';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_kelas']     = $this->Kelas_model->get_all($semester_id);
        $data['daftar_kelompok']  = $this->Kelompok_model->get_all();
        $data['daftar_wali_kelas']= $this->User_model->get_wali_kelas_list();
        $data['daftar_semester']  = $this->Semester_model->get_all();
        $data['filter_semester']  = $semester_id;

        $this->load->view('layout/header', $data);
        $this->load->view('kelas/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan kelas baru
     *
     * @return void
     */
    public function simpan()
    {
        $this->form_validation->set_rules('nama', 'Nama Kelas', 'trim|required');
        $this->form_validation->set_rules('kelompok_id', 'Kelompok / Jilid', 'trim|required');
        $this->form_validation->set_rules('semester_id', 'Semester', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('kelas');
            return;
        }

        $data = [
            'nama'          => $this->input->post('nama', TRUE),
            'kelompok_id'   => (int)$this->input->post('kelompok_id', TRUE),
            'semester_id'   => (int)$this->input->post('semester_id', TRUE),
            'wali_kelas_id' => $this->input->post('wali_kelas_id', TRUE) ?: null
        ];

        $this->Kelas_model->insert($data);
        $this->session->set_flashdata('success', 'Kelas baru ' . $data['nama'] . ' berhasil ditambahkan.');
        redirect('kelas');
    }

    /**
     * Memperbarui data kelas
     *
     * @return void
     */
    public function update()
    {
        $id = (int)$this->input->post('kelas_id', TRUE);

        $data = [
            'nama'          => $this->input->post('nama', TRUE),
            'kelompok_id'   => (int)$this->input->post('kelompok_id', TRUE),
            'semester_id'   => (int)$this->input->post('semester_id', TRUE),
            'wali_kelas_id' => $this->input->post('wali_kelas_id', TRUE) ?: null
        ];

        $this->Kelas_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data kelas berhasil diperbarui.');
        redirect('kelas');
    }

    /**
     * Menghapus kelas
     *
     * @param  int $id ID kelas
     * @return void
     */
    public function hapus($id)
    {
        $this->Kelas_model->delete($id);
        $this->session->set_flashdata('success', 'Kelas berhasil dihapus.');
        redirect('kelas');
    }
}
