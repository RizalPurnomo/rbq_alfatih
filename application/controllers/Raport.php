<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Raport
 *
 * Mengelola evaluasi pembelajaran dan penerbitan raport santri di RBQ Al Fatih:
 * - Input nilai santri per pertemuan bulanan (Wali Kelas)
 * - Kompilasi otomatis ledger nilai rata-rata dan peringkat kelas
 * - Input evaluasi kepribadian santri (Tertib, Disiplin, Motivasi Belajar: A, B, C, D)
 * - Rekapitulasi absensi santri (Sakit, Izin, Tanpa Keterangan)
 * - Cetak Raport Semester format resmi
 *
 * Hak Akses: Wali Kelas dan Administrator
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Akademik & Raport
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Raport extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();

        $this->load->model('Raport_model');
        $this->load->model('Santri_model');
        $this->load->model('Kelas_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
    }

    /**
     * Halaman Monitoring Raport untuk Administrator
     *
     * @return void
     */
    public function index()
    {
        $this->auth_lib->check_role('admin');

        $sem_aktif   = $this->Semester_model->get_aktif();
        $semester_id = $sem_aktif ? $sem_aktif->id : null;

        $data['title']            = 'Ledger & Raport Santri - RBQ Al Fatih';
        $data['active_menu']      = 'raport';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_kelas']     = $this->Kelas_model->get_all($semester_id);

        $this->load->view('layout/header', $data);
        $this->load->view('raport/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Halaman Input Nilai Pertemuan Santri per Bulan
     *
     * @return void
     */
    public function nilai_pertemuan()
    {
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $role        = $this->session->userdata('role');
        $user_id     = $this->session->userdata('user_id');
        $sem_aktif   = $this->Semester_model->get_aktif();
        $semester_id = $sem_aktif ? $sem_aktif->id : null;

        if ($role === 'wali_kelas') {
            $kelas = $this->db->get_where('kelas', [
                'wali_kelas_id' => $user_id,
                'semester_id'   => $semester_id
            ])->row();
            $kelas_id = $kelas ? $kelas->id : null;
        } else {
            $kelas_id = $this->input->get('kelas_id', TRUE);
        }

        $bulan        = (int)$this->input->get('bulan', TRUE) ?: (int)date('m');
        $tahun        = (int)$this->input->get('tahun', TRUE) ?: (int)date('Y');
        $pertemuan_ke = (int)$this->input->get('pertemuan_ke', TRUE) ?: 1;

        $data['title']            = 'Input Nilai Pertemuan - RBQ Al Fatih';
        $data['active_menu']      = 'nilai_pertemuan';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['kelas_id']         = $kelas_id;
        $data['bulan_pilih']      = $bulan;
        $data['tahun_pilih']      = $tahun;
        $data['pertemuan_pilih']  = $pertemuan_ke;
        $data['daftar_kelas']     = $this->Kelas_model->get_all($semester_id);

        if (!empty($kelas_id)) {
            $data['daftar_santri'] = $this->Santri_model->get_all(['kelas_id' => $kelas_id, 'status' => 'aktif']);
            // Nilai yang sudah ada
            $existing = $this->Raport_model->get_nilai_pertemuan_kelas($kelas_id, $semester_id, $bulan, $pertemuan_ke);
            $nilai_map = [];
            foreach ($existing as $ex) {
                $nilai_map[$ex->santri_id] = $ex->nilai;
            }
            $data['nilai_map'] = $nilai_map;
        } else {
            $data['daftar_santri'] = [];
            $data['nilai_map']     = [];
        }

        $this->load->view('layout/header', $data);
        $this->load->view('raport/nilai_pertemuan', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan batch nilai pertemuan santri
     *
     * @return void
     */
    public function simpan_nilai_pertemuan()
    {
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $kelas_id     = (int)$this->input->post('kelas_id', TRUE);
        $semester_id  = (int)$this->input->post('semester_id', TRUE);
        $bulan        = (int)$this->input->post('bulan', TRUE);
        $tahun        = (int)$this->input->post('tahun', TRUE);
        $pertemuan_ke = (int)$this->input->post('pertemuan_ke', TRUE);
        $nilai_array  = $this->input->post('nilai', TRUE); // [santri_id => nilai]
        $user_id      = $this->session->userdata('user_id');

        if (!empty($nilai_array) && is_array($nilai_array)) {
            foreach ($nilai_array as $santri_id => $nilai) {
                if ($nilai !== '' && $nilai !== null) {
                    $this->Raport_model->simpan_nilai_pertemuan([
                        'santri_id'    => (int)$santri_id,
                        'kelas_id'     => $kelas_id,
                        'semester_id'  => $semester_id,
                        'bulan'        => $bulan,
                        'tahun'        => $tahun,
                        'pertemuan_ke' => $pertemuan_ke,
                        'nilai'        => (float)$nilai,
                        'diinput_oleh' => $user_id
                    ]);
                }
            }
        }

        $this->session->set_flashdata('success', 'Nilai pertemuan berhasil disimpan.');
        redirect('raport/nilai_pertemuan?kelas_id=' . $kelas_id . '&bulan=' . $bulan . '&tahun=' . $tahun . '&pertemuan_ke=' . $pertemuan_ke);
    }

    /**
     * Halaman Ledger Nilai & Penilaian Raport Kelas Binaan Wali Kelas
     *
     * @return void
     */
    public function kelas_saya()
    {
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $role        = $this->session->userdata('role');
        $user_id     = $this->session->userdata('user_id');
        $sem_aktif   = $this->Semester_model->get_aktif();
        $semester_id = $sem_aktif ? $sem_aktif->id : 1;

        if ($role === 'wali_kelas') {
            $kelas = $this->db->get_where('kelas', [
                'wali_kelas_id' => $user_id,
                'semester_id'   => $semester_id
            ])->row();
            $kelas_id = $kelas ? $kelas->id : null;
        } else {
            $kelas_id = $this->input->get('kelas_id', TRUE);
            $kelas    = $this->Kelas_model->get_by_id($kelas_id);
        }

        $data['title']            = 'Raport & Kepribadian Kelas - RBQ Al Fatih';
        $data['active_menu']      = 'raport_kelas';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['kelas']            = $kelas;
        $data['daftar_kelas']     = $this->Kelas_model->get_all($semester_id);

        if (!empty($kelas_id)) {
            // Generate ledger & ranking
            $data['ledger'] = $this->Raport_model->generate_ledger_kelas($kelas_id, $semester_id);

            // Ambil data raport yang sudah tersimpan
            $raport_rows = $this->db->get_where('raport', [
                'kelas_id'    => $kelas_id,
                'semester_id' => $semester_id
            ])->result();

            $raport_map = [];
            foreach ($raport_rows as $r) {
                $raport_map[$r->santri_id] = $r;
            }
            $data['raport_map'] = $raport_map;
        } else {
            $data['ledger']     = [];
            $data['raport_map'] = [];
        }

        $this->load->view('layout/header', $data);
        $this->load->view('raport/kelas_saya', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan data evaluasi kepribadian & absensi raport santri
     *
     * @return void
     */
    public function simpan_raport_santri()
    {
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $santri_id    = (int)$this->input->post('santri_id', TRUE);
        $kelas_id     = (int)$this->input->post('kelas_id', TRUE);
        $semester_id  = (int)$this->input->post('semester_id', TRUE);

        $data = [
            'santri_id'               => $santri_id,
            'kelas_id'                => $kelas_id,
            'semester_id'             => $semester_id,
            'nilai_tertib'            => $this->input->post('nilai_tertib', TRUE) ?: 'A',
            'nilai_disiplin'          => $this->input->post('nilai_disiplin', TRUE) ?: 'A',
            'nilai_motivasi_belajar'  => $this->input->post('nilai_motivasi_belajar', TRUE) ?: 'A',
            'jumlah_sakit'            => (int)$this->input->post('jumlah_sakit', TRUE),
            'jumlah_izin'             => (int)$this->input->post('jumlah_izin', TRUE),
            'jumlah_tanpa_keterangan' => (int)$this->input->post('jumlah_tanpa_keterangan', TRUE),
            'nilai_rata_rata'         => (float)$this->input->post('nilai_rata_rata', TRUE),
            'peringkat'               => $this->input->post('peringkat', TRUE) ? (int)$this->input->post('peringkat', TRUE) : null,
            'catatan_wali_kelas'      => $this->input->post('catatan_wali_kelas', TRUE),
            'status'                  => 'final'
        ];

        $this->Raport_model->simpan_raport($data);
        $this->session->set_flashdata('success', 'Evaluasi raport santri berhasil disimpan.');
        redirect('raport/kelas_saya?kelas_id=' . $kelas_id);
    }

    /**
     * Menampilkan halaman cetak raport santri (print-friendly)
     *
     * @param  int $santri_id   ID santri
     * @param  int $kelas_id    ID kelas
     * @param  int $semester_id ID semester
     * @return void
     */
    public function cetak($santri_id, $kelas_id, $semester_id)
    {
        $raport = $this->Raport_model->get_raport_detail($santri_id, $kelas_id, $semester_id);

        if (!$raport) {
            $this->session->set_flashdata('error', 'Raport belum diisi atau disimpan oleh Wali Kelas.');
            redirect('raport/kelas_saya');
            return;
        }

        $data['raport'] = $raport;
        $this->load->view('raport/cetak', $data);
    }
}
