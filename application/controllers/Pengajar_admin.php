<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Pengajar_admin
 *
 * Mengelola data tenaga pendidik (Asatidz dan Asatidzah) oleh Administrator:
 * - Menampilkan daftar pengajar (aktif dan non-aktif)
 * - Menambah pengajar baru
 * - Mengubah biodata, pendidikan, sertifikasi, dan spesialisasi pengajar
 * - Mengunggah foto profil pengajar
 * - Mengubah status aktif / non-aktif pengajar
 * - Menghapus pengajar
 *
 * Hak Akses: Administrator
 *
 * @package    RBQ Al Fatih
 * @subpackage Controllers
 * @category   Administrasi Pengajar
 * @author     RBQ Al Fatih Dev Team
 * @since      v1.2
 */
class Pengajar_admin extends MY_Controller
{
    /**
     * Constructor
     *
     * Memastikan hanya Administrator yang berhak mengakses modul ini
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->auth_lib->check_login();
        $this->auth_lib->check_role('admin');

        $this->load->model('Pengajar_model');
        $this->load->model('Semester_model');
        $this->load->model('TahunAjaran_model');
        $this->load->library('form_validation');
    }

    /**
     * Menampilkan daftar seluruh pengajar
     *
     * @return void
     */
    public function index()
    {
        $data['title']            = 'Manajemen Profil Pengajar (Asatidz) - RBQ Al Fatih';
        $data['active_menu']      = 'pengajar_admin';
        $data['current_semester'] = $this->Semester_model->get_aktif();
        $data['current_ta']       = $this->TahunAjaran_model->get_aktif();
        // Ambil semua pengajar (baik aktif maupun nonaktif untuk admin)
        $data['daftar_pengajar']  = $this->Pengajar_model->get_all(null, false);

        $this->load->view('layout/header', $data);
        $this->load->view('pengajar_admin/index', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * Menyimpan data pengajar baru
     *
     * @return void
     */
    public function simpan()
    {
        $this->form_validation->set_rules('nama', 'Nama Pengajar', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan / Peran', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required|in_list[L,P]');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan Terakhir', 'trim|required');
        $this->form_validation->set_rules('pengalaman', 'Pengalaman Mengajar', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pengajar_admin');
            return;
        }

        // Handle upload foto jika ada
        $foto_name = null;
        if (!empty($_FILES['foto']['name'])) {
            $foto_name = $this->_upload_foto();
        }

        $data = [
            'nama'          => $this->input->post('nama', TRUE),
            'gelar'         => $this->input->post('gelar', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
            'jabatan'       => $this->input->post('jabatan', TRUE),
            'foto'          => $foto_name,
            'pendidikan'    => $this->input->post('pendidikan', TRUE),
            'sertifikasi'   => $this->input->post('sertifikasi', TRUE),
            'pengalaman'    => $this->input->post('pengalaman', TRUE),
            'spesialisasi'  => $this->input->post('spesialisasi', TRUE),
            'quote'         => $this->input->post('quote', TRUE),
            'kontak_hp'     => $this->input->post('kontak_hp', TRUE),
            'email'         => $this->input->post('email', TRUE),
            'urutan'        => (int)($this->input->post('urutan', TRUE) ?: 1),
            'is_active'     => 1
        ];

        $this->Pengajar_model->insert($data);
        $this->session->set_flashdata('success', 'Data profil pengajar berhasil ditambahkan dan tampil di website profil.');
        redirect('pengajar_admin');
    }

    /**
     * Memperbarui data profil pengajar
     *
     * @return void
     */
    public function update()
    {
        $id = $this->input->post('id', TRUE);
        $pengajar = $this->Pengajar_model->get_by_id($id);

        if (!$pengajar) {
            $this->session->set_flashdata('error', 'Data pengajar tidak ditemukan.');
            redirect('pengajar_admin');
            return;
        }

        $this->form_validation->set_rules('nama', 'Nama Pengajar', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan / Peran', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required|in_list[L,P]');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan Terakhir', 'trim|required');
        $this->form_validation->set_rules('pengalaman', 'Pengalaman Mengajar', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pengajar_admin');
            return;
        }

        $foto_name = $pengajar->foto;
        if (!empty($_FILES['foto']['name'])) {
            $new_foto = $this->_upload_foto();
            if ($new_foto) {
                // Hapus foto lama jika ada
                if ($pengajar->foto && file_exists(FCPATH . 'uploads/pengajar/' . $pengajar->foto)) {
                    @unlink(FCPATH . 'uploads/pengajar/' . $pengajar->foto);
                }
                $foto_name = $new_foto;
            }
        }

        $data = [
            'nama'          => $this->input->post('nama', TRUE),
            'gelar'         => $this->input->post('gelar', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
            'jabatan'       => $this->input->post('jabatan', TRUE),
            'foto'          => $foto_name,
            'pendidikan'    => $this->input->post('pendidikan', TRUE),
            'sertifikasi'   => $this->input->post('sertifikasi', TRUE),
            'pengalaman'    => $this->input->post('pengalaman', TRUE),
            'spesialisasi'  => $this->input->post('spesialisasi', TRUE),
            'quote'         => $this->input->post('quote', TRUE),
            'kontak_hp'     => $this->input->post('kontak_hp', TRUE),
            'email'         => $this->input->post('email', TRUE),
            'urutan'        => (int)($this->input->post('urutan', TRUE) ?: 1)
        ];

        $this->Pengajar_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data profil pengajar berhasil diperbarui.');
        redirect('pengajar_admin');
    }

    /**
     * Mengubah status aktif / non-aktif pengajar
     *
     * @param  int $id ID pengajar
     * @return void
     */
    public function toggle_status($id)
    {
        $pengajar = $this->Pengajar_model->get_by_id($id);
        if ($pengajar) {
            $new_status = $pengajar->is_active ? 0 : 1;
            $this->Pengajar_model->update($id, ['is_active' => $new_status]);
            $msg = $new_status ? 'Profil pengajar berhasil diaktifkan.' : 'Profil pengajar dinonaktifkan (disembunyikan dari web).';
            $this->session->set_flashdata('success', $msg);
        }
        redirect('pengajar_admin');
    }

    /**
     * Menghapus data pengajar
     *
     * @param  int $id ID pengajar
     * @return void
     */
    public function hapus($id)
    {
        $pengajar = $this->Pengajar_model->get_by_id($id);
        if ($pengajar) {
            if ($pengajar->foto && file_exists(FCPATH . 'uploads/pengajar/' . $pengajar->foto)) {
                @unlink(FCPATH . 'uploads/pengajar/' . $pengajar->foto);
            }
            $this->Pengajar_model->delete($id);
            $this->session->set_flashdata('success', 'Data pengajar berhasil dihapus.');
        }
        redirect('pengajar_admin');
    }

    /**
     * Helper privat upload foto pengajar
     *
     * @return string|null Nama file yang berhasil diunggah atau null
     */
    private function _upload_foto()
    {
        $config['upload_path']   = './uploads/pengajar/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['max_size']      = 3072; // 3MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }

        return null;
    }
}
