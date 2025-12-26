<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_settings extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->require_admin();
    }
    
    public function index() {
        $data['page_title'] = 'Settings / Audit Log';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Settings', 'url' => site_url('admin/settings')]
        ];
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/index', $data);
        $this->load->view('admin/layout/footer');
    }
}