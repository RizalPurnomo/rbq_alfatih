<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Tabungan
 *
 * Mengelola tabungan santri di RBQ Al Fatih:
 * - Menampilkan daftar saldo tabungan seluruh santri
 * - Melihat rincian mutasi tabungan (setoran masuk & penarikan)
 * - Mencatat penarikan/pengambilan tabungan oleh santri
 *
 * Hak Akses: Administrator dan Petugas Keuangan
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Tabungan
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Tabungan extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();
        $this->auth_lib->check_role(['admin', 'keuangan']);

        $this->load->model('Tabungan_model');
        $this->load->model('Santri_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
    }

    /**
     * Menampilkan rekap tabungan seluruh santri
     *
     * @return void
     */
    public function index()
    {
        $data['title']            = 'Tabungan Santri - RBQ Al Fatih';
        $data['active_menu']      = 'tabungan';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_tabungan']  = $this->Tabungan_model->get_rekap_tabungan_santri();

        $this->load->view('layout/header', $data);
        $this->load->view('tabungan/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menampilkan riwayat transaksi tabungan santri tertentu
     *
     * @param  int $santri_id ID santri
     * @return void
     */
    public function detail($santri_id)
    {
        $santri = $this->Santri_model->get_by_id($santri_id);
        if (!$santri) {
            $this->session->set_flashdata('error', 'Data santri tidak ditemukan.');
            redirect('tabungan');
            return;
        }

        $data['title']            = 'Buku Tabungan: ' . $santri->nama_lengkap . ' - RBQ Al Fatih';
        $data['active_menu']      = 'tabungan';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['santri']           = $santri;
        $data['saldo_saat_ini']   = $this->Tabungan_model->get_saldo_santri($santri_id);
        $data['riwayat_mutasi']   = $this->Tabungan_model->get_riwayat_santri($santri_id);

        $this->load->view('layout/header', $data);
        $this->load->view('tabungan/detail', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Memproses penarikan tabungan santri
     *
     * @return void
     */
    public function proses_tarik()
    {
        $santri_id   = (int)$this->input->post('santri_id', TRUE);
        $nominal     = (float)$this->input->post('nominal', TRUE);
        $tanggal     = $this->input->post('tanggal', TRUE) ?: date('Y-m-d');
        $keterangan  = $this->input->post('keterangan', TRUE);
        $user_id     = $this->session->userdata('user_id');

        $result = $this->Tabungan_model->catat_penarikan($santri_id, $nominal, $tanggal, $keterangan, $user_id);

        if ($result['status'] === TRUE) {
            $this->session->set_flashdata('success', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }

        redirect('tabungan/detail/' . $santri_id);
    }
}
