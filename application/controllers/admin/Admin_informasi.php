<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_informasi extends MY_Controller
{
    private $upload_path = 'assets/img/articles/';

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Informasi_tambahan_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['page_title'] = 'Informasi Tambahan';
        $data['page_css'] = 'informasi.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Informasi', 'url' => site_url('admin/informasi')]
        ];
        $data['articles'] = $this->Informasi_tambahan_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/informasi/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_informasi()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/informasi');
        }

        $data['page_title'] = 'Tambah informasi tambahan';
        $data['page_css'] = 'informasi.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Informasi', 'url' => site_url('admin/informasi')],
            ['label' => 'Tambah', 'url' => site_url('admin/informasi/tambah_informasi')]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('judul', 'Judul', 'required');
            $this->form_validation->set_rules('konten', 'Konten', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_simpan_informasi();
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/informasi/Tambah_informasi', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _simpan_informasi()
    {
        $data = [
            'judul' => $this->input->post('judul'),
            'kategori' => $this->input->post('kategori'),
            'penulis' => $this->input->post('penulis'),
            'konten' => $this->input->post('konten'),
            'tanggal' => $this->input->post('tanggal') ?: date('Y-m-d')
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

        foreach (['gambar_header', 'thumbnail'] as $field) {
            if (!empty($_FILES[$field]['name'])) {
                if (!$this->upload->do_upload($field)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors('', '') . '</div>');
                    redirect('admin/informasi/tambah');
                    return;
                }
                $data[$field] = $this->upload->data('file_name');
            }
        }

        $simpan = $this->Informasi_tambahan_model->create($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Informasi berhasil ditambahkan!</div>');
            redirect('admin/informasi');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan informasi!</div>');
            redirect('admin/informasi/tambah');
        }
    }

    public function ubah_informasi($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/informasi');
        }

        $informasi = $this->Informasi_tambahan_model->get_by_id($id);
        if (!$informasi) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data informasi tidak ditemukan!</div>');
            redirect('admin/informasi');
        }

        $data['page_title'] = 'Edit informasi tambahan';
        $data['page_css'] = 'informasi.css';
        $data['article'] = $informasi;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Informasi', 'url' => site_url('admin/informasi')],
            ['label' => 'Edit', 'url' => site_url('admin/informasi/ubah_informasi/' . $id)]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('judul', 'Judul', 'required');
            $this->form_validation->set_rules('konten', 'Konten', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_informasi($id);
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/informasi/ubah_informasi', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _ubah_informasi($id)
    {
        $data = [
            'judul' => $this->input->post('judul'),
            'kategori' => $this->input->post('kategori'),
            'penulis' => $this->input->post('penulis'),
            'konten' => $this->input->post('konten'),
            'tanggal' => $this->input->post('tanggal') ?: date('Y-m-d')
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

        $informasi = $this->Informasi_tambahan_model->get_by_id($id);
        foreach (['gambar_header', 'thumbnail'] as $field) {
            if (!empty($_FILES[$field]['name'])) {
                if (!$this->upload->do_upload($field)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors('', '') . '</div>');
                    redirect('admin/informasi/ubah/' . $id);
                    return;
                }
                if (!empty($informasi->$field)) {
                    $file_path = $upload_path . $informasi->$field;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                $data[$field] = $this->upload->data('file_name');
            }
        }

        $ubah = $this->Informasi_tambahan_model->update($id, $data);
        if ($ubah) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Informasi berhasil diubah!</div>');
            redirect('admin/informasi');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengubah informasi!</div>');
            redirect('admin/informasi/ubah/' . $id);
        }
    }

    public function hapus_informasi($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/informasi');
        }

        $informasi = $this->Informasi_tambahan_model->get_by_id($id);
        if ($informasi) {
            $upload_path = FCPATH . $this->upload_path;
            foreach (['gambar_header', 'thumbnail'] as $field) {
                if (!empty($informasi->$field)) {
                    $file_path = $upload_path . $informasi->$field;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
            }
            $hapus = $this->Informasi_tambahan_model->delete($id);
            if ($hapus) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal di hapus</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan</div>');
        }
        redirect('admin/informasi');
    }
}

