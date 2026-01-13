<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_harga_tbs extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();

        $this->load->model('Harga_tbs_model');
        $this->load->model('Kabupaten_model');
        $this->load->model('Perusahaan_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['page_title'] = 'Harga TBS';
        $data['page_css'] = 'harga_tbs.css';

        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Harga TBS', 'url' => site_url('admin/harga_tbs')]
        ];

        $filter = [
            'kabupaten' => $this->input->get('kabupaten'),
            'perusahaan' => $this->input->get('perusahaan'),
            'date_from' => $this->input->get('date_from'),
            'date_to' => $this->input->get('date_to')
        ];

        $ada_filter = !empty($filter['kabupaten']) || !empty($filter['perusahaan']) || !empty($filter['date_from']) || !empty($filter['date_to']);

        if (!$ada_filter) {
            $daftar_harga_tbs = $this->Harga_tbs_model->get_harga_hari_ini();

            if (empty($daftar_harga_tbs)) {
                $daftar_harga_tbs = $this->Harga_tbs_model->get_terbaru_per_perusahaan();
            }

            foreach ($daftar_harga_tbs as $harga) {
                $tanggal_sekarang = date('Y-m-d', strtotime($harga->tanggal));
                $harga_sebelumnya = $this->Harga_tbs_model->get_harga_sebelumnya(
                    $harga->id_kabupaten,
                    $harga->id_perusahaan,
                    $tanggal_sekarang
                );

                if ($harga_sebelumnya && isset($harga_sebelumnya->harga_per_kg)) {
                    $harga_sekarang = floatval($harga->harga_per_kg);
                    $harga_kemarin = floatval($harga_sebelumnya->harga_per_kg);
                    $selisih = $harga_sekarang - $harga_kemarin;

                    if ($selisih > 0) {
                        $harga->perubahan = $selisih;
                        $harga->status_perubahan = 'naik';
                    } elseif ($selisih < 0) {
                        $harga->perubahan = $selisih;
                        $harga->status_perubahan = 'turun';
                    } else {
                        $harga->perubahan = 0;
                        $harga->status_perubahan = 'tidak_ada';
                    }
                    $harga->harga_kemarin = $harga_kemarin;
                } else {
                    $harga->perubahan = null;
                    $harga->status_perubahan = 'tidak_ada';
                    $harga->harga_kemarin = null;
                }
            }

            $data['prices'] = $daftar_harga_tbs;
            $data['pagination_links'] = '';
        } else {
            $config['base_url'] = site_url('admin/harga_tbs');
            $config['total_rows'] = $this->Harga_tbs_model->hitung_semua_terfilter($filter);
            $config['per_page'] = 20;
            $config['uri_segment'] = 3;
            $config['reuse_query_string'] = TRUE;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['prices'] = $this->Harga_tbs_model->get_semua_terfilter($filter, $config['per_page'], $page);
            $data['pagination_links'] = $this->pagination->create_links();
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();
        $data['perusahaan_list'] = $this->Perusahaan_model->get_all();
        $data['filters'] = $filter;
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/harga_tbs/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_harga_tbs()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin untuk membuat data</div>');
            redirect('admin/harga_tbs');
        }

        $data['page_title'] = 'Tambah Harga TBS';
        $data['page_css'] = 'harga_tbs.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Harga TBS', 'url' => site_url('admin/harga_tbs')],
            ['label' => 'Tambah', 'url' => site_url('admin/harga_tbs/tambah_harga_tbs')]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');
            $this->form_validation->set_rules('id_perusahaan', 'Perusahaan', 'required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
            $this->form_validation->set_rules('harga_per_kg', 'Harga per Kg', 'required|numeric');

            if ($this->form_validation->run() !== FALSE) {
                $this->_simpan_harga_tbs();
            }
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();
        $data['perusahaan_list'] = $this->Perusahaan_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/harga_tbs/Tambah_harga_tbs', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _simpan_harga_tbs()
    {
        $data = [
            'id_kabupaten' => $this->input->post('id_kabupaten'),
            'id_perusahaan' => $this->input->post('id_perusahaan'),
            'tanggal' => $this->input->post('tanggal'),
            'harga_per_kg' => $this->input->post('harga_per_kg')
        ];

        $data_ada = $this->Harga_tbs_model->get_by_tanggal_dan_perusahaan(
            $data['tanggal'],
            $data['id_perusahaan'],
            null
        );

        if ($data_ada) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Harga untuk perusahaan ini pada tanggal tersebut sudah ada</div>');
            redirect('admin/harga_tbs/tambah');
            return;
        }

        $simpan = $this->Harga_tbs_model->create($data);
        if ($simpan) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Harga TBS berhasil ditambahkan!</div>');
            redirect('admin/harga_tbs');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan harga TBS!</div>');
            redirect('admin/harga_tbs/tambah');
        }
    }

    public function ubah_harga_tbs($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin untuk mengubah data</div>');
            redirect('admin/harga_tbs');
        }

        $harga = $this->Harga_tbs_model->get_by_id($id);
        if (!$harga) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data harga TBS tidak ditemukan!</div>');
            redirect('admin/harga_tbs');
        }

        $data['page_title'] = 'Edit Harga TBS';
        $data['page_css'] = 'harga_tbs.css';
        $data['price'] = $harga;
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Harga TBS', 'url' => site_url('admin/harga_tbs')],
            ['label' => 'Edit', 'url' => site_url('admin/harga_tbs/ubah_harga_tbs/' . $id)]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'required');
            $this->form_validation->set_rules('id_perusahaan', 'Perusahaan', 'required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
            $this->form_validation->set_rules('harga_per_kg', 'Harga per Kg', 'required|numeric');

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_harga_tbs($id);
            }
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();
        $data['perusahaan_list'] = $this->Perusahaan_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/harga_tbs/ubah_harga_tbs', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _ubah_harga_tbs($id)
    {
        $data = [
            'id_kabupaten' => $this->input->post('id_kabupaten'),
            'id_perusahaan' => $this->input->post('id_perusahaan'),
            'tanggal' => $this->input->post('tanggal'),
            'harga_per_kg' => $this->input->post('harga_per_kg')
        ];

        $data_ada = $this->Harga_tbs_model->get_by_tanggal_dan_perusahaan(
            $data['tanggal'],
            $data['id_perusahaan'],
            $id
        );

        if ($data_ada) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Harga untuk perusahaan ini pada tanggal tersebut sudah ada</div>');
            redirect('admin/harga_tbs/ubah/' . $id);
            return;
        }

        $ubah = $this->Harga_tbs_model->update($id, $data);
        if ($ubah) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Harga TBS berhasil diubah!</div>');
            redirect('admin/harga_tbs');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengubah harga TBS!</div>');
            redirect('admin/harga_tbs/ubah/' . $id);
        }
    }

    public function hapus_harga_tbs($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak memiliki izin untuk menghapus data</div>');
            redirect('admin/harga_tbs');
        }


        $harga = $this->Harga_tbs_model->get_by_id($id);

        if ($harga) {
            $id_pengguna = $this->session->userdata('id_user');

            $hapus = $this->Harga_tbs_model->delete($id, $id_pengguna);
            if ($hapus) {
                $backup_exists = $this->db->table_exists('harga_tbs_backup');

                if ($backup_exists) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Berhasil di hapus. Catatan: Tabel backup belum dibuat.</div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal di hapus</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan</div>');
        }

        redirect('admin/harga_tbs');
    }

    public function get_perusahaan_by_kabupaten()
    {
        $id_kabupaten = $this->input->get('id_kabupaten');

        if (!$id_kabupaten) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'ID Kabupaten tidak valid']));
            return;
        }

        $perusahaan = $this->Perusahaan_model->get_by_kabupaten($id_kabupaten);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $perusahaan]));
    }
}


