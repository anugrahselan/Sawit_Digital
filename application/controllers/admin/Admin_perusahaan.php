<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_perusahaan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Perusahaan_model');
        $this->load->model('Kabupaten_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['page_title'] = 'Perusahaan';
        $data['page_css'] = 'perusahaan.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Perusahaan', 'url' => site_url('admin/perusahaan')]
        ];

        $data['perusahaan'] = $this->Perusahaan_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/perusahaan/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_perusahaan()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/perusahaan');
        }

        $data['page_title'] = 'Tambah Perusahaan';
        $data['page_css'] = 'perusahaan.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Perusahaan', 'url' => site_url('admin/perusahaan')],
            ['label' => 'Tambah', 'url' => site_url('admin/perusahaan/tambah_perusahaan')]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_simpan_perusahaan();
            }
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/perusahaan/Tambah_perusahaan', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _simpan_perusahaan()
    {
        $data = [
            'nama_perusahaan' => $this->input->post('nama_perusahaan'),
            'id_kabupaten' => $this->input->post('id_kabupaten'),
            'alamat' => $this->input->post('alamat'),
            'kontak' => $this->input->post('kontak')
        ];

        $simpan = $this->Perusahaan_model->create($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Perusahaan berhasil ditambahkan!</div>');
            redirect('admin/perusahaan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan perusahaan!</div>');
            redirect('admin/perusahaan/tambah');
        }
    }

    public function ubah_perusahaan($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/perusahaan');
        }

        $perusahaan = $this->Perusahaan_model->get_by_id($id);
        if (!$perusahaan) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data perusahaan tidak ditemukan!</div>');
            redirect('admin/perusahaan');
        }

        $data['page_title'] = 'Edit Perusahaan';
        $data['page_css'] = 'perusahaan.css';
        $data['perusahaan'] = $perusahaan;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Perusahaan', 'url' => site_url('admin/perusahaan')],
            ['label' => 'Edit', 'url' => site_url('admin/perusahaan/ubah_perusahaan/' . $id)]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_perusahaan($id);
            }
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/perusahaan/ubah_perusahaan', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _ubah_perusahaan($id)
    {
        $data = [
            'nama_perusahaan' => $this->input->post('nama_perusahaan'),
            'id_kabupaten' => $this->input->post('id_kabupaten'),
            'alamat' => $this->input->post('alamat'),
            'kontak' => $this->input->post('kontak')
        ];

        $ubah = $this->Perusahaan_model->update($id, $data);
        if ($ubah) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Perusahaan berhasil diubah!</div>');
            redirect('admin/perusahaan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengubah perusahaan!</div>');
            redirect('admin/perusahaan/ubah/' . $id);
        }
    }

    public function hapus_perusahaan($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/perusahaan');
        }

        $perusahaan = $this->Perusahaan_model->get_by_id($id);
        if ($perusahaan) {
            $hapus = $this->Perusahaan_model->delete($id);
            if ($hapus) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal di hapus</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan</div>');
        }
        redirect('admin/perusahaan');
    }
}