<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_tanah extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Tanah_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['page_title'] = 'Jenis Tanah';
        $data['page_css'] = 'tanah.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Tanah', 'url' => site_url('admin/tanah')]
        ];

        $data['tanah'] = $this->Tanah_model->get_all();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/tanah/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_tanah()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/tanah');
        }

        $data['page_title'] = 'Tambah Jenis Tanah';
        $data['page_css'] = 'tanah.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Tanah', 'url' => site_url('admin/tanah')],
            ['label' => 'Tambah', 'url' => site_url('admin/tanah/tambah_tanah')]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_tanah', 'Nama Tanah', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_simpan_tanah();
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/tanah/Tambah_tanah', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _simpan_tanah()
    {
        $data = [
            'nama_tanah' => $this->input->post('nama_tanah'),
            'ph_min' => $this->input->post('ph_min') ?: null,
            'ph_max' => $this->input->post('ph_max') ?: null,
            'kandungan_n' => $this->input->post('kandungan_n') ?: null,
            'kandungan_p' => $this->input->post('kandungan_p') ?: null,
            'kandungan_k' => $this->input->post('kandungan_k') ?: null,
            'rekomendasi' => $this->input->post('rekomendasi') ?: null
        ];

        $simpan = $this->Tanah_model->create($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis tanah berhasil ditambahkan!</div>');
            redirect('admin/tanah');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan jenis tanah!</div>');
            redirect('admin/tanah/tambah');
        }
    }

    public function ubah_tanah($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/tanah');
        }

        $tanah = $this->Tanah_model->get_by_id($id);
        if (!$tanah) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data jenis tanah tidak ditemukan!</div>');
            redirect('admin/tanah');
        }

        $data['page_title'] = 'Edit Jenis Tanah';
        $data['page_css'] = 'tanah.css';
        $data['tanah'] = $tanah;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Tanah', 'url' => site_url('admin/tanah')],
            ['label' => 'Edit', 'url' => site_url('admin/tanah/ubah_tanah/' . $id)]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_tanah', 'Nama Tanah', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_tanah($id);
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/tanah/ubah_tanah', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _ubah_tanah($id)
    {
        $data = [
            'nama_tanah' => $this->input->post('nama_tanah'),
            'ph_min' => $this->input->post('ph_min') ?: null,
            'ph_max' => $this->input->post('ph_max') ?: null,
            'kandungan_n' => $this->input->post('kandungan_n') ?: null,
            'kandungan_p' => $this->input->post('kandungan_p') ?: null,
            'kandungan_k' => $this->input->post('kandungan_k') ?: null,
            'rekomendasi' => $this->input->post('rekomendasi') ?: null
        ];

        $ubah = $this->Tanah_model->update($id, $data);
        if ($ubah) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis tanah berhasil diubah!</div>');
            redirect('admin/tanah');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengubah jenis tanah!</div>');
            redirect('admin/tanah/ubah/' . $id);
        }
    }

    public function hapus_tanah($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/tanah');
        }

        $tanah = $this->Tanah_model->get_by_id($id);
        if ($tanah) {
            $hapus = $this->Tanah_model->delete($id);
            if ($hapus) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal di hapus</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan</div>');
        }
        redirect('admin/tanah');
    }
}