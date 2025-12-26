<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_tanah extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin_or_penyuluh();
        $this->load->database();
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data['page_title'] = 'Jenis Tanah';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Jenis Tanah', 'url' => site_url('admin/tanah')]
        ];
        
        $data['tanah'] = $this->db->get('jenis_tanah')->result();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/tanah/index', $data);
        $this->load->view('admin/layout/footer');
    }
}

