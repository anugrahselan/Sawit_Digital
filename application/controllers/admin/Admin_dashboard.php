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
        // Menggunakan logika yang sama seperti di halaman beranda user
        // Ambil harga hari ini untuk semua perusahaan dan kabupaten
        $tbs_prices = $this->Harga_tbs_model->get_today_prices();

        // Jika tidak ada harga hari ini, ambil harga terbaru per perusahaan
        if (empty($tbs_prices)) {
            $tbs_prices = $this->Harga_tbs_model->get_latest_per_company();
        }

        // Limit untuk dashboard (ambil 10 terbaru)
        $tbs_prices = array_slice($tbs_prices, 0, 10);

        // Bandingkan dengan harga sebelumnya untuk setiap harga
        // Sistem akan mencari data kemarin, jika tidak ada akan mencari data terakhir yang tersedia
        foreach ($tbs_prices as $price) {
            // Pastikan format tanggal konsisten
            $current_date = date('Y-m-d', strtotime($price->tanggal));

            // Cari harga sebelumnya (prioritas: kemarin, jika tidak ada ambil data terakhir yang tersedia)
            // Ini memungkinkan sistem tetap bekerja meskipun data lama sudah dihapus
            $previous = $this->Harga_tbs_model->get_previous_price(
                $price->id_kabupaten,
                $price->id_perusahaan,
                $current_date
            );

            if ($previous && isset($previous->harga_per_kg)) {
                // Hitung perubahan dari harga sebelumnya ke harga hari ini
                $current_price = floatval($price->harga_per_kg);
                $previous_price = floatval($previous->harga_per_kg);
                $change = $current_price - $previous_price;

                // Tentukan status berdasarkan perubahan
                if ($change > 0) {
                    // Harga naik
                    $price->perubahan = $change;
                    $price->status_perubahan = 'naik';
                } elseif ($change < 0) {
                    // Harga turun
                    $price->perubahan = $change;
                    $price->status_perubahan = 'turun';
                } else {
                    // Harga sama (tidak ada perubahan)
                    $price->perubahan = 0;
                    $price->status_perubahan = 'tidak_ada';
                }
                $price->harga_kemarin = $previous_price;
            } else {
                // Tidak ada data sebelumnya sama sekali (data pertama atau semua data lama sudah dihapus)
                // Tampilkan "-" untuk menunjukkan tidak ada perbandingan
                $price->perubahan = null;
                $price->status_perubahan = 'tidak_ada';
                $price->harga_kemarin = null;
            }
        }

        return $tbs_prices;
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
