<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_informasi extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin_or_penyuluh();
        $this->load->model('Informasi_tambahan_model');
    }
    
    public function index() {
        $data['page_title'] = 'Informasi (Artikel)';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Informasi', 'url' => site_url('admin/informasi')]
        ];
        
        $data['articles'] = $this->Informasi_tambahan_model->get_all();
        $data['can_edit'] = $this->can_edit();
        $data['can_delete'] = $this->can_delete();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/informasi/index', $data);
        $this->load->view('admin/layout/footer');
    }
}

