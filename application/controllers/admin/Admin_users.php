<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_users extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Pengguna_model');
    }

    public function index()
    {
        $data['page_title'] = 'Users & Roles';
        $data['page_css'] = 'users.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Users & Roles', 'url' => site_url('admin/users')]
        ];

        $sql = "SELECT * FROM users ORDER BY id_user DESC";
        $data['users'] = $this->db->query($sql)->result();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('admin/templates/footer');
    }
}