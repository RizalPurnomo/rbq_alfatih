<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Profil
 *
 * Mengelola tampilan dan konten website profil publik Rumah Belajar Quran (RBQ) Al Fatih.
 * Halaman-halaman publik dapat diakses tanpa memerlukan autentikasi/login:
 * - Beranda / Landing page
 * - Tentang Kami (Pengajaran Metode Ummi)
 * - Visi dan Misi
 * - Info Pendaftaran Santri Baru
 * - Event & Berita
 * - Kontak & Lokasi Google Maps
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Public Website
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.1
 */
class Profil extends MY_Controller
{
    /**
     * Constructor
     *
     * Memuat model dan helper yang diperlukan untuk halaman profil publik
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Berita_model');
        $this->load->model('Semester_model');
        $this->load->model('Pengajar_model');
    }

    /**
     * Halaman Beranda (Landing Page)
     *
     * Menampilkan hero section, pengenalan metode Ummi, statistik ringkas,
     * highlight asatidz pengajar, event & berita terbaru, serta ajakan pendaftaran (CTA).
     *
     * @return void
     */
    public function index()
    {
        $data['title']            = 'Rumah Belajar Quran (RBQ) Al Fatih - Generasi Qurani Berkarakter';
        $data['active_menu']      = 'home';
        $data['berita_terbaru']   = $this->Berita_model->get_published(3);
        $data['semester_aktif']   = $this->Semester_model->get_aktif();
        $data['pengajar_preview'] = $this->Pengajar_model->get_all(null, true);

        $this->load->view('public/layout/header', $data);
        $this->load->view('public/home', $data);
        $this->load->view('public/layout/footer', $data);
    }

    /**
     * Halaman Tentang Kami
     *
     * Menjelaskan profil RBQ Al Fatih dan metodologi pengajaran Metode Ummi
     * dengan tingkatan jenjang Pra Ummi hingga Jilid 6.
     *
     * @return void
     */
    public function tentang()
    {
        $data['title']       = 'Tentang Kami - RBQ Al Fatih & Metode Ummi';
        $data['active_menu'] = 'tentang';

        $this->load->view('public/layout/header', $data);
        $this->load->view('public/tentang', $data);
        $this->load->view('public/layout/footer', $data);
    }

    /**
     * Halaman Visi dan Misi
     *
     * Menampilkan visi jangka panjang serta misi strategis RBQ Al Fatih.
     *
     * @return void
     */
    public function visi_misi()
    {
        $data['title']       = 'Visi & Misi - RBQ Al Fatih';
        $data['active_menu'] = 'visi_misi';

        $this->load->view('public/layout/header', $data);
        $this->load->view('public/visi_misi', $data);
        $this->load->view('public/layout/footer', $data);
    }

    /**
     * Halaman Info Pendaftaran
     *
     * Menyediakan informasi pendaftaran santri baru, syarat registrasi,
     * alur penerimaan, dan kontak panitia pendaftaran.
     *
     * @return void
     */
    public function pendaftaran()
    {
        $data['title']          = 'Informasi Pendaftaran Santri Baru - RBQ Al Fatih';
        $data['active_menu']    = 'pendaftaran';
        $data['semester_aktif'] = $this->Semester_model->get_aktif();

        $this->load->view('public/layout/header', $data);
        $this->load->view('public/pendaftaran', $data);
        $this->load->view('public/layout/footer', $data);
    }

    /**
     * Halaman Event & Berita
     *
     * Menampilkan seluruh artikel kegiatan, pengumuman, dan artikel RBQ Al Fatih.
     *
     * @return void
     */
    public function berita()
    {
        $kategori = $this->input->get('kategori', TRUE);

        $data['title']         = 'Event & Berita - RBQ Al Fatih';
        $data['active_menu']   = 'berita';
        $data['kategori_aktif']= $kategori;
        $data['daftar_berita'] = $this->Berita_model->get_published(12, $kategori);

        $this->load->view('public/layout/header', $data);
        $this->load->view('public/berita', $data);
        $this->load->view('public/layout/footer', $data);
    }

    /**
     * Halaman Detail Berita / Event
     *
     * Menampilkan isi lengkap artikel berdasarkan slug.
     *
     * @param  string $slug Slug berita yang diakses
     * @return void
     */
    public function detail_berita($slug)
    {
        $berita = $this->Berita_model->get_by_slug($slug);

        if (!$berita) {
            show_404();
        }

        $data['title']          = $berita->judul . ' - RBQ Al Fatih';
        $data['active_menu']    = 'berita';
        $data['berita']         = $berita;
        $data['berita_terkait'] = $this->Berita_model->get_published(3);

        $this->load->view('public/layout/header', $data);
        $this->load->view('public/detail_berita', $data);
        $this->load->view('public/layout/footer', $data);
    }

    /**
     * Halaman Kontak & Lokasi
     *
     * Menampilkan informasi kontak resmi, alamat sekretariat,
     * dan peta Google Maps tersemat.
     *
     * @return void
     */
    public function kontak()
    {
        $data['title']       = 'Hubungi Kami & Lokasi - RBQ Al Fatih';
        $data['active_menu'] = 'kontak';
        $data['maps_url']    = 'https://maps.app.goo.gl/6aJ7jQ7tJwVJyrQF7';

        $this->load->view('public/layout/header', $data);
        $this->load->view('public/kontak', $data);
        $this->load->view('public/layout/footer', $data);
    }

    /**
     * Halaman Profil Tenaga Pengajar (Asatidz & Asatidzah)
     *
     * Menampilkan portofolio tenaga pendidik resmi RBQ Al Fatih:
     * - Foto profil dan identitas syar'i
     * - Sertifikasi Guru Al-Quran Metode Ummi & Sanad Tahfidz
     * - Riwayat almamater & pendidikan formal
     * - Pengalaman jam terbang mengajar
     * - Filter interaktif kategori Ikhwan & Akhwat
     *
     * @return void
     */
    public function pengajar()
    {
        $filter_jk = $this->input->get('filter', TRUE);
        if (!in_array(strtoupper((string)$filter_jk), ['L', 'P'])) {
            $filter_jk = null;
        }

        $data['title']          = 'Profil Pengajar (Asatidz & Asatidzah) - RBQ Al Fatih';
        $data['active_menu']    = 'pengajar';
        $data['filter_jk']      = $filter_jk;
        $data['daftar_pengajar']= $this->Pengajar_model->get_all($filter_jk, true);
        $data['total_pengajar'] = $this->Pengajar_model->count_active();

        $this->load->view('public/layout/header', $data);
        $this->load->view('public/pengajar', $data);
        $this->load->view('public/layout/footer', $data);
    }

    /**
     * Endpoint AJAX untuk mengambil detail profil satu pengajar (Modal Pop-Up)
     *
     * Mengembalikan data JSON lengkap: nama, gelar, pendidikan,
     * sertifikasi, pengalaman, skill badges, dan quote pengajar.
     *
     * @param  int $id ID pengajar
     * @return void    Output JSON
     */
    public function ajax_detail_pengajar($id)
    {
        $pengajar = $this->Pengajar_model->get_by_id($id);

        if (!$pengajar || !$pengajar->is_active) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(404)
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'Data pengajar tidak ditemukan atau tidak aktif.'
                ]));
            return;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => 'success',
                'data'   => $pengajar
            ]));
    }
}

