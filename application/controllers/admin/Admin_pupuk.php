<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_pupuk extends MY_Controller
{
    private $upload_path = 'assets/img/pupuk/';

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Jenis_pupuk_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['page_title'] = 'Jenis Pupuk';
        $data['page_css'] = 'pupuk.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')]
        ];

        $data['pupuk'] = $this->Jenis_pupuk_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/pupuk/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_pupuk()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/pupuk');
        }

        $data['page_title'] = 'Tambah Jenis Pupuk';
        $data['page_css'] = 'pupuk.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')],
            ['label' => 'Tambah', 'url' => site_url('admin/pupuk/tambah_pupuk')]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_pupuk', 'Nama Pupuk', 'required');
            $this->form_validation->set_rules('kandungan', 'Kandungan', 'required');
            $this->form_validation->set_rules('fungsi', 'Fungsi', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_simpan_pupuk();
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/pupuk/Tambah_pupuk', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _simpan_pupuk()
    {
        $data = [
            'nama_pupuk' => $this->input->post('nama_pupuk'),
            'kandungan' => $this->input->post('kandungan'),
            'fungsi' => $this->input->post('fungsi'),
            'waktu_aplikasi' => $this->input->post('waktu_aplikasi'),
            'catatan_khusus' => $this->input->post('catatan_khusus')
        ];

        $upload_path = FCPATH . $this->upload_path;
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $this->upload->initialize([
            'upload_path' => $upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 2048,
            'encrypt_name' => TRUE
        ]);

        if (!empty($_FILES['gambar_pupuk']['name'])) {
            if (!$this->upload->do_upload('gambar_pupuk')) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors('', '') . '</div>');
                redirect('admin/pupuk/tambah');
                return;
            }
            $data['gambar_pupuk'] = $this->upload->data('file_name');
        }

        $simpan = $this->Jenis_pupuk_model->create($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis pupuk berhasil ditambahkan!</div>');
            redirect('admin/pupuk');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan jenis pupuk!</div>');
            redirect('admin/pupuk/tambah');
        }
    }

    public function ubah_pupuk($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/pupuk');
        }

        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if (!$pupuk) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data jenis pupuk tidak ditemukan!</div>');
            redirect('admin/pupuk');
        }

        $data['page_title'] = 'Edit Jenis Pupuk';
        $data['page_css'] = 'pupuk.css';
        $data['pupuk'] = $pupuk;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')],
            ['label' => 'Edit', 'url' => site_url('admin/pupuk/ubah_pupuk/' . $id)]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_pupuk', 'Nama Pupuk', 'required');
            $this->form_validation->set_rules('kandungan', 'Kandungan', 'required');
            $this->form_validation->set_rules('fungsi', 'Fungsi', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_pupuk($id);
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/pupuk/ubah_pupuk', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _ubah_pupuk($id)
    {
        $data = [
            'nama_pupuk' => $this->input->post('nama_pupuk'),
            'kandungan' => $this->input->post('kandungan'),
            'fungsi' => $this->input->post('fungsi'),
            'waktu_aplikasi' => $this->input->post('waktu_aplikasi') ?: null,
            'catatan_khusus' => $this->input->post('catatan_khusus') ?: null
        ];

        $upload_path = FCPATH . $this->upload_path;
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $this->upload->initialize([
            'upload_path' => $upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 2048,
            'encrypt_name' => TRUE
        ]);

        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if (!empty($_FILES['gambar_pupuk']['name'])) {
            if (!$this->upload->do_upload('gambar_pupuk')) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors('', '') . '</div>');
                redirect('admin/pupuk/ubah/' . $id);
                return;
            }
            if (!empty($pupuk->gambar_pupuk)) {
                $old_gambar = trim($pupuk->gambar_pupuk);
                if (strpos($old_gambar, 'assets/img/pupuk/') !== false) {
                    $old_gambar = basename($old_gambar);
                }
                $file_path = $upload_path . $old_gambar;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $data['gambar_pupuk'] = $this->upload->data('file_name');
        }

        $ubah = $this->Jenis_pupuk_model->update($id, $data);
        if ($ubah) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis pupuk berhasil diubah!</div>');
            redirect('admin/pupuk');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengubah jenis pupuk!</div>');
            redirect('admin/pupuk/ubah/' . $id);
        }
    }

    public function hapus_pupuk($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/pupuk');
        }

        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if ($pupuk) {
            $upload_path = FCPATH . $this->upload_path;
            if (!empty($pupuk->gambar_pupuk)) {
                $old_gambar = trim($pupuk->gambar_pupuk);
                if (strpos($old_gambar, 'assets/img/pupuk/') !== false) {
                    $old_gambar = basename($old_gambar);
                }
                $file_path = $upload_path . $old_gambar;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $hapus = $this->Jenis_pupuk_model->delete($id);
            if ($hapus) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal di hapus</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan</div>');
        }
        redirect('admin/pupuk');
    }
}
