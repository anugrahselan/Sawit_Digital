<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function cek_login()
    {
        if (!$this->session->userdata('id_user')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda harus login terlebih dahulu untuk melihat riwayat kalkulasi</div>');
            redirect('login');
        }
    }

    public function index()
    {
        $this->cek_login();

        $data['page_title'] = 'Riwayat Kalkulasi - Sawit Digital';
        $data['page_css'] = 'user/riwayat.css';
        $data['page_js'] = 'user/riwayat.js';

        $id_pengguna = $this->session->userdata('id_user');
        $data['kalkulasi_panen'] = $this->ambil_kalkulasi_panen($id_pengguna);
        $data['kalkulasi_pupuk'] = $this->ambil_kalkulasi_pupuk($id_pengguna);

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/riwayat/index', $data);
        $this->load->view('user/templates/footer');
    }

    private function ambil_kalkulasi_panen($id_pengguna)
    {
        $kolom_tabel = $this->db->list_fields('kalkulasi_panen');
        if (!in_array('id_user', $kolom_tabel)) {
            return [];
        }

        $this->db->select('kp.*, k.nama_kabupaten, p.nama_perusahaan');
        $this->db->from('kalkulasi_panen kp');
        $this->db->join('kabupaten k', 'kp.id_kabupaten = k.id_kabupaten', 'left');
        $this->db->join('perusahaan p', 'kp.id_perusahaan = p.id_perusahaan', 'left');
        $this->db->where('kp.id_user', $id_pengguna);
        $this->db->order_by(in_array('tanggal_kalkulasi', $kolom_tabel) ? 'kp.tanggal_kalkulasi' : 'kp.id_kalkulasi', 'ASC');

        return $this->db->get()->result();
    }

    private function ambil_kalkulasi_pupuk($id_pengguna)
    {
        $kolom_tabel = $this->db->list_fields('kalkulasi_dosis_pupuk');
        if (!in_array('id_user', $kolom_tabel)) {
            return [];
        }

        $this->db->select('kdp.*, jp.nama_pupuk, jp.kandungan, jp.fungsi, jt.nama_tanah, jt.ph_min, jt.ph_max');
        $this->db->from('kalkulasi_dosis_pupuk kdp');
        $this->db->join('jenis_pupuk jp', 'kdp.id_pupuk = jp.id_pupuk', 'left');
        $this->db->join('jenis_tanah jt', 'kdp.id_tanah = jt.id_tanah', 'left');
        $this->db->where('kdp.id_user', $id_pengguna);
        $this->db->order_by(in_array('tanggal_kalkulasi', $kolom_tabel) ? 'kdp.tanggal_kalkulasi' : 'kdp.id_kalkulasi', 'ASC');

        return $this->db->get()->result();
    }

    public function hapus_panen($id_kalkulasi)
    {
        $this->cek_login();

        $kolom_tabel = $this->db->list_fields('kalkulasi_panen');
        if (!in_array('id_user', $kolom_tabel)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Fitur ini memerlukan update database. Silakan hubungi administrator.</div>');
            redirect('riwayat');
        }

        $id_pengguna = $this->session->userdata('id_user');
        $data_kalkulasi = $this->db->get_where('kalkulasi_panen', [
            'id_kalkulasi' => $id_kalkulasi,
            'id_user' => $id_pengguna
        ])->row();

        if (!$data_kalkulasi) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan atau Anda tidak memiliki akses</div>');
            redirect('riwayat');
        }

        $this->db->where('id_kalkulasi', $id_kalkulasi);
        $this->db->where('id_user', $id_pengguna);
        $this->db->delete('kalkulasi_panen');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
        redirect('riwayat');
    }

    public function hapus_pupuk($id_kalkulasi)
    {
        $this->cek_login();

        $kolom_tabel = $this->db->list_fields('kalkulasi_dosis_pupuk');
        if (!in_array('id_user', $kolom_tabel)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Fitur ini memerlukan update database. Silakan hubungi administrator.</div>');
            redirect('riwayat');
        }

        $id_pengguna = $this->session->userdata('id_user');
        $data_kalkulasi = $this->db->get_where('kalkulasi_dosis_pupuk', [
            'id_kalkulasi' => $id_kalkulasi,
            'id_user' => $id_pengguna
        ])->row();

        if (!$data_kalkulasi) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Data tidak ditemukan atau Anda tidak memiliki akses</div>');
            redirect('riwayat');
        }

        $this->db->where('id_kalkulasi', $id_kalkulasi);
        $this->db->where('id_user', $id_pengguna);
        $this->db->delete('kalkulasi_dosis_pupuk');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil di hapus</div>');
        redirect('riwayat');
    }
}

