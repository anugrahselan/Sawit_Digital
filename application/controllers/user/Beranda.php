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

        if (empty($config['total_rows'])) {
            $config['total_rows'] = 0;
        }

        $page_segment = $this->uri->segment(2);
        $config['cur_page'] = ($page_segment && is_numeric($page_segment)) ? (int) $page_segment : 0;
        
        $this->pagination->initialize($config);

        $page = ($page_segment !== false && $page_segment !== null && is_numeric($page_segment)) ? (int) $page_segment : 0;
        
        $data['articles'] = $this->Informasi_tambahan_model->get_all($config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();

        $tbs_prices = $this->Harga_tbs_model->get_today_prices();

        if (empty($tbs_prices)) {
            $tbs_prices = $this->Harga_tbs_model->get_latest_per_company();
        }
        
        foreach ($tbs_prices as $price) {
            $current_date = date('Y-m-d', strtotime($price->tanggal));

            $previous = $this->Harga_tbs_model->get_previous_price(
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
        
        $data['tbs_prices'] = $tbs_prices;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/beranda/index', $data);
        $this->load->view('user/templates/footer');
    }
}
