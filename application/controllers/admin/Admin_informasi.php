<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_informasi extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Informasi_tambahan_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }
    
    public function index(): void {
        $data['page_title'] = 'Informasi (Artikel)';
        $data['page_css'] = 'informasi.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Informasi', 'url' => site_url('admin/informasi')]
        ];
        
        $data['articles'] = $this->Informasi_tambahan_model->get_all();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/informasi/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_informasi(): void {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/informasi');
        }
        
        $data['page_title'] = 'Tambah Artikel';
        $data['page_css'] = 'informasi.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Informasi', 'url' => site_url('admin/informasi')],
            ['label' => 'Tambah', 'url' => site_url('admin/informasi/tambah_informasi')]
        ];
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('judul', 'Judul', 'required');
            $this->form_validation->set_rules('konten', 'Konten', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $data_insert = [
                    'judul' => $this->input->post('judul'),
                    'kategori' => $this->input->post('kategori'),
                    'penulis' => $this->input->post('penulis'),
                    'konten' => $this->input->post('konten'),
                    'tanggal' => $this->input->post('tanggal') ?: date('Y-m-d')
                ];

                if (!empty($_FILES['gambar_header']['name'])) {
                    $upload_result = $this->upload_gambar('gambar_header', 'articles');
                    if ($upload_result['success']) {
                        $data_insert['gambar_header'] = $upload_result['file_name'];
                    } else {
                        $data['error'] = $upload_result['error'];
                    }
                }

                if (!empty($_FILES['thumbnail']['name']) && !isset($data['error'])) {
                    $upload_result = $this->upload_gambar('thumbnail', 'articles');
                    if ($upload_result['success']) {
                        $data_insert['thumbnail'] = $upload_result['file_name'];
                    }
                }
                
                if (!isset($data['error'])) {
                    if ($this->Informasi_tambahan_model->create($data_insert)) {
                        $this->session->set_flashdata('success', 'Artikel berhasil ditambahkan');
                        redirect('admin/informasi');
                    } else {
                        $data['error'] = 'Gagal menambahkan artikel';
                    }
                }
            }
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/informasi/Tambah_informasi', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function ubah_informasi($id): void {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/informasi');
        }
        
        $article = $this->Informasi_tambahan_model->get_by_id($id);
        if (!$article) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/informasi');
        }
        
        $data['page_title'] = 'Edit Artikel';
        $data['page_css'] = 'informasi.css';
        $data['article'] = $article;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Informasi', 'url' => site_url('admin/informasi')],
            ['label' => 'Edit', 'url' => site_url('admin/informasi/ubah_informasi/' . $id)]
        ];
        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('judul', 'Judul', 'required');
            $this->form_validation->set_rules('konten', 'Konten', 'required');
            
            if ($this->form_validation->run() == TRUE) {
                $data_update = [
                    'judul' => $this->input->post('judul'),
                    'kategori' => $this->input->post('kategori'),
                    'penulis' => $this->input->post('penulis'),
                    'konten' => $this->input->post('konten'),
                    'tanggal' => $this->input->post('tanggal') ?: date('Y-m-d')
                ];

                if (!empty($_FILES['gambar_header']['name'])) {
                    $upload_result = $this->upload_gambar('gambar_header', 'articles');
                    if ($upload_result['success']) {
                        // Hapus gambar lama
                        if (!empty($article->gambar_header)) {
                            $old_file = FCPATH . 'assets/img/articles/' . $article->gambar_header;
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                        $data_update['gambar_header'] = $upload_result['file_name'];
                    } else {
                        $data['error'] = $upload_result['error'];
                    }
                }

                if (!empty($_FILES['thumbnail']['name']) && !isset($data['error'])) {
                    $upload_result = $this->upload_gambar('thumbnail', 'articles');
                    if ($upload_result['success']) {
                        // Hapus thumbnail lama
                        if (!empty($article->thumbnail)) {
                            $old_file = FCPATH . 'assets/img/articles/' . $article->thumbnail;
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                        $data_update['thumbnail'] = $upload_result['file_name'];
                    }
                }
                
                if (!isset($data['error'])) {
                    if ($this->Informasi_tambahan_model->update($id, $data_update)) {
                        $this->session->set_flashdata('success', 'Artikel berhasil diupdate');
                        redirect('admin/informasi');
                    } else {
                        $data['error'] = 'Gagal mengupdate artikel';
                    }
                }
            }
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/informasi/ubah_informasi', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function hapus_informasi($id): void {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/informasi');
        }
        
        $article = $this->Informasi_tambahan_model->get_by_id($id);
        if ($article) {
            if (!empty($article->gambar_header)) {
                $file_path = FCPATH . 'assets/img/articles/' . $article->gambar_header;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            if (!empty($article->thumbnail)) {
                $file_path = FCPATH . 'assets/img/articles/' . $article->thumbnail;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
        
        if ($this->Informasi_tambahan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Artikel berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus artikel');
        }
        
        redirect('admin/informasi');
    }

    private function upload_gambar($field_name, $folder): array {
        $upload_path = FCPATH . 'assets/img/' . $folder . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }
        
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;
        
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();
            return ['success' => true, 'file_name' => $upload_data['file_name']];
        } else {
            return ['success' => false, 'error' => $this->upload->display_errors('', '')];
        }
    }
}

