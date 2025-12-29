<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Harga_tbs_model');
        $this->load->model('Informasi_tambahan_model');
        $this->load->library('pagination');
    }

    public function index(): void {
        $data['page_title'] = 'Beranda - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/beranda.css';
        $data['page_js'] = 'user/beranda.js';

        $config['base_url'] = base_url('beranda');
        $config['total_rows'] = $this->Informasi_tambahan_model->count_all();
        $config['per_page'] = 6;
        $config['uri_segment'] = 2;
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['articles'] = $this->Informasi_tambahan_model->get_all($config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();

        // Ambil harga hari ini untuk semua perusahaan dan kabupaten
        $tbs_prices = $this->Harga_tbs_model->get_today_prices();
        
        // Jika tidak ada harga hari ini, ambil harga terbaru per perusahaan
        if (empty($tbs_prices)) {
            $tbs_prices = $this->Harga_tbs_model->get_latest_per_company();
        }
        
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
        
        $data['tbs_prices'] = $tbs_prices;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/beranda/index', $data);
        $this->load->view('user/templates/footer');
    }
}

