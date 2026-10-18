<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Kas
 *
 * Mengelola seluruh transaksi keuangan dan kas di RBQ Al Fatih:
 * - Pembayaran santri bulanan (SPP tetap, Infaq bebas, Tabungan santri) oleh Wali Kelas
 * - Penyetoran dana kas kelas ke kas utama di akhir bulan
 * - Verifikasi penerimaan setoran oleh bagian Keuangan
 * - Pengeluaran kas utama (Bisyaroh guru dari kas SPP, operasional/buku/pokja dari kas Infaq) oleh Keuangan
 * - Penerimaan donasi umum dari donatur oleh Keuangan
 * - Laporan keuangan komprehensif kas utama
 *
 * Hak Akses: Admin, Keuangan, Wali Kelas (disesuaikan pada setiap method)
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Keuangan
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Kas extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();

        $this->load->model('Kas_model');
        $this->load->model('Santri_model');
        $this->load->model('Kelas_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
    }

    /**
     * Halaman Input Pembayaran SPP / Kas Kelas
     *
     * Diakses oleh Wali Kelas (untuk kelasnya) atau Admin.
     *
     * @return void
     */
    public function pembayaran()
    {
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $role    = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');

        $sem_aktif   = $this->Semester_model->get_aktif();
        $semester_id = $sem_aktif ? $sem_aktif->id : null;

        $bulan = (int)$this->input->get('bulan', TRUE) ?: (int)date('m');
        $tahun = (int)$this->input->get('tahun', TRUE) ?: (int)date('Y');

        // Tentukan kelas yang dikelola
        if ($role === 'wali_kelas') {
            $kelas = $this->db->get_where('kelas', [
                'wali_kelas_id' => $user_id,
                'semester_id'   => $semester_id
            ])->row();
            $kelas_id = $kelas ? $kelas->id : null;
        } else {
            $kelas_id = $this->input->get('kelas_id', TRUE);
        }

        $data['title']            = 'Input Pembayaran Santri - RBQ Al Fatih';
        $data['active_menu']      = 'pembayaran';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['nominal_spp']      = $this->Kas_model->get_nominal_spp_aktif();
        $data['bulan_pilih']      = $bulan;
        $data['tahun_pilih']      = $tahun;
        $data['kelas_id']         = $kelas_id;
        $data['daftar_kelas']     = $this->Kelas_model->get_all($semester_id);

        if (!empty($kelas_id)) {
            $data['daftar_santri']     = $this->Santri_model->get_all(['kelas_id' => $kelas_id, 'status' => 'aktif']);
            $data['riwayat_bayar']     = $this->Kas_model->get_pembayaran_by_kelas($kelas_id, $bulan, $tahun);
            $data['rekap_belum_setor'] = $this->Kas_model->get_akumulasi_belum_setor($kelas_id, $bulan, $tahun);
        } else {
            $data['daftar_santri']     = [];
            $data['riwayat_bayar']     = [];
            $data['rekap_belum_setor'] = ['total_spp' => 0, 'total_infaq' => 0, 'total_tabungan' => 0, 'total_kas' => 0];
        }

        $this->load->view('layout/header', $data);
        $this->load->view('kas/pembayaran', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan transaksi pembayaran santri
     *
     * @return void
     */
    public function simpan_pembayaran()
    {
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $santri_id        = (int)$this->input->post('santri_id', TRUE);
        $kelas_id         = (int)$this->input->post('kelas_id', TRUE);
        $bulan            = (int)$this->input->post('bulan', TRUE);
        $tahun            = (int)$this->input->post('tahun', TRUE);
        $nominal_spp      = (float)$this->input->post('nominal_spp', TRUE);
        $nominal_infaq    = (float)$this->input->post('nominal_infaq', TRUE) ?: 0;
        $nominal_tabungan = (float)$this->input->post('nominal_tabungan', TRUE) ?: 0;
        $tanggal_bayar    = $this->input->post('tanggal_bayar', TRUE) ?: date('Y-m-d');

        // Cek duplikasi pembayaran di bulan/tahun yang sama
        $cek = $this->db->get_where('pembayaran_santri', [
            'santri_id' => $santri_id,
            'bulan'     => $bulan,
            'tahun'     => $tahun
        ])->row();

        if ($cek) {
            $this->session->set_flashdata('error', 'Santri tersebut sudah melakukan pembayaran untuk bulan ' . $bulan . '/' . $tahun . '.');
            redirect('kas/pembayaran?kelas_id=' . $kelas_id . '&bulan=' . $bulan . '&tahun=' . $tahun);
            return;
        }

        $data = [
            'santri_id'        => $santri_id,
            'kelas_id'         => $kelas_id,
            'bulan'            => $bulan,
            'tahun'            => $tahun,
            'nominal_spp'      => $nominal_spp,
            'nominal_infaq'    => $nominal_infaq,
            'nominal_tabungan' => $nominal_tabungan,
            'tanggal_bayar'    => $tanggal_bayar,
            'dicatat_oleh'     => $this->session->userdata('user_id'),
            'status_setor'     => 'belum_setor'
        ];

        $this->Kas_model->simpan_pembayaran($data);

        $this->session->set_flashdata('success', 'Pembayaran berhasil dicatat. Tabungan santri telah otomatis diperbarui.');
        redirect('kas/pembayaran?kelas_id=' . $kelas_id . '&bulan=' . $bulan . '&tahun=' . $tahun);
    }

    /**
     * Halaman Pengajuan Setoran Wali Kelas ke Kas Utama
     *
     * @return void
     */
    public function setor()
    {
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $user_id   = $this->session->userdata('user_id');
        $sem_aktif = $this->Semester_model->get_aktif();
        $sem_id    = $sem_aktif ? $sem_aktif->id : null;

        // Ambil kelas wali kelas
        $kelas = $this->db->get_where('kelas', [
            'wali_kelas_id' => $user_id,
            'semester_id'   => $sem_id
        ])->row();

        $bulan = (int)$this->input->get('bulan', TRUE) ?: (int)date('m');
        $tahun = (int)$this->input->get('tahun', TRUE) ?: (int)date('Y');

        $data['title']            = 'Setor Kas ke Kas Utama - RBQ Al Fatih';
        $data['active_menu']      = 'setor_kas';
        $data['current_semester'] = $sem_aktif;
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['kelas']            = $kelas;
        $data['bulan']            = $bulan;
        $data['tahun']            = $tahun;

        if ($kelas) {
            $data['rekap']         = $this->Kas_model->get_akumulasi_belum_setor($kelas->id, $bulan, $tahun);
            $data['riwayat_setor'] = $this->Kas_model->get_setoran_list(null, $kelas->id);
        } else {
            $data['rekap']         = ['total_spp' => 0, 'total_infaq' => 0, 'total_tabungan' => 0, 'total_kas' => 0];
            $data['riwayat_setor'] = [];
        }

        $this->load->view('layout/header', $data);
        $this->load->view('kas/setor', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan setoran kas kelas ke kas utama
     *
     * @return void
     */
    public function simpan_setor()
    {
        $this->auth_lib->check_role(['wali_kelas', 'admin']);

        $kelas_id       = (int)$this->input->post('kelas_id', TRUE);
        $bulan          = (int)$this->input->post('bulan', TRUE);
        $tahun          = (int)$this->input->post('tahun', TRUE);
        $total_spp      = (float)$this->input->post('total_spp', TRUE);
        $total_infaq    = (float)$this->input->post('total_infaq', TRUE);
        $total_tabungan = (float)$this->input->post('total_tabungan', TRUE);

        if (($total_spp + $total_infaq + $total_tabungan) <= 0) {
            $this->session->set_flashdata('error', 'Tidak ada dana kas yang dapat disetorkan untuk periode tersebut.');
            redirect('kas/setor');
            return;
        }

        $data = [
            'kelas_id'       => $kelas_id,
            'bulan'          => $bulan,
            'tahun'          => $tahun,
            'total_spp'      => $total_spp,
            'total_infaq'    => $total_infaq,
            'total_tabungan' => $total_tabungan,
            'tanggal_setor'  => date('Y-m-d'),
            'disetor_oleh'   => $this->session->userdata('user_id'),
            'status'         => 'pending'
        ];

        $this->Kas_model->simpan_setoran($data);
        $this->session->set_flashdata('success', 'Setoran kas berhasil diajukan dan sedang menunggu verifikasi Bagian Keuangan.');
        redirect('kas/setor');
    }

    /**
     * Halaman Verifikasi Setoran Masuk untuk Bagian Keuangan
     *
     * @return void
     */
    public function setoran_masuk()
    {
        $this->auth_lib->check_role(['keuangan', 'admin']);

        $data['title']            = 'Verifikasi Setoran Kas Kelas - RBQ Al Fatih';
        $data['active_menu']      = 'setoran_masuk';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_setoran']   = $this->Kas_model->get_setoran_list();

        $this->load->view('layout/header', $data);
        $this->load->view('kas/setoran_masuk', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Konfirmasi penerimaan setoran oleh bagian keuangan
     *
     * @param  int $setoran_id ID setoran
     * @return void
     */
    public function konfirmasi_setor($setoran_id)
    {
        $this->auth_lib->check_role(['keuangan', 'admin']);

        $user_id = $this->session->userdata('user_id');
        $this->Kas_model->konfirmasi_setoran($setoran_id, $user_id);

        $this->session->set_flashdata('success', 'Setoran telah dikonfirmasi dan masuk ke Kas Utama.');
        redirect('kas/setoran_masuk');
    }

    /**
     * Halaman Pencatatan Pengeluaran Kas Utama
     *
     * Diakses oleh Bagian Keuangan.
     *
     * @return void
     */
    public function pengeluaran()
    {
        $this->auth_lib->check_role(['keuangan', 'admin']);

        $bulan    = (int)$this->input->get('bulan', TRUE) ?: (int)date('m');
        $tahun    = (int)$this->input->get('tahun', TRUE) ?: (int)date('Y');
        $kategori = $this->input->get('kategori', TRUE);

        $data['title']            = 'Pengeluaran Kas Utama - RBQ Al Fatih';
        $data['active_menu']      = 'pengeluaran';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_pengeluaran']= $this->Kas_model->get_pengeluaran_list($kategori, $bulan, $tahun);
        $data['saldo_kas']        = $this->Kas_model->get_saldo_kas_utama();
        $data['bulan_pilih']      = $bulan;
        $data['tahun_pilih']      = $tahun;
        $data['kategori_pilih']   = $kategori;

        $this->load->view('layout/header', $data);
        $this->load->view('kas/pengeluaran', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan pengeluaran kas utama
     *
     * @return void
     */
    public function simpan_pengeluaran()
    {
        $this->auth_lib->check_role('keuangan');

        $kategori_sumber   = $this->input->post('kategori_sumber', TRUE);
        $jenis_pengeluaran = $this->input->post('jenis_pengeluaran', TRUE);
        $nominal           = (float)$this->input->post('nominal', TRUE);
        $tanggal           = $this->input->post('tanggal', TRUE) ?: date('Y-m-d');
        $keterangan        = $this->input->post('keterangan', TRUE);

        $saldo = $this->Kas_model->get_saldo_kas_utama();
        if ($kategori_sumber === 'spp' && $nominal > $saldo['saldo_spp']) {
            $this->session->set_flashdata('error', 'Saldo Kas SPP tidak mencukupi (Saldo: Rp ' . number_format($saldo['saldo_spp'], 0, ',', '.') . ').');
            redirect('kas/pengeluaran');
            return;
        }

        if ($kategori_sumber === 'infaq' && $nominal > $saldo['saldo_infaq']) {
            $this->session->set_flashdata('error', 'Saldo Kas Infaq tidak mencukupi (Saldo: Rp ' . number_format($saldo['saldo_infaq'], 0, ',', '.') . ').');
            redirect('kas/pengeluaran');
            return;
        }

        $data = [
            'kategori_sumber'   => $kategori_sumber,
            'jenis_pengeluaran' => $jenis_pengeluaran,
            'nominal'           => $nominal,
            'tanggal'           => $tanggal,
            'keterangan'        => $keterangan,
            'dicatat_oleh'      => $this->session->userdata('user_id')
        ];

        $this->Kas_model->simpan_pengeluaran($data);
        $this->session->set_flashdata('success', 'Pengeluaran kas berhasil dicatat.');
        redirect('kas/pengeluaran');
    }

    /**
     * Halaman Pencatatan Donasi dari Donatur
     *
     * @return void
     */
    public function donasi()
    {
        $this->auth_lib->check_role(['keuangan', 'admin']);

        $data['title']            = 'Penerimaan Donasi - RBQ Al Fatih';
        $data['active_menu']      = 'donasi';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['daftar_donasi']    = $this->Kas_model->get_donasi_list();

        $this->load->view('layout/header', $data);
        $this->load->view('kas/donasi', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan penerimaan donasi
     *
     * @return void
     */
    public function simpan_donasi()
    {
        $this->auth_lib->check_role('keuangan');

        $data = [
            'nama_donatur' => $this->input->post('nama_donatur', TRUE),
            'nominal'      => (float)$this->input->post('nominal', TRUE),
            'tanggal'      => $this->input->post('tanggal', TRUE) ?: date('Y-m-d'),
            'keterangan'   => $this->input->post('keterangan', TRUE),
            'dicatat_oleh' => $this->session->userdata('user_id')
        ];

        $this->Kas_model->simpan_donasi($data);
        $this->session->set_flashdata('success', 'Donasi berhasil dicatat dan masuk ke Kas Infaq Utama.');
        redirect('kas/donasi');
    }

    /**
     * Halaman Laporan Keuangan Kas Utama
     *
     * @return void
     */
    public function laporan()
    {
        $this->auth_lib->check_role(['admin', 'keuangan']);

        $data['title']            = 'Laporan Kas Utama - RBQ Al Fatih';
        $data['active_menu']      = 'laporan_kas';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['saldo_kas']        = $this->Kas_model->get_saldo_kas_utama();
        $data['riwayat_setoran']  = $this->Kas_model->get_setoran_list('diterima');
        $data['riwayat_keluar']   = $this->Kas_model->get_pengeluaran_list();
        $data['riwayat_donasi']   = $this->Kas_model->get_donasi_list();

        $this->load->view('layout/header', $data);
        $this->load->view('kas/laporan', $data);
        $this->load->view('layout/footer', $data);
    }
}
