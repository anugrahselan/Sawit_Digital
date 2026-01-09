<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_kalkulator_pupuk extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }
    
    public function index(): void {
        $data['page_title'] = 'Kalkulasi Pupuk';
        $data['page_css'] = 'kalkulator_pupuk.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kalkulasi Pupuk', 'url' => site_url('admin/kalkulator_pupuk')]
        ];

        $this->db->select('kalkulasi_dosis_pupuk.*, jenis_pupuk.nama_pupuk, jenis_tanah.nama_tanah, users.username as user_username, users.nama_lengkap as user_nama');
        $this->db->from('kalkulasi_dosis_pupuk');
        $this->db->join('jenis_pupuk', 'jenis_pupuk.id_pupuk = kalkulasi_dosis_pupuk.id_pupuk', 'left');
        $this->db->join('jenis_tanah', 'jenis_tanah.id_tanah = kalkulasi_dosis_pupuk.id_tanah', 'left');
        $this->db->join('users', 'users.id_user = kalkulasi_dosis_pupuk.id_user', 'left');
        $this->db->order_by('kalkulasi_dosis_pupuk.id_kalkulasi', 'DESC');
        
        $data['dosis'] = $this->db->get()->result();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kalkulator_pupuk/index', $data);
        $this->load->view('admin/templates/footer');
    }
}


