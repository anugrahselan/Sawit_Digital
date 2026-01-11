<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Jenis_pupuk_model');
    }

    private function require_login()
    {
        if (!$this->session->userdata('id_user')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda harus login terlebih dahulu untuk melihat riwayat kalkulasi</div>');
            redirect('login');
        }
    }

    public function index()
    {
        $this->require_login();
        
        $data['page_title'] = 'Riwayat Kalkulasi - Sawit Digital';
        $data['page_css'] = 'user/riwayat.css';
        $data['page_js'] = 'user/riwayat.js';
        
        $id_user = $this->session->userdata('id_user');
        $data['kalkulasi_panen'] = $this->get_kalkulasi_panen($id_user);
        $data['kalkulasi_pupuk'] = $this->get_kalkulasi_pupuk($id_user);
        
        $this->load->view('user/templates/header', $data);
        $this->load->view('user/riwayat/index', $data);
        $this->load->view('user/templates/footer');
    }
    private function get_kalkulasi_panen($id_user)
    {
        $columns = $this->db->list_fields('kalkulasi_panen');
        if (!in_array('id_user', $columns)) {
            return [];
        }
        
        $this->db->select('kp.*, k.nama_kabupaten, p.nama_perusahaan');
        $this->db->from('kalkulasi_panen kp');
        $this->db->join('kabupaten k', 'kp.id_kabupaten = k.id_kabupaten', 'left');
        $this->db->join('perusahaan p', 'kp.id_perusahaan = p.id_perusahaan', 'left');
        $this->db->where('kp.id_user', $id_user);
        $this->db->order_by(in_array('tanggal_kalkulasi', $columns) ? 'kp.tanggal_kalkulasi' : 'kp.id_kalkulasi', 'DESC');
        
        return $this->db->get()->result();
    }

    private function get_kalkulasi_pupuk($id_user)
    {
        $columns = $this->db->list_fields('kalkulasi_dosis_pupuk');
        if (!in_array('id_user', $columns)) {
            return [];
        }
        
        $this->db->select('kdp.*, jp.nama_pupuk, jp.kandungan, jp.fungsi, jt.nama_tanah, jt.ph_min, jt.ph_max');
        $this->db->from('kalkulasi_dosis_pupuk kdp');
        $this->db->join('jenis_pupuk jp', 'kdp.id_pupuk = jp.id_pupuk', 'left');
        $this->db->join('jenis_tanah jt', 'kdp.id_tanah = jt.id_tanah', 'left');
        $this->db->where('kdp.id_user', $id_user);
        $this->db->order_by(in_array('tanggal_kalkulasi', $columns) ? 'kdp.tanggal_kalkulasi' : 'kdp.id_kalkulasi', 'DESC');
        
        return $this->db->get()->result();
    }

    public function hapus_panen($id_kalkulasi)
    {
        $this->require_login();
        
        $columns = $this->db->list_fields('kalkulasi_panen');
        if (!in_array('id_user', $columns)) {
            $this->session->set_flashdata('error', 'Fitur ini memerlukan update database. Silakan hubungi administrator.');
            redirect('riwayat');
        }
        
        $id_user = $this->session->userdata('id_user');
        $kalkulasi = $this->db->get_where('kalkulasi_panen', [
            'id_kalkulasi' => $id_kalkulasi,
            'id_user' => $id_user
        ])->row();
        
        if (!$kalkulasi) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan atau Anda tidak memiliki akses');
            redirect('riwayat');
        }
        
        $this->db->where('id_kalkulasi', $id_kalkulasi);
        $this->db->where('id_user', $id_user);
        $this->db->delete('kalkulasi_panen');
        
        $this->session->set_flashdata('success', 'Data kalkulasi panen berhasil dihapus');
        redirect('riwayat');
    }

    public function hapus_pupuk($id_kalkulasi)
    {
        $this->require_login();
        
        $columns = $this->db->list_fields('kalkulasi_dosis_pupuk');
        if (!in_array('id_user', $columns)) {
            $this->session->set_flashdata('error', 'Fitur ini memerlukan update database. Silakan hubungi administrator.');
            redirect('riwayat');
        }
        
        $id_user = $this->session->userdata('id_user');
        $kalkulasi = $this->db->get_where('kalkulasi_dosis_pupuk', [
            'id_kalkulasi' => $id_kalkulasi,
            'id_user' => $id_user
        ])->row();
        
        if (!$kalkulasi) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan atau Anda tidak memiliki akses');
            redirect('riwayat');
        }
        
        $this->db->where('id_kalkulasi', $id_kalkulasi);
        $this->db->where('id_user', $id_user);
        $this->db->delete('kalkulasi_dosis_pupuk');
        
        $this->session->set_flashdata('success', 'Data kalkulasi pupuk berhasil dihapus');
        redirect('riwayat');
    }
}

