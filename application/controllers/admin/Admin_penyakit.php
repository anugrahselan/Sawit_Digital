<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_penyakit extends MY_Controller
{
    private $upload_path = 'assets/img/penyakit/';

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Penyakit_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['page_title'] = 'Penyakit';
        $data['page_css'] = 'penyakit.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Penyakit', 'url' => site_url('admin/penyakit')]
        ];

        $data['penyakit'] = $this->Penyakit_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/penyakit/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_penyakit()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/penyakit');
        }

        $data['page_title'] = 'Tambah Penyakit';
        $data['page_css'] = 'penyakit.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Penyakit', 'url' => site_url('admin/penyakit')],
            ['label' => 'Tambah', 'url' => site_url('admin/penyakit/tambah_penyakit')]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_penyakit', 'Nama Penyakit', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_simpan_penyakit();
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/penyakit/Tambah_penyakit', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _simpan_penyakit()
    {
        $data = [
            'nama_penyakit' => $this->input->post('nama_penyakit'),
            'penyebab' => $this->input->post('penyebab'),
            'gejala' => $this->input->post('gejala'),
            'cara_pengendalian' => $this->input->post('cara_pengendalian')
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

        if (!empty($_FILES['gambar_ilustrasi']['name'])) {
            if (!$this->upload->do_upload('gambar_ilustrasi')) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors('', '') . '</div>');
                redirect('admin/penyakit/tambah');
                return;
            }
            $data['gambar_ilustrasi'] = $this->upload->data('file_name');
        }

        $simpan = $this->Penyakit_model->create($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Penyakit berhasil ditambahkan!</div>');
            redirect('admin/penyakit');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan penyakit!</div>');
            redirect('admin/penyakit/tambah');
        }
    }

    public function ubah_penyakit($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/penyakit');
        }

        $penyakit = $this->Penyakit_model->get_by_id($id);
        if (!$penyakit) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data penyakit tidak ditemukan!</div>');
            redirect('admin/penyakit');
        }

        $data['page_title'] = 'Edit Penyakit';
        $data['page_css'] = 'penyakit.css';
        $data['penyakit'] = $penyakit;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Penyakit', 'url' => site_url('admin/penyakit')],
            ['label' => 'Edit', 'url' => site_url('admin/penyakit/ubah_penyakit/' . $id)]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_penyakit', 'Nama Penyakit', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_penyakit($id);
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/penyakit/ubah_penyakit', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _ubah_penyakit($id)
    {
        $data = [
            'nama_penyakit' => $this->input->post('nama_penyakit'),
            'penyebab' => $this->input->post('penyebab'),
            'gejala' => $this->input->post('gejala'),
            'cara_pengendalian' => $this->input->post('cara_pengendalian')
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

        $penyakit = $this->Penyakit_model->get_by_id($id);
        if (!empty($_FILES['gambar_ilustrasi']['name'])) {
            if (!$this->upload->do_upload('gambar_ilustrasi')) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors('', '') . '</div>');
                redirect('admin/penyakit/ubah/' . $id);
                return;
            }
            if (!empty($penyakit['gambar_ilustrasi'])) {
                $file_path = $upload_path . $penyakit['gambar_ilustrasi'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $data['gambar_ilustrasi'] = $this->upload->data('file_name');
        }

        $ubah = $this->Penyakit_model->update($id, $data);
        if ($ubah) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Penyakit berhasil diubah!</div>');
            redirect('admin/penyakit');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengubah penyakit!</div>');
            redirect('admin/penyakit/ubah/' . $id);
        }
    }

    public function hapus_penyakit($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/penyakit');
        }

        $penyakit = $this->Penyakit_model->get_by_id($id);
        if ($penyakit) {
            $upload_path = FCPATH . $this->upload_path;
            if (!empty($penyakit['gambar_ilustrasi'])) {
                $file_path = $upload_path . $penyakit['gambar_ilustrasi'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $hapus = $this->Penyakit_model->delete($id);
            if ($hapus) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal di hapus</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan</div>');
        }
        redirect('admin/penyakit');
    }
}