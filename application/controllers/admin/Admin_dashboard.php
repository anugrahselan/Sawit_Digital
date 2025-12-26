<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin_or_penyuluh();
        
        $this->load->model('Harga_tbs_model');
        $this->load->model('Kabupaten_model');
        $this->load->model('Pengguna_model');
        
        $this->load->model('Perusahaan_model');
    }
    
    public function index() {
        $data['page_title'] = 'Dashboard Admin';
        $data['page_css'] = 'admin/dashboard.css';
        $data['page_js'] = 'admin/dashboard.js';
        
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')]
        ];
        $data['total_perusahaan'] = $this->get_total_perusahaan();
        $data['total_kabupaten'] = $this->get_total_kabupaten();
        $data['total_harga_tbs'] = $this->get_total_harga_tbs();
        $data['total_users'] = $this->get_total_users();
        
        $data['tbs_prices'] = $this->get_tbs_prices_with_changes();
        $data['weekly_trends'] = $this->get_weekly_trends();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layout/footer');
    }
    
    private function get_total_perusahaan() {
        if ($this->db->table_exists('perusahaan')) {
            return $this->db->count_all('perusahaan');
        }
        return 0;
    }
    
    private function get_total_kabupaten() {
        return $this->db->count_all('kabupaten');
    }
    
    private function get_total_harga_tbs() {
        return $this->db->count_all('harga_tbs');
    }
    
    private function get_total_users() {
        return $this->db->count_all('users');
    }
    
    private function get_tbs_prices_with_changes() {
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
    
    private function get_weekly_trends() {
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


