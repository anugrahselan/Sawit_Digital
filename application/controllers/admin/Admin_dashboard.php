<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();

        $this->load->model('Harga_tbs_model');
        $this->load->model('Kabupaten_model');
        $this->load->model('Pengguna_model');
        $this->load->model('Perusahaan_model');
    }

    public function index(): void
    {
        $data['page_title'] = 'Dashboard Admin';
        $data['page_css'] = 'dashboard.css';

        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')]
        ];
        $data['total_perusahaan'] = $this->get_total_perusahaan();
        $data['total_kabupaten'] = $this->get_total_kabupaten();
        $data['total_users'] = $this->get_total_users();
        $data['total_kalkulasi_panen'] = $this->get_total_kalkulasi_panen();
        $data['total_kalkulasi_pupuk'] = $this->get_total_kalkulasi_pupuk();
        $data['total_kalkulasi'] = $data['total_kalkulasi_panen'] + $data['total_kalkulasi_pupuk'];
        $data['avg_harga_tbs'] = $this->get_avg_harga_tbs();
        $data['total_jenis_pupuk'] = $this->get_total_jenis_pupuk();
        $data['total_penyakit'] = $this->get_total_penyakit();

        $data['tbs_prices'] = $this->get_tbs_prices_with_changes();
        $data['weekly_trends'] = $this->get_weekly_trends();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/templates/footer');
    }

    private function get_total_perusahaan(): int
    {
        if ($this->db->table_exists('perusahaan')) {
            return $this->db->count_all('perusahaan');
        }
        return 0;
    }

    private function get_total_kabupaten(): int
    {
        return $this->db->count_all('kabupaten');
    }

    private function get_total_users(): int
    {
        return $this->db->count_all('users');
    }

    private function get_total_kalkulasi_panen(): int
    {
        if ($this->db->table_exists('kalkulasi_panen')) {
            return $this->db->count_all('kalkulasi_panen');
        }
        return 0;
    }

    private function get_total_kalkulasi_pupuk(): int
    {
        if ($this->db->table_exists('kalkulasi_dosis_pupuk')) {
            return $this->db->count_all('kalkulasi_dosis_pupuk');
        }
        return 0;
    }

    private function get_avg_harga_tbs(): float
    {
        $this->db->select('AVG(harga_per_kg) as avg_harga_per_kg');
        $result = $this->db->get('harga_tbs')->row();
        return $result ? (float) $result->avg_harga_per_kg : 0;
    }

    private function get_total_jenis_pupuk(): int
    {
        if ($this->db->table_exists('jenis_pupuk')) {
            return $this->db->count_all('jenis_pupuk');
        }
        return 0;
    }

    private function get_total_penyakit(): int
    {
        if ($this->db->table_exists('jenis_penyakit')) {
            return $this->db->count_all('jenis_penyakit');
        }
        return 0;
    }

    private function get_tbs_prices_with_changes(): array
    {
        $this->db->select('harga_tbs.*, perusahaan.nama_perusahaan, kabupaten.nama_kabupaten');
        $this->db->from('harga_tbs');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');
        $this->db->limit(10);
        $prices = $this->db->get()->result();

        foreach ($prices as $price) {
            $previous = $this->Harga_tbs_model->get_previous_price(
                $price->id_kabupaten,
                $price->id_perusahaan,
                $price->tanggal
            );

            if ($previous) {
                $delta = $price->harga_per_kg - $previous->harga_per_kg;
                $price->perubahan = $delta;
                if ($delta > 0) {
                    $price->status_perubahan = 'naik';
                } elseif ($delta < 0) {
                    $price->status_perubahan = 'turun';
                } else {
                    $price->status_perubahan = 'tidak_ada';
                }
            } else {
                $price->perubahan = 0;
                $price->status_perubahan = 'tidak_ada';
            }
        }

        return $prices;
    }

    private function get_weekly_trends(): array
    {
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 days'));

        $this->db->select('DATE(tanggal) as date, AVG(harga_per_kg) as avg_price, COUNT(*) as count');
        $this->db->from('harga_tbs');
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->group_by('DATE(tanggal)');
        $this->db->order_by('date', 'ASC');

        return $this->db->get()->result();
    }
}
