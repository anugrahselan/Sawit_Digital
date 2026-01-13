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

        $sql = "SELECT * FROM users ORDER BY id_user ASC";
        $data['users'] = $this->db->query($sql)->result();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function delete($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">ID user tidak valid!</div>');
            redirect('admin/users');
            return;
        }

        if ($id == $this->user_id) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda tidak dapat menghapus akun sendiri!</div>');
            redirect('admin/users');
            return;
        }

        $user = $this->Pengguna_model->get_by_id($id);
        if (!$user) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">User tidak ditemukan!</div>');
            redirect('admin/users');
            return;
        }

        if ($user->role == 'admin') {
            $admin_count = $this->Pengguna_model->count_admins();
            if ($admin_count <= 1) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak dapat menghapus admin terakhir! Sistem memerlukan minimal 1 admin aktif.</div>');
                redirect('admin/users');
                return;
            }
        }

        $this->db->trans_start();

        $this->db->where('id_user', $id);
        $this->db->delete('kalkulasi_dosis_pupuk');

        $kolom_tabel = $this->db->list_fields('kalkulasi_panen');
        if (in_array('id_user', $kolom_tabel)) {
            $this->db->where('id_user', $id);
            $this->db->delete('kalkulasi_panen');
        }

        if (!empty($user->foto_profil) && $user->foto_profil != 'default.png') {
            $foto = $user->foto_profil;
            if (strpos($foto, 'assets/img/users/') !== false) {
                $foto = basename($foto);
            }
            $foto_path = FCPATH . 'assets/img/users/' . $foto;
            if (file_exists($foto_path) && $foto != 'default.png') {
                @unlink($foto_path);
            }
        }

        $deleted = $this->Pengguna_model->delete($id);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE || !$deleted) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menghapus user. Terjadi kesalahan pada database.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User <strong>' . htmlspecialchars($user->nama_lengkap) . '</strong> beserta data terkait berhasil dihapus!</div>');
        }

        redirect('admin/users');
    }
}