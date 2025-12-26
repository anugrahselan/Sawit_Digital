<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_users extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Pengguna_model');
    }
    
    public function index() {
        $data['page_title'] = 'Users & Roles';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Users & Roles', 'url' => site_url('admin/users')]
        ];
        
        $data['users'] = $this->db->get('users')->result();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('admin/layout/footer');
    }
}

