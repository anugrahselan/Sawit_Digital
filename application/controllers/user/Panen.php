<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Panen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Perusahaan_model');
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
        $data['page_title'] = 'Kalkulator Panen - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/kalkulator_panen.css';
        $data['page_js'] = 'user/kalkulator_panen.js';
        $data['kabupaten'] = $this->db->get('kabupaten')->result();
        $data['perusahaan'] = $this->Perusahaan_model->get_all();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/kalkulator_panen/index', $data);
        $this->load->view('user/templates/footer');
    }

    public function save(): void
    {
        header('Content-Type: application/json');
        
        // Cek apakah user sudah login
        $this->require_login();
        
        $id_user = $this->session->userdata('id_user');
        $username = $this->session->userdata('username');

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $id_kabupaten = $this->input->post('id_kabupaten');
        $id_perusahaan = $this->input->post('id_perusahaan');
        $harga_per_kg = $this->input->post('harga_per_kg');
        $berat_kotor = $this->input->post('berat_kotor');
        $potongan = $this->input->post('potongan');
        $upah_panen = $this->input->post('upah_panen');
        $biaya_transportasi = $this->input->post('biaya_transportasi');
        $potong_hutang = $this->input->post('potong_hutang');
        $hasil_bersih = $this->input->post('hasil_bersih');

        if (!$id_kabupaten || !$harga_per_kg || !$berat_kotor) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        // Hitung hasil bersih jika tidak dikirim dari frontend
        if (!$hasil_bersih) {
            $total_pendapatan = $harga_per_kg * $berat_kotor;
            $potongan_rp = ($total_pendapatan * $potongan) / 100;
            $hasil_bersih = $total_pendapatan - $potongan_rp - $upah_panen - $biaya_transportasi - $potong_hutang;
        }

        $data = [
            'id_user' => $id_user,
            'username' => $username,
            'id_kabupaten' => $id_kabupaten,
            'id_perusahaan' => $id_perusahaan ?: null,
            'harga_per_kg' => $harga_per_kg,
            'berat_kotor' => $berat_kotor,
            'potongan' => $potongan ?: 0,
            'upah_panen' => $upah_panen ?: 0,
            'biaya_transportasi' => $biaya_transportasi ?: 0,
            'potong_hutang' => $potong_hutang ?: 0,
            'hasil_bersih' => $hasil_bersih
        ];

        if ($this->db->insert('kalkulasi_panen', $data)) {
            echo json_encode(['success' => true, 'message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data']);
        }
    }
}

