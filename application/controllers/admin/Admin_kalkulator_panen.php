<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_kalkulator_panen extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin_or_penyuluh();
        $this->load->database();
    }
    
    public function index() {
        $data['page_title'] = 'Kalkulasi Panen';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kalkulasi Panen', 'url' => site_url('admin/kalkulator_panen')]
        ];
        
        // Get data kalkulasi panen yang diinput user dengan join kabupaten dan perusahaan
        $this->db->select('kalkulasi_panen.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->from('kalkulasi_panen');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = kalkulasi_panen.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = kalkulasi_panen.id_perusahaan', 'left');
        
        // Order by id_kalkulasi DESC (data terbaru)
        // Jika kolom tanggal ada, gunakan tanggal, jika tidak gunakan id_kalkulasi
        $this->db->order_by('kalkulasi_panen.id_kalkulasi', 'DESC');
        
        $data['kalkulasi'] = $this->db->get()->result();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/kalkulator_panen/index', $data);
        $this->load->view('admin/layout/footer');
    }
}

