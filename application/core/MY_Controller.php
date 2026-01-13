<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $user_role;
    protected $user_id;
    protected $user_name;
    
    public function __construct() {
        parent::__construct();
        $this->user_id = $this->session->userdata('id_user');
        $this->user_role = $this->session->userdata('role');
        $this->user_name = $this->session->userdata('nama_lengkap');
    }
    
    protected function require_login(): void {
        if (!$this->user_id) {
            redirect('masuk');
        }
    }
    
    protected function require_role($allowed_roles = []): void {
        $this->require_login();
        if (!in_array($this->user_role, $allowed_roles)) {
            $this->session->set_flashdata('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
            redirect('admin/dashboard');
        }
    }
    
    protected function require_admin(): void {
        $this->require_role(['admin']);
    }
    
    protected function can_edit(): bool {
        return $this->user_role === 'admin';
    }
    
    protected function can_delete(): bool {
        return $this->user_role === 'admin';
    }
}

