<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_penyakit extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Penyakit_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index(): void
    {
        $data['page_title'] = 'Penyakit';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Penyakit', 'url' => site_url('admin/penyakit')]
        ];

        $data['penyakit'] = $this->Penyakit_model->get_all();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/penyakit/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_penyakit(): void
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/penyakit');
        }

        $data['page_title'] = 'Tambah Penyakit';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Penyakit', 'url' => site_url('admin/penyakit')],
            ['label' => 'Tambah', 'url' => site_url('admin/penyakit/tambah_penyakit')]
        ];

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_penyakit', 'Nama Penyakit', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data_insert = [
                    'nama_penyakit' => $this->input->post('nama_penyakit'),
                    'penyebab' => $this->input->post('penyebab'),
                    'gejala' => $this->input->post('gejala'),
                    'cara_pengendalian' => $this->input->post('cara_pengendalian')
                ];

                // Upload gambar
                if (!empty($_FILES['gambar_ilustrasi']['name'])) {
                    $upload_result = $this->upload_gambar('gambar_ilustrasi', 'penyakit');
                    if ($upload_result['success']) {
                        $data_insert['gambar_ilustrasi'] = $upload_result['file_name'];
                    } else {
                        $data['error'] = $upload_result['error'];
                    }
                }

                if (!isset($data['error'])) {
                    if ($this->Penyakit_model->create($data_insert)) {
                        $this->session->set_flashdata('success', 'Penyakit berhasil ditambahkan');
                        redirect('admin/penyakit');
                    } else {
                        $data['error'] = 'Gagal menambahkan penyakit';
                    }
                }
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/penyakit/Tambah_penyakit', $data);
        $this->load->view('admin/templates/footer');
    }

    public function ubah_penyakit($id): void
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/penyakit');
        }

        $penyakit = $this->Penyakit_model->get_by_id($id);
        if (!$penyakit) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/penyakit');
        }

        $data['page_title'] = 'Edit Penyakit';
        $data['penyakit'] = $penyakit;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Penyakit', 'url' => site_url('admin/penyakit')],
            ['label' => 'Edit', 'url' => site_url('admin/penyakit/ubah_penyakit/' . $id)]
        ];

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_penyakit', 'Nama Penyakit', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data_update = [
                    'nama_penyakit' => $this->input->post('nama_penyakit'),
                    'penyebab' => $this->input->post('penyebab'),
                    'gejala' => $this->input->post('gejala'),
                    'cara_pengendalian' => $this->input->post('cara_pengendalian')
                ];

                // Upload gambar baru jika ada
                if (!empty($_FILES['gambar_ilustrasi']['name'])) {
                    $upload_result = $this->upload_gambar('gambar_ilustrasi', 'penyakit');
                    if ($upload_result['success']) {
                        // Hapus gambar lama
                        if (!empty($penyakit->gambar_ilustrasi)) {
                            $old_file = FCPATH . 'assets/img/penyakit/' . $penyakit->gambar_ilustrasi;
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                        $data_update['gambar_ilustrasi'] = $upload_result['file_name'];
                    } else {
                        $data['error'] = $upload_result['error'];
                    }
                }

                if (!isset($data['error'])) {
                    if ($this->Penyakit_model->update($id, $data_update)) {
                        $this->session->set_flashdata('success', 'Penyakit berhasil diupdate');
                        redirect('admin/penyakit');
                    } else {
                        $data['error'] = 'Gagal mengupdate penyakit';
                    }
                }
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/penyakit/ubah_penyakit', $data);
        $this->load->view('admin/templates/footer');
    }

    public function hapus_penyakit($id): void
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/penyakit');
        }

        $penyakit = $this->Penyakit_model->get_by_id($id);
        if ($penyakit && !empty($penyakit->gambar_ilustrasi)) {
            $file_path = FCPATH . 'assets/img/penyakit/' . $penyakit->gambar_ilustrasi;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        if ($this->Penyakit_model->delete($id)) {
            $this->session->set_flashdata('success', 'Penyakit berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus penyakit');
        }

        redirect('admin/penyakit');
    }

    private function upload_gambar($field_name, $folder): array
    {
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

