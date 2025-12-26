<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_auth extends CI_Controller
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
            $role = $this->session->userdata('user_role');
            redirect(in_array($role, ['admin', 'penyuluh']) ? 'admin/dashboard' : 'beranda');
        }

        $data['page_title'] = 'Admin Login - Sistem Penyuluhan Sawit';
        $data['error'] = '';

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $email = trim($this->input->post('email'));
                $password = trim($this->input->post('password'));
                $user = $this->Pengguna_model->get_by_email($email);

                if (!$user) {
                    $data['error'] = 'Email tidak ditemukan';
                } elseif (empty($user->password)) {
                    $data['error'] = 'Password tidak ditemukan di database';
                } else {
                    $password_valid = false;
                    $db_password = trim($user->password);

                    if (strlen($db_password) === 60 && password_verify($password, $db_password)) {
                        $password_valid = true;
                    } elseif ($db_password === $password) {
                        $password_valid = true;
                        $this->Pengguna_model->update($user->id_user, ['password' => $password]);
                    }

                    if (!$password_valid) {
                        $data['error'] = 'Password salah. Pastikan password yang Anda masukkan benar.';
                    } elseif (!in_array($user->role, ['admin', 'penyuluh'])) {
                        $data['error'] = 'Anda tidak memiliki akses admin. Role Anda: ' . ($user->role ?: 'tidak ada');
                    } else {
                        $this->session->set_userdata([
                            'user_id' => $user->id_user,
                            'user_name' => $user->nama_lengkap,
                            'user_email' => $user->email,
                            'user_role' => $user->role,
                            'foto_profil' => isset($user->foto_profil) ? $user->foto_profil : ''
                        ]);
                        redirect('admin/dashboard');
                    }
                }
            } else {
                $data['error'] = validation_errors('', '');
            }
        }

        $this->load->view('admin/auth/login', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('beranda');
    }
}


