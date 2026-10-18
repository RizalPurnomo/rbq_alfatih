<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Kas_model
 *
 * Mengelola transaksi kas dan keuangan di RBQ Al Fatih:
 * - Pembayaran bulanan santri (SPP tetap, Infaq bebas, Tabungan santri)
 * - Penyetoran dana dari Wali Kelas ke Kas Utama
 * - Konfirmasi penerimaan setoran oleh Bagian Keuangan
 * - Pengeluaran kas utama (Bisyaroh Guru dari SPP, operasional/buku/pokja dari Infaq)
 * - Pencatatan penerimaan donasi umum
 * - Rekapitulasi laporan keuangan & saldo kas utama
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Keuangan
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Kas_model extends CI_Model
{
    /**
     * Mengambil nominal SPP aktif saat ini
     *
     * @return float Nominal SPP per bulan
     */
    public function get_nominal_spp_aktif()
    {
        $row = $this->db->get_where('nominal_spp', ['is_aktif' => 1])->row();
        return $row ? (float)$row->nominal : 100000.00;
    }

    /**
     * Memperbarui setting nominal SPP
     *
     * @param  float  $nominal Nominal baru
     * @param  string $tanggal Tanggal mulai berlaku
     * @return int             Insert ID
     */
    public function update_nominal_spp($nominal, $tanggal)
    {
        $this->db->update('nominal_spp', ['is_aktif' => 0]);
        $this->db->insert('nominal_spp', [
            'nominal'       => $nominal,
            'berlaku_mulai' => $tanggal,
            'is_aktif'      => 1
        ]);
        return $this->db->insert_id();
    }

    /**
     * Menyimpan data pembayaran santri bulanan
     *
     * Jika ada nominal tabungan > 0, otomatis mencatat mutasi masuk ke tabel `transaksi_tabungan`.
     *
     * @param  array $data Data pembayaran santri
     * @return int         ID pembayaran santri
     */
    public function simpan_pembayaran($data)
    {
        // 1. Simpan pembayaran
        $this->db->insert('pembayaran_santri', $data);
        $pembayaran_id = $this->db->insert_id();

        // 2. Jika ada tabungan santri, otomatis catat ke modul tabungan
        if (!empty($data['nominal_tabungan']) && (float)$data['nominal_tabungan'] > 0) {
            $this->load->model('Tabungan_model');
            $this->Tabungan_model->catat_masuk(
                $data['santri_id'],
                (float)$data['nominal_tabungan'],
                $data['tanggal_bayar'],
                'Setoran Tabungan dari Pembayaran SPP Bulan ' . $data['bulan'] . '/' . $data['tahun'],
                $pembayaran_id,
                $data['dicatat_oleh']
            );
        }

        return $pembayaran_id;
    }

    /**
     * Mengambil daftar pembayaran santri berdasarkan kelas, bulan, dan tahun
     *
     * @param  int $kelas_id ID kelas
     * @param  int $bulan    Bulan (1-12)
     * @param  int $tahun    Tahun
     * @return array
     */
    public function get_pembayaran_by_kelas($kelas_id, $bulan, $tahun)
    {
        $this->db->select('ps.*, s.nama_lengkap as nama_santri, u.nama as nama_pencatat');
        $this->db->from('pembayaran_santri ps');
        $this->db->join('santri s', 's.id = ps.santri_id', 'inner');
        $this->db->join('users u', 'u.id = ps.dicatat_oleh', 'left');
        $this->db->where('ps.kelas_id', $kelas_id);
        $this->db->where('ps.bulan', $bulan);
        $this->db->where('ps.tahun', $tahun);
        $this->db->order_by('ps.tanggal_bayar', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Menghitung total kas kelas yang belum disetorkan ke kas utama
     *
     * @param  int $kelas_id ID kelas
     * @param  int $bulan    Bulan
     * @param  int $tahun    Tahun
     * @return array ['total_spp', 'total_infaq', 'total_tabungan', 'total_kas']
     */
    public function get_akumulasi_belum_setor($kelas_id, $bulan, $tahun)
    {
        $this->db->select_sum('nominal_spp', 'total_spp');
        $this->db->select_sum('nominal_infaq', 'total_infaq');
        $this->db->select_sum('nominal_tabungan', 'total_tabungan');
        $this->db->where('kelas_id', $kelas_id);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $this->db->where('status_setor', 'belum_setor');
        $row = $this->db->get('pembayaran_santri')->row();

        $spp      = (float)($row->total_spp ?? 0);
        $infaq    = (float)($row->total_infaq ?? 0);
        $tabungan = (float)($row->total_tabungan ?? 0);

        return [
            'total_spp'      => $spp,
            'total_infaq'    => $infaq,
            'total_tabungan' => $tabungan,
            'total_kas'      => $spp + $infaq + $tabungan
        ];
    }

    /**
     * Mengajukan setoran kas kelas ke kas utama oleh wali kelas
     *
     * @param  array $data Data setoran
     * @return int         ID setoran
     */
    public function simpan_setoran($data)
    {
        $this->db->insert('setoran_kas_utama', $data);
        $setoran_id = $this->db->insert_id();

        // Tandai pembayaran santri di kelas dan bulan tersebut menjadi sudah disetor
        $this->db->where('kelas_id', $data['kelas_id'])
            ->where('bulan', $data['bulan'])
            ->where('tahun', $data['tahun'])
            ->where('status_setor', 'belum_setor')
            ->update('pembayaran_santri', ['status_setor' => 'sudah_setor']);

        return $setoran_id;
    }

    /**
     * Mengambil daftar setoran ke kas utama
     *
     * @param  string|null $status   Filter status ('pending', 'diterima')
     * @param  int|null    $kelas_id Filter kelas
     * @return array
     */
    public function get_setoran_list($status = null, $kelas_id = null)
    {
        $this->db->select('sku.*, k.nama as nama_kelas, u_disetor.nama as nama_penyetor, u_diterima.nama as nama_penerima');
        $this->db->from('setoran_kas_utama sku');
        $this->db->join('kelas k', 'k.id = sku.kelas_id', 'inner');
        $this->db->join('users u_disetor', 'u_disetor.id = sku.disetor_oleh', 'inner');
        $this->db->join('users u_diterima', 'u_diterima.id = sku.diterima_oleh', 'left');

        if (!empty($status)) {
            $this->db->where('sku.status', $status);
        }

        if (!empty($kelas_id)) {
            $this->db->where('sku.kelas_id', $kelas_id);
        }

        $this->db->order_by('sku.tanggal_setor', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Konfirmasi penerimaan setoran kas kelas oleh petugas keuangan
     *
     * @param  int $setoran_id           ID setoran
     * @param  int $petugas_keuangan_id  ID user keuangan
     * @return bool
     */
    public function konfirmasi_setoran($setoran_id, $petugas_keuangan_id)
    {
        return $this->db->where('id', $setoran_id)->update('setoran_kas_utama', [
            'status'        => 'diterima',
            'diterima_oleh' => $petugas_keuangan_id
        ]);
    }

    /**
     * Menyimpan pengeluaran kas utama oleh bagian keuangan
     *
     * @param  array $data Data pengeluaran
     * @return int         ID pengeluaran
     */
    public function simpan_pengeluaran($data)
    {
        $this->db->insert('pengeluaran', $data);
        return $this->db->insert_id();
    }

    /**
     * Mengambil daftar pengeluaran kas utama
     *
     * @param  string|null $kategori_sumber Filter ('spp', 'infaq')
     * @param  int|null    $bulan           Filter bulan
     * @param  int|null    $tahun           Filter tahun
     * @return array
     */
    public function get_pengeluaran_list($kategori_sumber = null, $bulan = null, $tahun = null)
    {
        $this->db->select('p.*, u.nama as nama_pencatat');
        $this->db->from('pengeluaran p');
        $this->db->join('users u', 'u.id = p.dicatat_oleh', 'inner');

        if (!empty($kategori_sumber)) {
            $this->db->where('p.kategori_sumber', $kategori_sumber);
        }

        if (!empty($bulan)) {
            $this->db->where('MONTH(p.tanggal)', $bulan);
        }

        if (!empty($tahun)) {
            $this->db->where('YEAR(p.tanggal)', $tahun);
        }

        $this->db->order_by('p.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Menyimpan penerimaan donasi umum
     *
     * @param  array $data Data donasi
     * @return int         ID donasi
     */
    public function simpan_donasi($data)
    {
        $this->db->insert('donasi', $data);
        return $this->db->insert_id();
    }

    /**
     * Mengambil daftar donasi dari para donatur
     *
     * @param  int|null $bulan Filter bulan
     * @param  int|null $tahun Filter tahun
     * @return array
     */
    public function get_donasi_list($bulan = null, $tahun = null)
    {
        $this->db->select('d.*, u.nama as nama_pencatat');
        $this->db->from('donasi d');
        $this->db->join('users u', 'u.id = d.dicatat_oleh', 'inner');

        if (!empty($bulan)) {
            $this->db->where('MONTH(d.tanggal)', $bulan);
        }

        if (!empty($tahun)) {
            $this->db->where('YEAR(d.tanggal)', $tahun);
        }

        $this->db->order_by('d.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Menghitung posisi saldo kas utama (Kas SPP dan Kas Infaq & Donatur)
     *
     * @return array Saldo SPP, saldo Infaq, dan total saldo kas utama
     */
    public function get_saldo_kas_utama()
    {
        // 1. Pemasukan SPP dari setoran yang telah dikonfirmasi diterima
        $spp_masuk = $this->db->select_sum('total_spp')->where('status', 'diterima')->get('setoran_kas_utama')->row()->total_spp ?? 0;

        // 2. Pengeluaran dari sumber SPP (misal: Bisyaroh Guru)
        $pengeluaran_spp = $this->db->select_sum('nominal')->where('kategori_sumber', 'spp')->get('pengeluaran')->row()->nominal ?? 0;
        $saldo_spp = (float)$spp_masuk - (float)$pengeluaran_spp;

        // 3. Pemasukan Infaq (dari setoran santri + donatur luar)
        $infaq_santri = $this->db->select_sum('total_infaq')->where('status', 'diterima')->get('setoran_kas_utama')->row()->total_infaq ?? 0;
        $infaq_donasi = $this->db->select_sum('nominal')->get('donasi')->row()->nominal ?? 0;
        $total_infaq_masuk = (float)$infaq_santri + (float)$infaq_donasi;

        // 4. Pengeluaran dari sumber Infaq (misal: Kas Pokja, Beli Buku, Operasional)
        $pengeluaran_infaq = $this->db->select_sum('nominal')->where('kategori_sumber', 'infaq')->get('pengeluaran')->row()->nominal ?? 0;
        $saldo_infaq = $total_infaq_masuk - (float)$pengeluaran_infaq;

        return [
            'total_spp_masuk'       => (float)$spp_masuk,
            'total_pengeluaran_spp' => (float)$pengeluaran_spp,
            'saldo_spp'             => $saldo_spp,
            'infaq_santri'          => (float)$infaq_santri,
            'infaq_donasi'          => (float)$infaq_donasi,
            'total_infaq_masuk'     => $total_infaq_masuk,
            'total_pengeluaran_infaq'=> (float)$pengeluaran_infaq,
            'saldo_infaq'           => $saldo_infaq,
            'total_saldo_utama'     => $saldo_spp + $saldo_infaq
        ];
    }
}
