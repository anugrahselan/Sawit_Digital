<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_penyakit extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin_or_penyuluh();
        $this->load->database();
    }
    
    public function index() {
        $data['page_title'] = 'Penyakit';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Penyakit', 'url' => site_url('admin/penyakit')]
        ];
        
        $data['penyakit'] = $this->db->get('jenis_penyakit')->result();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/penyakit/index', $data);
        $this->load->view('admin/layout/footer');
    }
}

