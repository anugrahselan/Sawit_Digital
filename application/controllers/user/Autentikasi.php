<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autentikasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengguna_model');
        $this->load->library('form_validation');
    }

    public function login()
    {
        if ($this->session->userdata('user_id')) {
            // Redirect berdasarkan role yang sudah login
            $role = $this->session->userdata('user_role');
            if (in_array($role, ['admin', 'penyuluh'])) {
                redirect('admin/dashboard');
            } else {
                redirect('beranda');
            }
        }

        $data['page_title'] = 'Masuk - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/autentikasi.css';

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $user = $this->Pengguna_model->verify($this->input->post('email'), $this->input->post('password'));
                if ($user) {
                    $this->session->set_userdata([
                        'user_id' => $user->id_user,
                        'user_name' => $user->nama_lengkap,
                        'user_email' => $user->email,
                        'user_role' => $user->role,
                        'foto_profil' => $user->foto_profil
                    ]);
                    
                    // Redirect berdasarkan role
                    if (in_array($user->role, ['admin', 'penyuluh'])) {
                        // Jika admin/penyuluh, redirect ke admin dashboard
                        redirect('admin/dashboard');
                    } else {
                        // Jika user biasa, redirect ke beranda
                        redirect('beranda');
                    }
                } else {
                    $data['error'] = 'Email atau password salah';
                }
            }
        }

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/autentikasi/masuk', $data);
        $this->load->view('user/templates/footer');
    }

    public function register()
    {
        if ($this->session->userdata('user_id')) {
            redirect('beranda');
        }

        $data['page_title'] = 'Daftar - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/autentikasi.css';

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|min_length[3]');
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');

            if ($this->form_validation->run() == TRUE) {
                $user_data = [
                    'nama_lengkap' => $this->input->post('nama_lengkap'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'role' => 'user'
                ];

                $user_id = $this->Pengguna_model->create($user_data);
                if ($user_id) {
                    $user = $this->Pengguna_model->get_by_id($user_id);
                    $this->session->set_userdata([
                        'user_id' => $user->id_user,
                        'user_name' => $user->nama_lengkap,
                        'user_email' => $user->email,
                        'user_role' => $user->role,
                        'foto_profil' => $user->foto_profil
                    ]);
                    
                    // Redirect berdasarkan role (register selalu user, jadi ke beranda)
                    redirect('beranda');
                } else {
                    $data['error'] = 'Terjadi kesalahan saat mendaftar';
                }
            }
        }

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/autentikasi/daftar', $data);
        $this->load->view('user/templates/footer');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('beranda');
    }
}

