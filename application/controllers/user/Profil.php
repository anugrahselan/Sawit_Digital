<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengguna_model');
        $this->load->library('form_validation');
        
        if (!$this->session->userdata('user_id') && !$this->session->userdata('id_user')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Silakan login terlebih dahulu</div>');
            redirect('masuk');
        }
    }

    public function index()
    {
        $id_pengguna = $this->session->userdata('user_id') ?: $this->session->userdata('id_user');
        $pengguna = $this->Pengguna_model->get_by_id($id_pengguna);

        if (!$pengguna) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Pengguna tidak ditemukan!</div>');
            redirect('beranda');
        }

        $data = [
            'page_title' => 'Edit Profil - Sistem Penyuluhan Sawit',
            'page_css' => 'user/profil.css',
            'user' => $pengguna
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');

            if ($this->form_validation->run() !== FALSE) {
                $this->_ubah_profil($id_pengguna);
            }
        }

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/profil/edit', $data);
        $this->load->view('user/templates/footer');
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
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username sudah digunakan oleh pengguna lain</div>');
            redirect('profil');
            return;
        }

        if (!empty($data_update['email'])) {
            $email_ada = $this->Pengguna_model->get_by_email($data_update['email']);
            if ($email_ada && $email_ada->id_user != $id_pengguna) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email sudah digunakan oleh pengguna lain</div>');
                redirect('profil');
                return;
            }
        }

        $ada_file = isset($_FILES['foto_profil']) 
            && !empty($_FILES['foto_profil']['name']) 
            && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK
            && is_uploaded_file($_FILES['foto_profil']['tmp_name']);

        if ($ada_file) {
            $hasil_upload = $this->upload_foto_profil();
            if ($hasil_upload['success']) {
                if (!empty($pengguna->foto_profil)) {
                    $foto_lama = $pengguna->foto_profil;
                    if (strpos($foto_lama, 'assets/img/users/') !== false) {
                        $foto_lama = basename($foto_lama);
                    }
                    $file_lama = FCPATH . 'assets/img/users/' . $foto_lama;
                    if (file_exists($file_lama) && $foto_lama != 'default.png') {
                        @unlink($file_lama);
                    }
                }
                $data_update['foto_profil'] = $hasil_upload['file_name'];
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $hasil_upload['error'] . '</div>');
                redirect('profil');
                return;
            }
        }

        $password = trim($this->input->post('password'));
        if (!empty($password)) {
            $data_update['password'] = $password;
        }

        $ubah = $this->Pengguna_model->update($id_pengguna, $data_update);
        if ($ubah) {
            $pengguna_update = $this->Pengguna_model->get_by_id($id_pengguna);
            $this->session->set_userdata([
                'nama_lengkap' => $pengguna_update->nama_lengkap,
                'user_name' => $pengguna_update->nama_lengkap,
                'email' => $pengguna_update->email,
                'username' => $pengguna_update->username,
                'foto_profil' => isset($pengguna_update->foto_profil) ? $pengguna_update->foto_profil : ''
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profil berhasil diubah!</div>');
            redirect('beranda');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal memperbarui profil. Silakan coba lagi.</div>');
            redirect('profil');
        }
    }

    private function upload_foto_profil(): array
    {
        if (!isset($_FILES['foto_profil'])) {
            return ['success' => false, 'error' => 'Field file tidak ditemukan'];
        }

        $file = $_FILES['foto_profil'];

        if (empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
            if ($file['error'] === UPLOAD_ERR_NO_FILE) {
                return ['success' => false, 'error' => 'Tidak ada file yang diupload'];
            }
            return ['success' => false, 'error' => 'Error saat upload file: ' . $file['error']];
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'error' => 'File tidak valid atau tidak diupload dengan benar'];
        }

        $path_upload = FCPATH . 'assets/img/users/';
        if (!is_dir($path_upload)) {
            mkdir($path_upload, 0755, true);
        }

        $ekstensi_file = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($ekstensi_file, $ekstensi_diizinkan)) {
            return ['success' => false, 'error' => 'Format file tidak didukung. Format yang diizinkan: JPG, JPEG, PNG, GIF, WEBP'];
        }

        $info_gambar = @getimagesize($file['tmp_name']);
        if ($info_gambar === FALSE) {
            return ['success' => false, 'error' => 'File yang diupload bukan gambar valid'];
        }

        $ukuran_maksimal = 2048 * 1024;
        if ($file['size'] > $ukuran_maksimal) {
            return ['success' => false, 'error' => 'Ukuran file terlalu besar. Maksimal 2MB'];
        }

        $nama_file = 'user_' . time() . '_' . uniqid() . '.' . $ekstensi_file;

        if (move_uploaded_file($file['tmp_name'], $path_upload . $nama_file)) {
            return ['success' => true, 'file_name' => $nama_file];
        } else {
            return ['success' => false, 'error' => 'Gagal mengupload file'];
        }
    }
}