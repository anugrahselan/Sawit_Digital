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
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['page_title'] = 'Perusahaan';
        $data['page_css'] = 'perusahaan.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Perusahaan', 'url' => site_url('admin/perusahaan')]
        ];

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

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/perusahaan/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_perusahaan()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/perusahaan');
        }

        $data['page_title'] = 'Tambah Perusahaan';
        $data['page_css'] = 'perusahaan.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Perusahaan', 'url' => site_url('admin/perusahaan')],
            ['label' => 'Tambah', 'url' => site_url('admin/perusahaan/tambah_perusahaan')]
        ];

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $nama_perusahaan = $this->input->post('nama_perusahaan');
                $id_kabupaten = $this->input->post('id_kabupaten');

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
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Perusahaan berhasil ditambahkan!</div>');
                        redirect('admin/perusahaan');
                    } else {
                        $data['error'] = 'Gagal menambahkan perusahaan';
                    }
                }
            }
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/perusahaan/Tambah_perusahaan', $data);
        $this->load->view('admin/templates/footer');
    }

    public function ubah_perusahaan($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/perusahaan');
        }

        $perusahaan = $this->Perusahaan_model->get_by_id($id);
        if (!$perusahaan) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan</div>');
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

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $nama_perusahaan = $this->input->post('nama_perusahaan');
                $id_kabupaten = $this->input->post('id_kabupaten');

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
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Perusahaan berhasil diubah!</div>');
                        redirect('admin/perusahaan');
                    } else {
                        $data['error'] = 'Gagal mengupdate perusahaan';
                    }
                }
            }
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/perusahaan/ubah_perusahaan', $data);
        $this->load->view('admin/templates/footer');
    }

    public function hapus_perusahaan($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin</div>');
            redirect('admin/perusahaan');
        }

        if ($this->Perusahaan_model->delete($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal di hapus</div>');
        }

        redirect('admin/perusahaan');
    }
}




