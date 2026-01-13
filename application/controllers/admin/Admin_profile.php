<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_profile extends MY_Controller
{
    private $upload_path = 'assets/img/users/';

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Pengguna_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index()
    {
        $id_pengguna = $this->user_id;
        $pengguna = $this->Pengguna_model->get_by_id($id_pengguna);

        if (!$pengguna) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">User tidak ditemukan!</div>');
            redirect('admin/dashboard');
        }

        $data['page_title'] = 'Edit Profil - Admin';
        $data['page_css'] = 'profile.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Profil', 'url' => site_url('admin/profile')]
        ];
        $data['user'] = $pengguna;

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');
            
            $password = trim($this->input->post('password'));
            if (!empty($password)) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
                $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]', [
                    'matches' => 'Password tidak cocok'
                ]);
            }

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_profil($id_pengguna);
            }
        }

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/profile/index', $data);
        $this->load->view('admin/templates/footer');
    }

    private function _ubah_profil($id_pengguna)
    {
        $pengguna = $this->Pengguna_model->get_by_id($id_pengguna);
        $data_update = [
            'nama_lengkap' => trim($this->input->post('nama_lengkap')),
            'email' => trim($this->input->post('email')) ?: null,
            'username' => trim($this->input->post('username'))
        ];

        $pengguna_ada = $this->Pengguna_model->get_by_username($data_update['username']);
        if ($pengguna_ada && $pengguna_ada->id_user != $id_pengguna) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username sudah digunakan oleh user lain</div>');
            redirect('admin/profile');
            return;
        }

        if (!empty($data_update['email'])) {
            $email_ada = $this->Pengguna_model->get_by_email($data_update['email']);
            if ($email_ada && $email_ada->id_user != $id_pengguna) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email sudah digunakan oleh user lain</div>');
                redirect('admin/profile');
                return;
            }
        }

        $upload_path = FCPATH . $this->upload_path;
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $this->upload->initialize([
            'upload_path' => $upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 2048,
            'encrypt_name' => TRUE
        ]);

        if (!empty($_FILES['foto_profil']['name'])) {
            if (!$this->upload->do_upload('foto_profil')) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors('', '') . '</div>');
                redirect('admin/profile');
                return;
            }
            if (!empty($pengguna->foto_profil)) {
                $foto_lama = $pengguna->foto_profil;
                if (strpos($foto_lama, 'assets/img/users/') !== false) {
                    $foto_lama = basename($foto_lama);
                }
                $file_path = $upload_path . $foto_lama;
                if (file_exists($file_path) && $foto_lama != 'default.png') {
                    unlink($file_path);
                }
            }
            $data_update['foto_profil'] = $this->upload->data('file_name');
        }

        $password = trim($this->input->post('password'));
        $password_confirm = trim($this->input->post('password_confirm'));
        
        if (!empty($password)) {
            if (strlen($password) < 6) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password minimal 6 karakter</div>');
                redirect('admin/profile');
                return;
            }
            if ($password !== $password_confirm) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password dan konfirmasi password tidak cocok</div>');
                redirect('admin/profile');
                return;
            }
            $data_update['password'] = $password;
        }

        $ubah = $this->Pengguna_model->update($id_pengguna, $data_update);
        if ($ubah) {
            $pengguna_update = $this->Pengguna_model->get_by_id($id_pengguna);
            $this->session->set_userdata([
                'nama_lengkap' => $pengguna_update->nama_lengkap,
                'email' => $pengguna_update->email,
                'username' => $pengguna_update->username,
                'foto_profil' => isset($pengguna_update->foto_profil) ? $pengguna_update->foto_profil : ''
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profil berhasil diubah!</div>');
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal memperbarui profil. Silakan coba lagi.</div>');
            redirect('admin/profile');
        }
    }
}