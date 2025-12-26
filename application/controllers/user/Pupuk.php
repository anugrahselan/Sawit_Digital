<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pupuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_pupuk_model');
        $this->load->database();
    }

    public function index()
    {
        $data['page_title'] = 'Kalkulator Pupuk - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/kalkulator_pupuk.css';
        $data['page_js'] = 'user/kalkulator_pupuk.js';
        $data['fertilizers'] = $this->Jenis_pupuk_model->get_all();
        $data['tanah'] = $this->db->get('jenis_tanah')->result();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/kalkulator/pupuk', $data);
        $this->load->view('user/templates/footer');
    }

    public function list()
    {
        $data['page_title'] = 'Jenis Pupuk - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/jenis_pupuk.css';
        $data['fertilizers'] = $this->Jenis_pupuk_model->get_all();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/pupuk/jenis', $data);
        $this->load->view('user/templates/footer');
    }

    public function save_dosis()
    {
        header('Content-Type: application/json');
        
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $id_pupuk = $this->input->post('id_pupuk');
        $id_tanah = $this->input->post('id_tanah');
        $usia_tanaman = $this->input->post('usia_tanaman');
        $dosis_per_pohon = $this->input->post('dosis_per_pohon');
        $keterangan_aplikasi = $this->input->post('keterangan_aplikasi');

        if (!$id_pupuk || !$id_tanah || !$usia_tanaman || !$dosis_per_pohon) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        // Calculate usia_tanaman_min and max (assuming bulan, convert to tahun for range)
        $usia_tahun = $usia_tanaman / 12;
        $usia_min = floor($usia_tahun);
        $usia_max = ceil($usia_tahun);

        $data = [
            'id_pupuk' => $id_pupuk,
            'id_tanah' => $id_tanah,
            'usia_tanaman_min' => $usia_min,
            'usia_tanaman_max' => $usia_max,
            'dosis_per_pohon' => $dosis_per_pohon,
            'keterangan_aplikasi' => $keterangan_aplikasi ?: ''
        ];

        if ($this->db->insert('dosis_pupuk', $data)) {
            echo json_encode(['success' => true, 'message' => 'Data dosis berhasil disimpan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data']);
        }
    }
}

