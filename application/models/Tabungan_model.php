<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Tabungan_model
 *
 * Mengelola tabungan santri pada tabel `transaksi_tabungan`:
 * - Pencatatan tabungan masuk otomatis dari pembayaran bulanan
 * - Penarikan/pengambilan tabungan santri
 * - Perhitungan saldo akhir santri
 * - Rekapitulasi tabungan seluruh santri
 *
 * @package    RBQ Al Fatih
 * @subpackage Models
 * @category   Tabungan
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Tabungan_model extends CI_Model
{
    /**
     * Nama tabel transaksi tabungan
     * @var string
     */
    protected $table = 'transaksi_tabungan';

    /**
     * Menghitung sisa saldo tabungan santri saat ini
     *
     * @param  int $santri_id ID santri
     * @return float          Saldo tabungan
     */
    public function get_saldo_santri($santri_id)
    {
        $masuk = $this->db->select_sum('nominal')
            ->where('santri_id', $santri_id)
            ->where('tipe', 'masuk')
            ->get($this->table)->row()->nominal ?? 0;

        $keluar = $this->db->select_sum('nominal')
            ->where('santri_id', $santri_id)
            ->where('tipe', 'keluar')
            ->get($this->table)->row()->nominal ?? 0;

        return (float)$masuk - (float)$keluar;
    }

    /**
     * Mencatat tabungan masuk
     *
     * @param  int         $santri_id    ID santri
     * @param  float       $nominal      Nominal tabungan
     * @param  string      $tanggal      Tanggal setoran
     * @param  string      $keterangan   Keterangan
     * @param  int|null    $pembayaran_id ID referensi pembayaran
     * @param  int         $dicatat_oleh ID user pencatat
     * @return int                       Insert ID
     */
    public function catat_masuk($santri_id, $nominal, $tanggal, $keterangan, $pembayaran_id = null, $dicatat_oleh = null)
    {
        $saldo_sebelum = $this->get_saldo_santri($santri_id);
        $saldo_setelah = $saldo_sebelum + (float)$nominal;

        $data = [
            'santri_id'               => $santri_id,
            'tipe'                    => 'masuk',
            'nominal'                 => $nominal,
            'saldo_setelah'           => $saldo_setelah,
            'tanggal'                 => $tanggal,
            'keterangan'              => $keterangan,
            'referensi_pembayaran_id' => $pembayaran_id,
            'dicatat_oleh'            => $dicatat_oleh ?: 1
        ];

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Mencatat penarikan/pengambilan tabungan oleh santri
     *
     * @param  int    $santri_id    ID santri
     * @param  float  $nominal      Nominal penarikan
     * @param  string $tanggal      Tanggal penarikan
     * @param  string $keterangan   Keterangan penarikan
     * @param  int    $dicatat_oleh ID user pencatat
     * @return array                ['status' => bool, 'message' => string]
     */
    public function catat_penarikan($santri_id, $nominal, $tanggal, $keterangan, $dicatat_oleh)
    {
        $saldo_saat_ini = $this->get_saldo_santri($santri_id);

        if ((float)$nominal > $saldo_saat_ini) {
            return [
                'status'  => false,
                'message' => 'Saldo tabungan tidak mencukupi. Saldo saat ini: Rp ' . number_format($saldo_saat_ini, 0, ',', '.')
            ];
        }

        $saldo_setelah = $saldo_saat_ini - (float)$nominal;

        $data = [
            'santri_id'     => $santri_id,
            'tipe'          => 'keluar',
            'nominal'       => $nominal,
            'saldo_setelah' => $saldo_setelah,
            'tanggal'       => $tanggal,
            'keterangan'    => $keterangan,
            'dicatat_oleh'  => $dicatat_oleh
        ];

        $this->db->insert($this->table, $data);

        return [
            'status'  => true,
            'message' => 'Penarikan tabungan berhasil dicatat.'
        ];
    }

    /**
     * Mengambil riwayat mutasi tabungan seorang santri
     *
     * @param  int $santri_id ID santri
     * @return array
     */
    public function get_riwayat_santri($santri_id)
    {
        $this->db->select('tt.*, u.nama as nama_pencatat');
        $this->db->from($this->table . ' tt');
        $this->db->join('users u', 'u.id = tt.dicatat_oleh', 'left');
        $this->db->where('tt.santri_id', $santri_id);
        $this->db->order_by('tt.tanggal', 'DESC');
        $this->db->order_by('tt.id', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mengambil rekap saldo tabungan seluruh santri aktif
     *
     * @return array Daftar santri beserta total tabungan masuk, keluar, dan saldo akhir
     */
    public function get_rekap_tabungan_santri()
    {
        $santri_list = $this->db->select('s.id, s.nama_lengkap, s.status, k.nama as nama_kelas, klp.nama as nama_kelompok')
            ->from('santri s')
            ->join('kelas_santri ks', 'ks.santri_id = s.id AND ks.tanggal_keluar_kelas IS NULL', 'left')
            ->join('kelas k', 'k.id = ks.kelas_id', 'left')
            ->join('kelompok klp', 'klp.id = k.kelompok_id', 'left')
            ->where('s.status', 'aktif')
            ->order_by('s.nama_lengkap', 'ASC')
            ->get()->result();

        $result = [];
        foreach ($santri_list as $s) {
            $saldo = $this->get_saldo_santri($s->id);
            $result[] = (object)[
                'santri_id'     => $s->id,
                'nama_santri'   => $s->nama_lengkap,
                'nama_kelas'    => $s->nama_kelas,
                'nama_kelompok' => $s->nama_kelompok,
                'saldo'         => $saldo
            ];
        }

        return $result;
    }
}
