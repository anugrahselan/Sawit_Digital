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

        $filters = [
            'kabupaten' => $this->input->get('kabupaten'),
            'perusahaan' => $this->input->get('perusahaan'),
            'date_from' => $this->input->get('date_from'),
            'date_to' => $this->input->get('date_to')
        ];

        $has_filter = !empty($filters['kabupaten']) || !empty($filters['perusahaan']) || !empty($filters['date_from']) || !empty($filters['date_to']);

        if (!$has_filter) {
            $tbs_prices = $this->Harga_tbs_model->get_harga_hari_ini();

            if (empty($tbs_prices)) {
                $tbs_prices = $this->Harga_tbs_model->get_harga_terbaru_per_perusahaan();
            }

            foreach ($tbs_prices as $price) {
                $current_date = date('Y-m-d', strtotime($price->tanggal));
                $previous = $this->Harga_tbs_model->get_harga_sebelumnya(
                    $price->id_kabupaten,
                    $price->id_perusahaan,
                    $current_date
                );

                if ($previous && isset($previous->harga_per_kg)) {
                    $current_price = floatval($price->harga_per_kg);
                    $previous_price = floatval($previous->harga_per_kg);
                    $change = $current_price - $previous_price;

                    if ($change > 0) {
                        $price->perubahan = $change;
                        $price->status_perubahan = 'naik';
                    } elseif ($change < 0) {
                        $price->perubahan = $change;
                        $price->status_perubahan = 'turun';
                    } else {
                        $price->perubahan = 0;
                        $price->status_perubahan = 'tidak_ada';
                    }
                    $price->harga_kemarin = $previous_price;
                } else {
                    $price->perubahan = null;
                    $price->status_perubahan = 'tidak_ada';
                    $price->harga_kemarin = null;
                }
            }

            $data['prices'] = $tbs_prices;
            $data['pagination_links'] = '';
        } else {
            $config['base_url'] = site_url('admin/harga_tbs');
            $config['total_rows'] = $this->Harga_tbs_model->count_all_filtered($filters);
            $config['per_page'] = 20;
            $config['uri_segment'] = 3;
            $config['reuse_query_string'] = TRUE;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['prices'] = $this->Harga_tbs_model->get_all_filtered($filters, $config['per_page'], $page);
            $data['pagination_links'] = $this->pagination->create_links();
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();
        $data['perusahaan_list'] = $this->Perusahaan_model->get_all();
        $data['filters'] = $filters;
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/harga_tbs/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function tambah_harga_tbs()
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk membuat data');
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

            if ($this->form_validation->run() == TRUE) {
                $data_insert = [
                    'id_kabupaten' => $this->input->post('id_kabupaten'),
                    'id_perusahaan' => $this->input->post('id_perusahaan'),
                    'tanggal' => $this->input->post('tanggal'),
                    'harga_per_kg' => $this->input->post('harga_per_kg')
                ];

                $existing = $this->Harga_tbs_model->get_by_date_and_company(
                    $data_insert['tanggal'],
                    $data_insert['id_perusahaan'],
                    null
                );

                if ($existing) {
                    $data['error'] = 'Harga untuk perusahaan ini pada tanggal tersebut sudah ada';
                } else {
                    if ($this->Harga_tbs_model->create($data_insert)) {
                        $this->session->set_flashdata('success', 'Harga TBS berhasil ditambahkan. Data lama tetap tersimpan untuk perbandingan harga.');
                        redirect('admin/harga_tbs');
                    } else {
                        $data['error'] = 'Gagal menambahkan harga TBS';
                    }
                }
            }
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();
        $data['perusahaan_list'] = $this->Perusahaan_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/harga_tbs/Tambah_harga_tbs', $data);
        $this->load->view('admin/templates/footer');
    }

    public function ubah_harga_tbs($id)
    {
        if (!$this->can_edit()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengubah data');
            redirect('admin/harga_tbs');
        }

        $price = $this->Harga_tbs_model->get_by_id($id);
        if (!$price) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/harga_tbs');
        }

        $data['page_title'] = 'Edit Harga TBS';
        $data['page_css'] = 'harga_tbs.css';
        $data['price'] = $price;
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

            if ($this->form_validation->run() == TRUE) {
                $data_update = [
                    'id_kabupaten' => $this->input->post('id_kabupaten'),
                    'id_perusahaan' => $this->input->post('id_perusahaan'),
                    'tanggal' => $this->input->post('tanggal'),
                    'harga_per_kg' => $this->input->post('harga_per_kg')
                ];

                $existing = $this->Harga_tbs_model->get_by_date_and_company(
                    $data_update['tanggal'],
                    $data_update['id_perusahaan'],
                    $id
                );

                if ($existing) {
                    $data['error'] = 'Harga untuk perusahaan ini pada tanggal tersebut sudah ada';
                } else {
                    if ($this->Harga_tbs_model->update($id, $data_update)) {
                        $this->session->set_flashdata('success', 'Harga TBS berhasil diupdate');
                        redirect('admin/harga_tbs');
                    } else {
                        $data['error'] = 'Gagal mengupdate harga TBS';
                    }
                }
            }
        }

        $data['kabupaten_list'] = $this->Kabupaten_model->get_all();
        $data['perusahaan_list'] = $this->Perusahaan_model->get_all();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/harga_tbs/ubah_harga_tbs', $data);
        $this->load->view('admin/templates/footer');
    }

    public function hapus_harga_tbs($id)
    {
        if (!$this->can_delete()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk menghapus data');
            redirect('admin/harga_tbs');
        }


        $price = $this->Harga_tbs_model->get_by_id($id);

        if ($price) {
            $user_id = $this->session->userdata('user_id');

            if ($this->Harga_tbs_model->delete($id, $user_id)) {
                $backup_exists = $this->db->table_exists('harga_tbs_backup');

                if ($backup_exists) {
                    $this->session->set_flashdata('success', 'Harga TBS berhasil dihapus. Data telah di-backup untuk perbandingan harga.');
                } else {
                    $this->session->set_flashdata('warning', 'Harga TBS berhasil dihapus. Catatan: Tabel backup belum dibuat. Buat tabel harga_tbs_backup di database untuk mengaktifkan fitur backup. Lihat dokumentasi BACKUP_SYSTEM.md untuk struktur tabel.');
                }
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus harga TBS');
            }
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
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


