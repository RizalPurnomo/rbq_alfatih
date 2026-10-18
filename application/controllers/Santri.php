<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Santri
 *
 * Mengelola seluruh siklus data santri di RBQ Al Fatih:
 * - Menampilkan daftar santri aktif dan santri keluar
 * - Mendaftarkan santri baru beserta penempatan jilid dan kelas
 * - Melihat profil detail santri dan riwayat mutasi kelas
 * - Mengubah data profil santri
 * - Mencatat santri keluar beserta alasan
 * - Mengelola catatan riwayat kenaikan jilid (Metode Ummi)
 *
 * Hak Akses: Administrator
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Kesiswaan
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Santri extends MY_Controller
{
    /**
     * Constructor
     *
     * Memeriksa otentikasi dan otorisasi role 'admin'
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();
        $this->auth_lib->check_role('admin');

        $this->load->model('Santri_model');
        $this->load->model('Kelompok_model');
        $this->load->model('Kelas_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
    }

    /**
     * Menampilkan daftar seluruh santri
     *
     * Mendukung filter status (aktif/keluar), filter kelas, dan filter kelompok/jilid.
     *
     * @return void
     */
    public function index()
    {
        $status       = $this->input->get('status', TRUE) ?: 'aktif';
        $kelas_id     = $this->input->get('kelas_id', TRUE);
        $kelompok_id  = $this->input->get('kelompok_id', TRUE);

        $sem_aktif    = $this->Semester_model->get_aktif();
        $semester_id  = $sem_aktif ? $sem_aktif->id : null;

        $filter = [
            'status'      => $status,
            'kelas_id'    => $kelas_id,
            'kelompok_id' => $kelompok_id,
            'semester_id' => $semester_id
        ];

        $data['title']            = 'Data Santri - RBQ Al Fatih';
        $data['active_menu']      = 'santri';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_santri']    = $this->Santri_model->get_all($filter);
        $data['daftar_kelompok']  = $this->Kelompok_model->get_all();
        $data['daftar_kelas']     = $this->Kelas_model->get_all($semester_id);
        $data['filter_status']    = $status;
        $data['filter_kelas']     = $kelas_id;
        $data['filter_kelompok']  = $kelompok_id;

        $this->load->view('layout/header', $data);
        $this->load->view('santri/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menampilkan form pendaftaran santri baru
     *
     * @return void
     */
    public function tambah()
    {
        $sem_aktif = $this->Semester_model->get_aktif();
        $sem_id    = $sem_aktif ? $sem_aktif->id : null;

        $data['title']            = 'Tambah Santri Baru - RBQ Al Fatih';
        $data['active_menu']      = 'santri';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_kelompok']  = $this->Kelompok_model->get_all();
        $data['daftar_kelas']     = $this->Kelas_model->get_all($sem_id);

        $this->load->view('layout/header', $data);
        $this->load->view('santri/tambah', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Memproses penyimpanan data santri baru
     *
     * Menyimpan biodata santri, menempatkan pada kelas terpilih,
     * serta mencatat riwayat jilid awal metode Ummi.
     *
     * @return void
     */
    public function simpan()
    {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required', [
            'required' => '%s wajib diisi.'
        ]);
        $this->form_validation->set_rules('nama_wali', 'Nama Wali', 'trim|required', [
            'required' => '%s wajib diisi.'
        ]);
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'trim|required', [
            'required' => '%s wajib diisi.'
        ]);
        $this->form_validation->set_rules('kelompok_id', 'Kelompok / Jilid Awal', 'trim|required', [
            'required' => '%s wajib dipilih.'
        ]);

        if ($this->form_validation->run() === FALSE) {
            $this->tambah();
            return;
        }

        $sem_aktif = $this->Semester_model->get_aktif();
        $sem_id    = $sem_aktif ? $sem_aktif->id : 1;

        $data_santri = [
            'nama_lengkap'   => $this->input->post('nama_lengkap', TRUE),
            'nama_panggilan' => $this->input->post('nama_panggilan', TRUE),
            'tempat_lahir'   => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir'  => $this->input->post('tanggal_lahir', TRUE) ?: null,
            'jenis_kelamin'  => $this->input->post('jenis_kelamin', TRUE) ?: 'L',
            'alamat'         => $this->input->post('alamat', TRUE),
            'nama_wali'      => $this->input->post('nama_wali', TRUE),
            'no_hp_wali'     => $this->input->post('no_hp_wali', TRUE),
            'tanggal_masuk'  => $this->input->post('tanggal_masuk', TRUE),
            'status'         => 'aktif'
        ];

        // 1. Simpan data santri
        $santri_id = $this->Santri_model->insert($data_santri);

        // 2. Catat riwayat jilid awal
        $kelompok_id = (int)$this->input->post('kelompok_id', TRUE);
        $this->Santri_model->tambah_riwayat_jilid(
            $santri_id,
            $kelompok_id,
            $sem_id,
            $data_santri['tanggal_masuk'],
            'Penerimaan Santri Baru (Placement Awal)'
        );

        // 3. Tempatkan ke kelas bila kelas dipilih
        $kelas_id = $this->input->post('kelas_id', TRUE);
        if (!empty($kelas_id)) {
            $this->Santri_model->assign_kelas($santri_id, (int)$kelas_id, $data_santri['tanggal_masuk']);
        }

        $this->session->set_flashdata('success', 'Data santri baru ' . $data_santri['nama_lengkap'] . ' berhasil ditambahkan.');
        redirect('santri');
    }

    /**
     * Menampilkan halaman profil detail santri
     *
     * Berisi rincian biodata, kelompok/jilid saat ini, wali kelas,
     * serta riwayat kenaikan jilid dari waktu ke waktu.
     *
     * @param  int $id ID santri
     * @return void
     */
    public function detail($id)
    {
        $sem_aktif = $this->Semester_model->get_aktif();
        $sem_id    = $sem_aktif ? $sem_aktif->id : null;

        $santri = $this->Santri_model->get_by_id($id, $sem_id);

        if (!$santri) {
            $this->session->set_flashdata('error', 'Data santri tidak ditemukan.');
            redirect('santri');
            return;
        }

        $data['title']            = 'Profil Santri: ' . $santri->nama_lengkap . ' - RBQ Al Fatih';
        $data['active_menu']      = 'santri';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['santri']           = $santri;
        $data['riwayat_jilid']    = $this->Santri_model->get_riwayat_jilid($id);
        $data['daftar_kelompok']  = $this->Kelompok_model->get_all();
        $data['daftar_kelas']     = $this->Kelas_model->get_all($sem_id);

        $this->load->view('layout/header', $data);
        $this->load->view('santri/detail', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menampilkan formulir edit santri
     *
     * @param  int $id ID santri
     * @return void
     */
    public function edit($id)
    {
        $santri = $this->Santri_model->get_by_id($id);

        if (!$santri) {
            $this->session->set_flashdata('error', 'Data santri tidak ditemukan.');
            redirect('santri');
            return;
        }

        $sem_aktif = $this->Semester_model->get_aktif();
        $sem_id    = $sem_aktif ? $sem_aktif->id : null;

        $data['title']            = 'Edit Santri: ' . $santri->nama_lengkap . ' - RBQ Al Fatih';
        $data['active_menu']      = 'santri';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['santri']           = $santri;
        $data['daftar_kelas']     = $this->Kelas_model->get_all($sem_id);

        $this->load->view('layout/header', $data);
        $this->load->view('santri/edit', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Memproses update data profil santri
     *
     * @param  int $id ID santri
     * @return void
     */
    public function update($id)
    {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('nama_wali', 'Nama Wali', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
            return;
        }

        $data = [
            'nama_lengkap'   => $this->input->post('nama_lengkap', TRUE),
            'nama_panggilan' => $this->input->post('nama_panggilan', TRUE),
            'tempat_lahir'   => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir'  => $this->input->post('tanggal_lahir', TRUE) ?: null,
            'jenis_kelamin'  => $this->input->post('jenis_kelamin', TRUE),
            'alamat'         => $this->input->post('alamat', TRUE),
            'nama_wali'      => $this->input->post('nama_wali', TRUE),
            'no_hp_wali'     => $this->input->post('no_hp_wali', TRUE)
        ];

        $this->Santri_model->update($id, $data);

        // Update penempatan kelas jika ada perubahan
        $kelas_id = $this->input->post('kelas_id', TRUE);
        if (!empty($kelas_id)) {
            $this->Santri_model->assign_kelas($id, (int)$kelas_id);
        }

        $this->session->set_flashdata('success', 'Data santri berhasil diperbarui.');
        redirect('santri/detail/' . $id);
    }

    /**
     * Memproses status santri keluar
     *
     * @return void
     */
    public function keluar()
    {
        $id             = (int)$this->input->post('santri_id', TRUE);
        $tanggal_keluar = $this->input->post('tanggal_keluar', TRUE) ?: date('Y-m-d');
        $alasan_keluar  = $this->input->post('alasan_keluar', TRUE);

        $this->Santri_model->set_keluar($id, $tanggal_keluar, $alasan_keluar);
        $this->session->set_flashdata('success', 'Santri telah ditandai sebagai keluar dari RBQ Al Fatih.');
        redirect('santri?status=keluar');
    }

    /**
     * Mengaktifkan kembali santri yang pernah keluar
     *
     * @param  int $id ID santri
     * @return void
     */
    public function aktifkan($id)
    {
        $this->Santri_model->set_aktif($id);
        $this->session->set_flashdata('success', 'Santri berhasil diaktifkan kembali.');
        redirect('santri/detail/' . $id);
    }

    /**
     * Memproses kenaikan jilid santri
     *
     * Mencatat perubahan jilid pada riwayat jilid dan memperbarui penempatan kelas bila diarahkan.
     *
     * @return void
     */
    public function naik_jilid()
    {
        $santri_id   = (int)$this->input->post('santri_id', TRUE);
        $kelompok_id = (int)$this->input->post('kelompok_id', TRUE);
        $tanggal     = $this->input->post('tanggal_perubahan', TRUE) ?: date('Y-m-d');
        $keterangan  = $this->input->post('keterangan', TRUE);

        $sem_aktif = $this->Semester_model->get_aktif();
        $sem_id    = $sem_aktif ? $sem_aktif->id : 1;

        $this->Santri_model->tambah_riwayat_jilid($santri_id, $kelompok_id, $sem_id, $tanggal, $keterangan);

        $this->session->set_flashdata('success', 'Riwayat kenaikan jilid berhasil dicatat.');
        redirect('santri/detail/' . $santri_id);
    }

    /**
     * Menampilkan daftar riwayat jilid seluruh santri (Monitoring kenaikan jilid)
     *
     * @return void
     */
    public function riwayat_jilid()
    {
        $sem_aktif   = $this->Semester_model->get_aktif();
        $semester_id = $this->input->get('semester_id', TRUE) ?: ($sem_aktif ? $sem_aktif->id : null);

        $data['title']            = 'Riwayat Perubahan Jilid Santri - RBQ Al Fatih';
        $data['active_menu']      = 'riwayat_jilid';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_riwayat']   = $this->Santri_model->get_all_riwayat_jilid($semester_id);
        $data['daftar_semester']  = $this->Semester_model->get_all();
        $data['filter_semester']  = $semester_id;

        $this->load->view('layout/header', $data);
        $this->load->view('santri/riwayat_jilid', $data);
        $this->load->view('layout/footer', $data);
    }
}
