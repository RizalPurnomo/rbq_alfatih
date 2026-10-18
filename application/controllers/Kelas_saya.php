<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Kelas_saya
 *
 * Mengelola ruang kerja wali kelas untuk memantau kelas binaannya di semester aktif:
 * - Menampilkan daftar seluruh santri dalam kelas
 * - Melihat status pembayaran santri bulan berjalan
 * - Akses cepat ke input pembayaran SPP dan input nilai pertemuan
 *
 * Hak Akses: Wali Kelas dan Administrator
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Wali Kelas
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Kelas_saya extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $this->load->model('Santri_model');
        $this->load->model('Kelas_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
    }

    /**
     * Menampilkan daftar santri kelas binaan
     *
     * @return void
     */
    public function index()
    {
        $role        = $this->session->userdata('role');
        $user_id     = $this->session->userdata('user_id');
        $sem_aktif   = $this->Semester_model->get_aktif();
        $semester_id = $sem_aktif ? $sem_aktif->id : 1;

        if ($role === 'wali_kelas') {
            $kelas = $this->db->get_where('kelas', [
                'wali_kelas_id' => $user_id,
                'semester_id'   => $semester_id
            ])->row();
        } else {
            $kelas_id = $this->input->get('kelas_id', TRUE);
            $kelas    = !empty($kelas_id) ? $this->Kelas_model->get_by_id($kelas_id) : $this->db->get_where('kelas', ['semester_id' => $semester_id])->row();
        }

        $data['title']            = 'Santri Kelas Saya - RBQ Al Fatih';
        $data['active_menu']      = 'kelas_saya';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['kelas']            = $kelas;
        $data['daftar_kelas']     = $this->Kelas_model->get_all($semester_id);

        if (!empty($kelas)) {
            $data['daftar_santri'] = $this->Santri_model->get_all(['kelas_id' => $kelas->id, 'status' => 'aktif']);
        } else {
            $data['daftar_santri'] = [];
        }

        $this->load->view('layout/header', $data);
        $this->load->view('kelas_saya/index', $data);
        $this->load->view('layout/footer', $data);
    }
}
