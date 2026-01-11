<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_settings extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin();
    }
    
    public function index() {
        $data['page_title'] = 'Settings / Audit Log';
        $data['page_css'] = 'settings.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Settings', 'url' => site_url('admin/settings')]
        ];
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/settings/index', $data);
        $this->load->view('admin/templates/footer');
    }
}