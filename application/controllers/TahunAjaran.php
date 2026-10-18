<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller TahunAjaran
 *
 * Mengelola periode akademik (Tahun Ajaran) dan Semester (Ganjil/Genap) di RBQ Al Fatih:
 * - Menampilkan daftar tahun ajaran dan semester
 * - Menambahkan tahun ajaran baru
 * - Mengaktifkan semester tertentu sebagai acuan operasional sistem
 * - Menambahkan semester baru dalam tahun ajaran
 *
 * Hak Akses: Administrator
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Akademik
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class TahunAjaran extends MY_Controller
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

        $this->load->model('TahunAjaran_model');
        $this->load->model('Semester_model');
    }

    /**
     * Menampilkan daftar tahun ajaran dan semester
     *
     * @return void
     */
    public function index()
    {
        $data['title']               = 'Tahun Ajaran & Semester - RBQ Al Fatih';
        $data['active_menu']         = 'tahun_ajaran';
        $data['current_semester']    = $this->Semester_model->get_aktif();
        $data['current_ta']          = $this->TahunAjaran_model->get_aktif();
        $data['daftar_tahun_ajaran'] = $this->TahunAjaran_model->get_all();
        $data['daftar_semester']     = $this->Semester_model->get_all();

        $this->load->view('layout/header', $data);
        $this->load->view('tahun_ajaran/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan data tahun ajaran baru
     *
     * @return void
     */
    public function simpan_ta()
    {
        $this->form_validation->set_rules('nama', 'Nama Tahun Ajaran', 'trim|required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('tahun_ajaran');
            return;
        }

        $data = [
            'nama'            => $this->input->post('nama', TRUE),
            'tanggal_mulai'   => $this->input->post('tanggal_mulai', TRUE),
            'tanggal_selesai' => $this->input->post('tanggal_selesai', TRUE),
            'is_aktif'        => 0
        ];

        $ta_id = $this->TahunAjaran_model->insert($data);

        // Otomatis buat 2 semester (Ganjil & Genap)
        $this->Semester_model->insert([
            'tahun_ajaran_id' => $ta_id,
            'tipe'            => 'ganjil',
            'tanggal_mulai'   => $data['tanggal_mulai'],
            'tanggal_selesai' => date('Y-12-31', strtotime($data['tanggal_mulai'])),
            'is_aktif'        => 0
        ]);

        $this->Semester_model->insert([
            'tahun_ajaran_id' => $ta_id,
            'tipe'            => 'genap',
            'tanggal_mulai'   => date('Y-01-01', strtotime($data['tanggal_selesai'])),
            'tanggal_selesai' => $data['tanggal_selesai'],
            'is_aktif'        => 0
        ]);

        $this->session->set_flashdata('success', 'Tahun ajaran baru dan 2 semester (Ganjil/Genap) berhasil dibuat.');
        redirect('tahun_ajaran');
    }

    /**
     * Mengaktifkan semester tertentu
     *
     * @param  int $semester_id ID semester yang akan dijadikan acuan aktif
     * @return void
     */
    public function set_aktif_semester($semester_id)
    {
        $this->Semester_model->set_aktif($semester_id);
        $this->session->set_flashdata('success', 'Periode semester aktif berhasil diperbarui.');
        redirect('tahun_ajaran');
    }
}
