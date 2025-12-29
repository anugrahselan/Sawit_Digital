<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pupuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_pupuk_model');
        $this->load->database();
    }
    
    private function require_login(): void
    {
        if (!$this->session->userdata('id_user')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Anda harus login terlebih dahulu']);
            exit;
        }
    }

    public function index(): void
    {
        $data['page_title'] = 'Kalkulator Pupuk - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/kalkulator_pupuk.css';
        $data['page_js'] = 'user/kalkulator_pupuk.js';
        $data['fertilizers'] = $this->Jenis_pupuk_model->get_all();
        $data['tanah'] = $this->db->get('jenis_tanah')->result();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/kalkulator_pupuk/index', $data);
        $this->load->view('user/templates/footer');
    }

    public function list(): void
    {
        $data['page_title'] = 'Jenis Pupuk - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/jenis_pupuk.css';
        $data['fertilizers'] = $this->Jenis_pupuk_model->get_all();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/pupuk/jenis', $data);
        $this->load->view('user/templates/footer');
    }

    public function detail($id = null): void
    {
        if (!$id)
            show_404();

        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if (!$pupuk)
            show_404();

        $data['page_title'] = $pupuk->nama_pupuk . ' - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/jenis_pupuk.css';
        $data['pupuk'] = $pupuk;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/pupuk/detail', $data);
        $this->load->view('user/templates/footer');
    }

    public function save_dosis(): void
    {
        header('Content-Type: application/json');
        
        // Cek apakah user sudah login
        $this->require_login();
        
        $id_user = $this->session->userdata('id_user');

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $id_pupuk = $this->input->post('id_pupuk');
        $id_tanah = $this->input->post('id_tanah');
        $usia_tanaman = $this->input->post('usia_tanaman');
        $jumlah_pohon = $this->input->post('jumlah_pohon');
        $dosis_per_pohon = $this->input->post('dosis_per_pohon');
        $total_dosis = $this->input->post('total_dosis');
        $dosis_per_periode = $this->input->post('dosis_per_periode');
        $rekomendasi_pupuk = $this->input->post('rekomendasi_pupuk');
        $periode_per_tahun = $this->input->post('periode_per_tahun');
        $keterangan_aplikasi = $this->input->post('keterangan_aplikasi');

        if (!$id_pupuk || !$id_tanah || !$usia_tanaman || !$jumlah_pohon || !$dosis_per_pohon) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        // Hitung total_dosis jika tidak dikirim dari frontend
        if (!$total_dosis) {
            $total_dosis = $dosis_per_pohon * $jumlah_pohon;
        }

        // Set default nilai jika tidak ada
        $periode_per_tahun = $periode_per_tahun ?: 1;
        if (!$dosis_per_periode && $periode_per_tahun > 0) {
            $dosis_per_periode = $total_dosis / $periode_per_tahun;
        }

        $data = [
            'id_user' => $id_user,
            'id_pupuk' => $id_pupuk,
            'id_tanah' => $id_tanah,
            'usia_tanaman' => $usia_tanaman,
            'jumlah_pohon' => $jumlah_pohon,
            'dosis_per_pohon' => $dosis_per_pohon,
            'total_dosis' => $total_dosis,
            'dosis_per_periode' => $dosis_per_periode ?: null,
            'rekomendasi_pupuk' => $rekomendasi_pupuk ?: null,
            'periode_per_tahun' => $periode_per_tahun,
            'keterangan_aplikasi' => $keterangan_aplikasi ?: null
        ];

        if ($this->db->insert('kalkulasi_dosis_pupuk', $data)) {
            echo json_encode(['success' => true, 'message' => 'Data dosis berhasil disimpan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data']);
        }
    }
}

