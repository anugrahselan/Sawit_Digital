<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengguna_model');
        $this->load->library('form_validation');
    }

    public function login()
    {
        if ($this->session->userdata('id_user')) {
            $role = $this->session->userdata('role');
            if ($role === 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('beranda');
            }
        }

        $data['page_title'] = 'Login - Sistem Penyuluhan Sawit';
        $data['error'] = $this->session->flashdata('message') ?: '';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username/Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $this->_proses_login();
            } else {
                $data['error'] = validation_errors('', '');
            }
        }

        $this->load->view('auth/login', $data);
    }

    private function _proses_login()
    {
        $username_or_email = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));
        $user = $this->Pengguna_model->login($username_or_email, $password);

        if ($user) {
            $this->session->set_userdata([
                'id_user' => $user->id_user,
                'username' => $user->username,
                'role' => $user->role,
                'nama_lengkap' => $user->nama_lengkap,
                'email' => $user->email,
                'foto_profil' => isset($user->foto_profil) ? $user->foto_profil : ''
            ]);

            if ($user->role === 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('beranda');
            }
        } else {
            $this->session->set_flashdata('message', 'Username/Email atau password salah');
            redirect('login');
        }
    }

    public function register()
    {
        if ($this->session->userdata('id_user')) {
            $role = $this->session->userdata('role');
            if ($role === 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('beranda');
            }
        }

        $data['page_title'] = 'Daftar - Sistem Penyuluhan Sawit';
        $data['register_error'] = '';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[50]|is_unique[users.username]', [
                'is_unique' => 'Username sudah digunakan'
            ]);
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim|min_length[3]|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|max_length[100]|is_unique[users.email]', [
                'is_unique' => 'Email sudah digunakan'
            ]);
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]', [
                'min_length' => 'Password minimal 8 karakter'
            ]);
            $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]', [
                'matches' => 'Password tidak cocok'
            ]);

            if ($this->form_validation->run() !== FALSE) {
                $this->_proses_register();
            } else {
                $data['register_error'] = validation_errors('', '');
            }
        }

        $this->load->view('auth/login', $data);
    }

    private function _proses_register()
    {
        $user_data = [
            'username' => trim($this->input->post('username')),
            'nama_lengkap' => trim($this->input->post('nama_lengkap')),
            'email' => trim($this->input->post('email')) ?: null,
            'password' => trim($this->input->post('password')),
            'role' => 'user'
        ];

        $user_id = $this->Pengguna_model->create($user_data);
        if ($user_id) {
            $user = $this->Pengguna_model->get_by_id($user_id);
            if ($user) {
                $this->session->set_userdata([
                    'id_user' => $user->id_user,
                    'username' => $user->username,
                    'role' => $user->role,
                    'nama_lengkap' => $user->nama_lengkap,
                    'email' => $user->email,
                    'foto_profil' => isset($user->foto_profil) ? $user->foto_profil : ''
                ]);

                redirect('beranda');
            }
        } else {
            $this->session->set_flashdata('message', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
            redirect('register');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('beranda');
    }
}
