<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_tanah extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Tanah_model');
        $this->load->library('form_validation');
    }
    
    public function index(): void {
        $data['page_title'] = 'Jenis Tanah';
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

    public function tambah_tanah(): void {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/tanah');
        }
        
        $data['page_title'] = 'Tambah Jenis Tanah';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Tanah', 'url' => site_url('admin/tanah')],
            ['label' => 'Tambah', 'url' => site_url('admin/tanah/tambah_tanah')]
        ];
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_tanah', 'Nama Tanah', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $data_insert = [
                    'nama_tanah' => $this->input->post('nama_tanah'),
                    'ph_min' => $this->input->post('ph_min') ?: null,
                    'ph_max' => $this->input->post('ph_max') ?: null,
                    'kandungan_n' => $this->input->post('kandungan_n') ?: null,
                    'kandungan_p' => $this->input->post('kandungan_p') ?: null,
                    'kandungan_k' => $this->input->post('kandungan_k') ?: null,
                    'rekomendasi' => $this->input->post('rekomendasi') ?: null
                ];
                
                if ($this->Tanah_model->create($data_insert)) {
                    $this->session->set_flashdata('success', 'Jenis tanah berhasil ditambahkan');
                    redirect('admin/tanah');
                } else {
                    $data['error'] = 'Gagal menambahkan jenis tanah';
                }
            }
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/tanah/Tambah_tanah', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function ubah_tanah($id): void {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/tanah');
        }
        
        $tanah = $this->Tanah_model->get_by_id($id);
        if (!$tanah) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/tanah');
        }
        
        $data['page_title'] = 'Edit Jenis Tanah';
        $data['tanah'] = $tanah;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Tanah', 'url' => site_url('admin/tanah')],
            ['label' => 'Edit', 'url' => site_url('admin/tanah/ubah_tanah/' . $id)]
        ];
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_tanah', 'Nama Tanah', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $data_update = [
                    'nama_tanah' => $this->input->post('nama_tanah'),
                    'ph_min' => $this->input->post('ph_min') ?: null,
                    'ph_max' => $this->input->post('ph_max') ?: null,
                    'kandungan_n' => $this->input->post('kandungan_n') ?: null,
                    'kandungan_p' => $this->input->post('kandungan_p') ?: null,
                    'kandungan_k' => $this->input->post('kandungan_k') ?: null,
                    'rekomendasi' => $this->input->post('rekomendasi') ?: null
                ];
                
                if ($this->Tanah_model->update($id, $data_update)) {
                    $this->session->set_flashdata('success', 'Jenis tanah berhasil diupdate');
                    redirect('admin/tanah');
                } else {
                    $data['error'] = 'Gagal mengupdate jenis tanah';
                }
            }
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/tanah/ubah_tanah', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function hapus_tanah($id): void {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/tanah');
        }
        
        if ($this->Tanah_model->delete($id)) {
            $this->session->set_flashdata('success', 'Jenis tanah berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jenis tanah');
        }
        
        redirect('admin/tanah');
    }
}