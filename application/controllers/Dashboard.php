<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard
 *
 * Menampilkan ringkasan data operasional sesuai dengan hak akses (Role):
 * - Admin: Ringkasan seluruh data santri, kas utama, kelas, dan event
 * - Keuangan: Monitoring saldo kas, rincian pengeluaran, donasi, dan setoran kas pending
 * - Wali Kelas: Monitoring santri kelas binaan, status pembayaran SPP, dan nilai pertemuan
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Dashboard
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Dashboard extends MY_Controller
{
    /**
     * Constructor
     *
     * Memastikan user terautentikasi sebelum dapat mengakses dashboard
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();

        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
        $this->load->model('Berita_model');
    }

    /**
     * Halaman Utama Dashboard
     *
     * Menghimpun widget statistik sesuai peran pengguna yang sedang login.
     *
     * @return void
     */
    public function index()
    {
        $role    = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');

        $data['title']            = 'Dashboard - RBQ Al Fatih';
        $data['active_menu']      = 'dashboard';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        $data['berita_terbaru']   = $this->Berita_model->get_published(3);

        // Data statistik berdasarkan role
        if ($role === 'admin') {
            $data['stats'] = $this->_get_admin_stats();
        } elseif ($role === 'keuangan') {
            $data['stats'] = $this->_get_keuangan_stats();
        } elseif ($role === 'wali_kelas') {
            $data['stats'] = $this->_get_wali_kelas_stats($user_id);
        }

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menghitung statistik untuk Dashboard Administrator
     *
     * @return array
     */
    private function _get_admin_stats()
    {
        // Total santri aktif
        $total_santri = $this->db->where('status', 'aktif')->count_all_results('santri');

        // Total kelas semester aktif
        $total_kelas  = $this->db->count_all('kelas');

        // Total saldo SPP & Infaq di kas utama
        $spp_masuk   = $this->db->select_sum('total_spp')->where('status', 'diterima')->get('setoran_kas_utama')->row()->total_spp ?? 0;
        $infaq_masuk = $this->db->select_sum('total_infaq')->where('status', 'diterima')->get('setoran_kas_utama')->row()->total_infaq ?? 0;
        $donasi      = $this->db->select_sum('nominal')->get('donasi')->row()->nominal ?? 0;
        $infaq_total = $infaq_masuk + $donasi;

        $pengeluaran_spp   = $this->db->select_sum('nominal')->where('kategori_sumber', 'spp')->get('pengeluaran')->row()->nominal ?? 0;
        $pengeluaran_infaq = $this->db->select_sum('nominal')->where('kategori_sumber', 'infaq')->get('pengeluaran')->row()->nominal ?? 0;

        $saldo_spp   = $spp_masuk - $pengeluaran_spp;
        $saldo_infaq = $infaq_total - $pengeluaran_infaq;

        // Total tabungan santri
        $tabungan_masuk  = $this->db->select_sum('nominal')->where('tipe', 'masuk')->get('transaksi_tabungan')->row()->nominal ?? 0;
        $tabungan_keluar = $this->db->select_sum('nominal')->where('tipe', 'keluar')->get('transaksi_tabungan')->row()->nominal ?? 0;
        $saldo_tabungan  = $tabungan_masuk - $tabungan_keluar;

        // Total tenaga pengajar aktif
        $total_pengajar  = $this->db->where('is_active', 1)->count_all_results('pengajar');

        return [
            'total_santri'   => (int)$total_santri,
            'total_kelas'    => (int)$total_kelas,
            'total_pengajar' => (int)$total_pengajar,
            'saldo_spp'      => (float)$saldo_spp,
            'saldo_infaq'    => (float)$saldo_infaq,
            'saldo_tabungan' => (float)$saldo_tabungan
        ];
    }

    /**
     * Menghitung statistik untuk Dashboard Bagian Keuangan
     *
     * @return array
     */
    private function _get_keuangan_stats()
    {
        $bulan_ini = (int)date('m');
        $tahun_ini = (int)date('Y');

        // Setoran pending dari wali kelas
        $setoran_pending = $this->db->where('status', 'pending')->count_all_results('setoran_kas_utama');

        // Pengeluaran bulan ini
        $pengeluaran_bulan_ini = $this->db->select_sum('nominal')
            ->where('MONTH(tanggal)', $bulan_ini)
            ->where('YEAR(tanggal)', $tahun_ini)
            ->get('pengeluaran')->row()->nominal ?? 0;

        // Donasi bulan ini
        $donasi_bulan_ini = $this->db->select_sum('nominal')
            ->where('MONTH(tanggal)', $bulan_ini)
            ->where('YEAR(tanggal)', $tahun_ini)
            ->get('donasi')->row()->nominal ?? 0;

        // Saldo total
        $admin_stats = $this->_get_admin_stats();

        return [
            'setoran_pending'       => (int)$setoran_pending,
            'pengeluaran_bulan_ini' => (float)$pengeluaran_bulan_ini,
            'donasi_bulan_ini'      => (float)$donasi_bulan_ini,
            'saldo_spp'             => $admin_stats['saldo_spp'],
            'saldo_infaq'           => $admin_stats['saldo_infaq']
        ];
    }

    /**
     * Menghitung statistik untuk Dashboard Wali Kelas
     *
     * @param  int $wali_kelas_id ID user wali kelas
     * @return array
     */
    private function _get_wali_kelas_stats($wali_kelas_id)
    {
        // Cari kelas binaan wali kelas di semester aktif
        $semester_aktif = $this->Semester_model->get_aktif();
        $sem_id = $semester_aktif ? $semester_aktif->id : 0;

        $kelas = $this->db->get_where('kelas', [
            'wali_kelas_id' => $wali_kelas_id,
            'semester_id'   => $sem_id
        ])->row();

        if (!$kelas) {
            return [
                'kelas'               => null,
                'total_santri_kelas'  => 0,
                'santri_lunas_spp'    => 0,
                'kas_kelas_bulan_ini' => 0
            ];
        }

        // Hitung total santri dalam kelas
        $total_santri = $this->db->where('kelas_id', $kelas->id)->count_all_results('kelas_santri');

        // Hitung santri bayar bulan ini
        $bulan_ini = (int)date('m');
        $tahun_ini = (int)date('Y');

        $pembayaran = $this->db->where('kelas_id', $kelas->id)
            ->where('bulan', $bulan_ini)
            ->where('tahun', $tahun_ini)
            ->get('pembayaran_santri')->result();

        $santri_lunas = count($pembayaran);
        $total_kas = 0;
        foreach ($pembayaran as $p) {
            $total_kas += ($p->nominal_spp + $p->nominal_infaq);
        }

        return [
            'kelas'               => $kelas,
            'total_santri_kelas'  => (int)$total_santri,
            'santri_lunas_spp'    => (int)$santri_lunas,
            'kas_kelas_bulan_ini' => (float)$total_kas
        ];
    }
}
