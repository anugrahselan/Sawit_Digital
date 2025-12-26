<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_perusahaan extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin_or_penyuluh();
        
        $this->load->model('Perusahaan_model');
        $this->load->model('Kabupaten_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }
    
    public function index() {
        $data['page_title'] = 'Perusahaan';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Perusahaan', 'url' => site_url('admin/perusahaan')]
        ];
        
        // Pagination
        $config['base_url'] = site_url('admin/perusahaan');
        $config['total_rows'] = $this->Perusahaan_model->count_all();
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['perusahaan'] = $this->Perusahaan_model->get_all($config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/perusahaan/index', $data);
        $this->load->view('admin/layout/footer');
    }
    
    public function create() {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/perusahaan');
        }
        
        $data['page_title'] = 'Tambah Perusahaan';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Perusahaan', 'url' => site_url('admin/perusahaan')],
            ['label' => 'Tambah', 'url' => site_url('admin/perusahaan/create')]
        ];
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $nama_perusahaan = $this->input->post('nama_perusahaan');
                $id_kabupaten = $this->input->post('id_kabupaten');
                
                // Check unique nama_perusahaan per kabupaten
                if ($this->Perusahaan_model->nama_exists_in_kabupaten($nama_perusahaan, $id_kabupaten)) {
                    $data['error'] = 'Nama perusahaan sudah ada di kabupaten ini';
                } else {
                    $data_insert = [
                        'nama_perusahaan' => $nama_perusahaan,
                        'id_kabupaten' => $id_kabupaten,
                        'alamat' => $this->input->post('alamat'),
                        'kontak' => $this->input->post('kontak')
                    ];
                    
                    if ($this->Perusahaan_model->create($data_insert)) {
                        $this->session->set_flashdata('success', 'Perusahaan berhasil ditambahkan');
                        redirect('admin/perusahaan');
                    } else {
                        $data['error'] = 'Gagal menambahkan perusahaan';
                    }
                }
            }
        }
        
        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/perusahaan/form', $data);
        $this->load->view('admin/layout/footer');
    }
    
    public function update($id) {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/perusahaan');
        }
        
        $perusahaan = $this->Perusahaan_model->get_by_id($id);
        if (!$perusahaan) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/perusahaan');
        }
        
        $data['page_title'] = 'Edit Perusahaan';
        $data['perusahaan'] = $perusahaan;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Perusahaan', 'url' => site_url('admin/perusahaan')],
            ['label' => 'Edit', 'url' => site_url('admin/perusahaan/update/' . $id)]
        ];
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $nama_perusahaan = $this->input->post('nama_perusahaan');
                $id_kabupaten = $this->input->post('id_kabupaten');
                
                // Check unique nama_perusahaan per kabupaten
                if ($this->Perusahaan_model->nama_exists_in_kabupaten($nama_perusahaan, $id_kabupaten, $id)) {
                    $data['error'] = 'Nama perusahaan sudah ada di kabupaten ini';
                } else {
                    $data_update = [
                        'nama_perusahaan' => $nama_perusahaan,
                        'id_kabupaten' => $id_kabupaten,
                        'alamat' => $this->input->post('alamat'),
                        'kontak' => $this->input->post('kontak')
                    ];
                    
                    if ($this->Perusahaan_model->update($id, $data_update)) {
                        $this->session->set_flashdata('success', 'Perusahaan berhasil diupdate');
                        redirect('admin/perusahaan');
                    } else {
                        $data['error'] = 'Gagal mengupdate perusahaan';
                    }
                }
            }
        }
        
        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/perusahaan/form', $data);
        $this->load->view('admin/layout/footer');
    }
    
    public function delete($id) {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/perusahaan');
        }
        
        if ($this->Perusahaan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Perusahaan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus perusahaan');
        }
        
        redirect('admin/perusahaan');
    }
}


