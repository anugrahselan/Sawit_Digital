<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_kabupaten extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Kabupaten_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['page_title'] = 'Kabupaten';
        $data['page_css'] = 'kabupaten.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kabupaten', 'url' => site_url('admin/kabupaten')]
        ];

        $data['kabupaten'] = $this->Kabupaten_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kabupaten/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_kabupaten()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/kabupaten');
        }

        $data['page_title'] = 'Tambah Kabupaten';
        $data['page_css'] = 'kabupaten.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kabupaten', 'url' => site_url('admin/kabupaten')],
            ['label' => 'Tambah', 'url' => site_url('admin/kabupaten/tambah_kabupaten')]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_kabupaten', 'Nama Kabupaten', 'required|is_unique[kabupaten.nama_kabupaten]');

            if ($this->form_validation->run() !== FALSE) {
                $this->_simpan_kabupaten();
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kabupaten/Tambah_kabupaten', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _simpan_kabupaten()
    {
        $data = [
            'nama_kabupaten' => $this->input->post('nama_kabupaten')
        ];

        $simpan = $this->Kabupaten_model->create($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kabupaten berhasil ditambahkan!</div>');
            redirect('admin/kabupaten');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan kabupaten!</div>');
            redirect('admin/kabupaten/tambah');
        }
    }

    public function ubah_kabupaten($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/kabupaten');
        }

        $kabupaten = $this->Kabupaten_model->get_by_id($id);
        if (!$kabupaten) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data kabupaten tidak ditemukan!</div>');
            redirect('admin/kabupaten');
        }

        $data['page_title'] = 'Edit Kabupaten';
        $data['page_css'] = 'kabupaten.css';
        $data['kabupaten'] = $kabupaten;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kabupaten', 'url' => site_url('admin/kabupaten')],
            ['label' => 'Edit', 'url' => site_url('admin/kabupaten/ubah_kabupaten/' . $id)]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_kabupaten', 'Nama Kabupaten', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_kabupaten($id);
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kabupaten/ubah_kabupaten', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _ubah_kabupaten($id)
    {
        $data = [
            'nama_kabupaten' => $this->input->post('nama_kabupaten')
        ];

        $ubah = $this->Kabupaten_model->update($id, $data);
        if ($ubah) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kabupaten berhasil diubah!</div>');
            redirect('admin/kabupaten');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengubah kabupaten!</div>');
            redirect('admin/kabupaten/ubah/' . $id);
        }
    }

    public function hapus_kabupaten($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/kabupaten');
        }

        $kabupaten = $this->Kabupaten_model->get_by_id($id);
        if ($kabupaten) {
            $hapus = $this->Kabupaten_model->delete($id);
            if ($hapus) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal di hapus</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan</div>');
        }
        redirect('admin/kabupaten');
    }
}

