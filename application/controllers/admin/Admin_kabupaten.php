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
        $this->load->library('pagination');
    }

    public function index(): void
    {
        $data['page_title'] = 'Kabupaten';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kabupaten', 'url' => site_url('admin/kabupaten')]
        ];

        // Pagination
        $config['base_url'] = site_url('admin/kabupaten');
        $config['total_rows'] = $this->db->count_all('kabupaten');
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->db->limit($config['per_page'], $page);
        $data['kabupaten'] = $this->Kabupaten_model->get_all();
        $data['pagination_links'] = $this->pagination->create_links();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kabupaten/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_kabupaten(): void
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/kabupaten');
        }

        $data['page_title'] = 'Tambah Kabupaten';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kabupaten', 'url' => site_url('admin/kabupaten')],
            ['label' => 'Tambah', 'url' => site_url('admin/kabupaten/tambah_kabupaten')]
        ];

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_kabupaten', 'Nama Kabupaten', 'required|is_unique[kabupaten.nama_kabupaten]');

            if ($this->form_validation->run() == TRUE) {
                $data_insert = [
                    'nama_kabupaten' => $this->input->post('nama_kabupaten')
                ];

                if ($this->Kabupaten_model->create($data_insert)) {
                    $this->session->set_flashdata('success', 'Kabupaten berhasil ditambahkan');
                    redirect('admin/kabupaten');
                } else {
                    $data['error'] = 'Gagal menambahkan kabupaten';
                }
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kabupaten/Tambah_kabupaten', $data);
        $this->load->view('admin/templates/footer');
    }

    public function ubah_kabupaten($id): void
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/kabupaten');
        }

        $kabupaten = $this->Kabupaten_model->get_by_id($id);
        if (!$kabupaten) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/kabupaten');
        }

        $data['page_title'] = 'Edit Kabupaten';
        $data['kabupaten'] = $kabupaten;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kabupaten', 'url' => site_url('admin/kabupaten')],
            ['label' => 'Edit', 'url' => site_url('admin/kabupaten/ubah_kabupaten/' . $id)]
        ];

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_kabupaten', 'Nama Kabupaten', 'required');

            if ($this->form_validation->run() == TRUE) {
                $nama_kabupaten = $this->input->post('nama_kabupaten');

                // Check unique nama_kabupaten
                if ($this->Kabupaten_model->nama_exists($nama_kabupaten, $id)) {
                    $data['error'] = 'Nama kabupaten sudah ada';
                } else {
                    $data_update = [
                        'nama_kabupaten' => $nama_kabupaten
                    ];

                    if ($this->Kabupaten_model->update($id, $data_update)) {
                        $this->session->set_flashdata('success', 'Kabupaten berhasil diupdate');
                        redirect('admin/kabupaten');
                    } else {
                        $data['error'] = 'Gagal mengupdate kabupaten';
                    }
                }
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kabupaten/ubah_kabupaten', $data);
        $this->load->view('admin/templates/footer');
    }

    public function hapus_kabupaten($id): void
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin');
            redirect('admin/kabupaten');
        }

        if ($this->Kabupaten_model->delete($id)) {
            $this->session->set_flashdata('success', 'Kabupaten berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kabupaten');
        }

        redirect('admin/kabupaten');
    }
}




