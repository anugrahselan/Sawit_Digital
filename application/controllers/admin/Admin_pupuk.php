<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pupuk extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin_or_penyuluh();
        $this->load->model('Jenis_pupuk_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }
    
    public function index() {
        $data['page_title'] = 'Jenis Pupuk & Dosis Pupuk';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')]
        ];
        
        $data['pupuk'] = $this->Jenis_pupuk_model->get_all();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();
        
        // Get dosis pupuk yang diinput user dengan join jenis_pupuk dan jenis_tanah
        $this->db->select('dosis_pupuk.*, jenis_pupuk.nama_pupuk, jenis_tanah.nama_tanah');
        $this->db->from('dosis_pupuk');
        $this->db->join('jenis_pupuk', 'jenis_pupuk.id_pupuk = dosis_pupuk.id_pupuk', 'left');
        $this->db->join('jenis_tanah', 'jenis_tanah.id_tanah = dosis_pupuk.id_tanah', 'left');
        $this->db->order_by('dosis_pupuk.id_dosis', 'DESC');
        $data['dosis'] = $this->db->get()->result();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pupuk/index', $data);
        $this->load->view('admin/layout/footer');
    }
    
    public function create() {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/pupuk');
        }
        
        $data['page_title'] = 'Tambah Jenis Pupuk';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')],
            ['label' => 'Tambah', 'url' => site_url('admin/pupuk/create')]
        ];
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_pupuk', 'Nama Pupuk', 'required');
            $this->form_validation->set_rules('kandungan', 'Kandungan', 'required');
            $this->form_validation->set_rules('fungsi', 'Fungsi', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $data_insert = [
                    'nama_pupuk' => $this->input->post('nama_pupuk'),
                    'kandungan' => $this->input->post('kandungan'),
                    'fungsi' => $this->input->post('fungsi'),
                    'waktu_aplikasi' => $this->input->post('waktu_aplikasi'),
                    'catatan_khusus' => $this->input->post('catatan_khusus')
                ];
                
                // Upload gambar
                if (!empty($_FILES['gambar_pupuk']['name'])) {
                    $upload_result = $this->upload_gambar('gambar_pupuk', 'pupuk');
                    if ($upload_result['success']) {
                        $data_insert['gambar_pupuk'] = $upload_result['file_name'];
                    } else {
                        $data['error'] = $upload_result['error'];
                    }
                }
                
                if (!isset($data['error'])) {
                    if ($this->Jenis_pupuk_model->create($data_insert)) {
                        $this->session->set_flashdata('success', 'Jenis pupuk berhasil ditambahkan');
                        redirect('admin/pupuk');
                    } else {
                        $data['error'] = 'Gagal menambahkan jenis pupuk';
                    }
                }
            }
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pupuk/form', $data);
        $this->load->view('admin/layout/footer');
    }
    
    public function update($id) {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/pupuk');
        }
        
        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if (!$pupuk) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/pupuk');
        }
        
        $data['page_title'] = 'Edit Jenis Pupuk';
        $data['pupuk'] = $pupuk;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Pupuk', 'url' => site_url('admin/pupuk')],
            ['label' => 'Edit', 'url' => site_url('admin/pupuk/update/' . $id)]
        ];
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_pupuk', 'Nama Pupuk', 'required');
            $this->form_validation->set_rules('kandungan', 'Kandungan', 'required');
            $this->form_validation->set_rules('fungsi', 'Fungsi', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $data_update = [
                    'nama_pupuk' => $this->input->post('nama_pupuk'),
                    'kandungan' => $this->input->post('kandungan'),
                    'fungsi' => $this->input->post('fungsi'),
                    'waktu_aplikasi' => $this->input->post('waktu_aplikasi'),
                    'catatan_khusus' => $this->input->post('catatan_khusus')
                ];
                
                // Upload gambar baru jika ada
                if (!empty($_FILES['gambar_pupuk']['name'])) {
                    $upload_result = $this->upload_gambar('gambar_pupuk', 'pupuk');
                    if ($upload_result['success']) {
                        // Hapus gambar lama
                        if (!empty($pupuk->gambar_pupuk)) {
                            $old_file = FCPATH . 'assets/img/pupuk/' . $pupuk->gambar_pupuk;
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                        $data_update['gambar_pupuk'] = $upload_result['file_name'];
                    } else {
                        $data['error'] = $upload_result['error'];
                    }
                }
                
                if (!isset($data['error'])) {
                    if ($this->Jenis_pupuk_model->update($id, $data_update)) {
                        $this->session->set_flashdata('success', 'Jenis pupuk berhasil diupdate');
                        redirect('admin/pupuk');
                    } else {
                        $data['error'] = 'Gagal mengupdate jenis pupuk';
                    }
                }
            }
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pupuk/form', $data);
        $this->load->view('admin/layout/footer');
    }
    
    public function delete($id) {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/pupuk');
        }
        
        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if ($pupuk && !empty($pupuk->gambar_pupuk)) {
            $file_path = FCPATH . 'assets/img/pupuk/' . $pupuk->gambar_pupuk;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        if ($this->Jenis_pupuk_model->delete($id)) {
            $this->session->set_flashdata('success', 'Jenis pupuk berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jenis pupuk');
        }
        
        redirect('admin/pupuk');
    }
    
    private function upload_gambar($field_name, $folder) {
        $upload_path = FCPATH . 'assets/img/' . $folder . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }
        
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;
        
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload($field_name)) {
            return ['success' => true, 'file_name' => $this->upload->data('file_name')];
        } else {
            return ['success' => false, 'error' => $this->upload->display_errors('', '')];
        }
    }
}
