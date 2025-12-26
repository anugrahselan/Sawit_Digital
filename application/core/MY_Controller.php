<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $user_role;
    protected $user_id;
    protected $user_name;
    
    public function __construct() {
        parent::__construct();
        $this->user_id = $this->session->userdata('user_id');
        $this->user_role = $this->session->userdata('user_role');
        $this->user_name = $this->session->userdata('user_name');
    }
    
    protected function require_login() {
        if (!$this->user_id) {
            redirect('admin/login');
        }
    }
    
    protected function require_role($allowed_roles = []) {
        $this->require_login();
        if (!in_array($this->user_role, $allowed_roles)) {
            $this->session->set_flashdata('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
            redirect('admin/dashboard');
        }
    }
    
    protected function require_admin() {
        $this->require_role(['admin']);
    }
    
    protected function require_admin_or_penyuluh() {
        $this->require_role(['admin', 'penyuluh']);
    }
    
    protected function can_edit() {
        return in_array($this->user_role, ['admin', 'penyuluh']);
    }
    
    protected function can_delete() {
        return $this->user_role === 'admin';
    }
}

