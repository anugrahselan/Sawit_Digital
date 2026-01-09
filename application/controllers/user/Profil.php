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
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('masuk');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id') ?: $this->session->userdata('id_user');
        $user = $this->Pengguna_model->get_by_id($user_id);

        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan');
            redirect('beranda');
        }

        $data = [
            'page_title' => 'Edit Profil - Sistem Penyuluhan Sawit',
            'page_css' => 'user/profil.css',
            'user' => $user
        ];

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');

            if ($this->form_validation->run() !== FALSE) {
                $update_data = [
                    'nama_lengkap' => trim($this->input->post('nama_lengkap')),
                    'email' => trim($this->input->post('email')) ?: null,
                    'username' => trim($this->input->post('username'))
                ];

                $existing_user = $this->Pengguna_model->get_by_username($update_data['username']);
                if ($existing_user && $existing_user->id_user != $user_id) {
                    $data['error'] = 'Username sudah digunakan oleh user lain';
                } else {
                    if (!empty($update_data['email'])) {
                        $existing_email = $this->Pengguna_model->get_by_email($update_data['email']);
                        if ($existing_email && $existing_email->id_user != $user_id) {
                            $data['error'] = 'Email sudah digunakan oleh user lain';
                        }
                    }

                    if (!isset($data['error'])) {
                        $has_file = isset($_FILES['foto_profil']) 
                            && !empty($_FILES['foto_profil']['name']) 
                            && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK
                            && is_uploaded_file($_FILES['foto_profil']['tmp_name']);

                        if ($has_file) {
                            $upload_result = $this->upload_foto_profil();
                            if ($upload_result['success']) {
                                if (!empty($user->foto_profil)) {
                                    $old_foto = $user->foto_profil;
                                    if (strpos($old_foto, 'assets/img/users/') !== false) {
                                        $old_foto = basename($old_foto);
                                    }
                                    $old_file = FCPATH . 'assets/img/users/' . $old_foto;
                                    if (file_exists($old_file) && $old_foto != 'default.png') {
                                        @unlink($old_file);
                                    }
                                }
                                $update_data['foto_profil'] = $upload_result['file_name'];
                            } else {
                                $data['error'] = $upload_result['error'];
                            }
                        }

                        $password = trim($this->input->post('password'));
                        if (!empty($password)) {
                            $update_data['password'] = $password;
                        }

                        if (!isset($data['error'])) {
                            if ($this->Pengguna_model->update($user_id, $update_data)) {
                                $updated_user = $this->Pengguna_model->get_by_id($user_id);
                                $this->session->set_userdata([
                                    'nama_lengkap' => $updated_user->nama_lengkap,
                                    'user_name' => $updated_user->nama_lengkap,
                                    'email' => $updated_user->email,
                                    'username' => $updated_user->username,
                                    'foto_profil' => isset($updated_user->foto_profil) ? $updated_user->foto_profil : '',
                                    'user_email' => $updated_user->email
                                ]);

                                redirect('beranda');
                            } else {
                                $data['error'] = 'Gagal memperbarui profil. Silakan coba lagi.';
                            }
                        }
                    }
                }
            } else {
                $data['error'] = validation_errors('', '');
            }
        }

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/profil/edit', $data);
        $this->load->view('user/templates/footer');
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

        $upload_path = FCPATH . 'assets/img/users/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($file_ext, $allowed_extensions)) {
            return ['success' => false, 'error' => 'Format file tidak didukung. Format yang diizinkan: JPG, JPEG, PNG, GIF, WEBP'];
        }

        $image_info = @getimagesize($file['tmp_name']);
        if ($image_info === FALSE) {
            return ['success' => false, 'error' => 'File yang diupload bukan gambar valid'];
        }

        $max_size = 2048 * 1024;
        if ($file['size'] > $max_size) {
            return ['success' => false, 'error' => 'Ukuran file terlalu besar. Maksimal 2MB'];
        }

        $file_name = 'user_' . time() . '_' . uniqid() . '.' . $file_ext;

        if (move_uploaded_file($file['tmp_name'], $upload_path . $file_name)) {
            return ['success' => true, 'file_name' => $file_name];
        } else {
            return ['success' => false, 'error' => 'Gagal mengupload file'];
        }
    }
}

