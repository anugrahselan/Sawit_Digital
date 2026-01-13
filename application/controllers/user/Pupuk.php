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

    private function cek_login()
    {
        if (!$this->session->userdata('id_user')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Anda harus login terlebih dahulu']);
            exit;
        }
    }

    public function index()
    {
        $data['page_title'] = 'Kalkulator Pupuk - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/kalkulator_pupuk.css';
        $data['page_js'] = 'user/kalkulator_pupuk.js';
        $data['fertilizers'] = $this->Jenis_pupuk_model->get_all();
        $sql = "SELECT * FROM jenis_tanah ORDER BY nama_tanah ASC";
        $data['tanah'] = $this->db->query($sql)->result_array();
        $data['is_logged_in'] = $this->session->userdata('id_user') ? true : false;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/kalkulator_pupuk/index', $data);
        $this->load->view('user/templates/footer');
    }

    public function daftar_jenis()
    {
        $data['page_title'] = 'Jenis Pupuk - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/jenis_pupuk.css';
        $data['fertilizers'] = $this->Jenis_pupuk_model->get_all();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/pupuk/jenis', $data);
        $this->load->view('user/templates/footer');
    }

    public function detail_pupuk($id = null)
    {
        if ($id !== null) {
            $id = (int) $id;
        }

        if (!$id || $id <= 0) {
            show_404();
        }

        $pupuk = $this->Jenis_pupuk_model->get_by_id($id);
        if (!$pupuk) {
            show_404();
        }

        $data['page_title'] = $pupuk['nama_pupuk'] . ' - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/jenis_pupuk.css';
        $data['pupuk'] = $pupuk;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/pupuk/detail', $data);
        $this->load->view('user/templates/footer');
    }

    public function simpan_dosis()
    {
        header('Content-Type: application/json');

        $this->cek_login();

        $id_user = $this->session->userdata('id_user');

        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Metode tidak diizinkan']);
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
            echo json_encode(['success' => false, 'message' => 'Isi semua data yang wajib']);
            return;
        }
        if (!$total_dosis) {
            $total_dosis = $dosis_per_pohon * $jumlah_pohon;
        }

        $periode_per_tahun = $periode_per_tahun ?: 1;
        if (!$dosis_per_periode && $periode_per_tahun > 0) {
            $dosis_per_periode = $total_dosis / $periode_per_tahun;
        }

        $kolom_tabel = $this->db->list_fields('kalkulasi_dosis_pupuk');
        $ada_tanggal = in_array('tanggal_kalkulasi', $kolom_tabel);

        $data = [
            'id_user' => (int) $id_user,
            'id_pupuk' => (int) $id_pupuk,
            'id_tanah' => (int) $id_tanah,
            'usia_tanaman' => (int) $usia_tanaman,
            'jumlah_pohon' => (int) $jumlah_pohon,
            'dosis_per_pohon' => (float) $dosis_per_pohon,
            'total_dosis' => (float) $total_dosis,
            'dosis_per_periode' => !empty($dosis_per_periode) ? (float) $dosis_per_periode : null,
            'rekomendasi_pupuk' => !empty($rekomendasi_pupuk) ? (string) $rekomendasi_pupuk : null,
            'periode_per_tahun' => (int) $periode_per_tahun,
            'keterangan_aplikasi' => !empty($keterangan_aplikasi) ? (string) $keterangan_aplikasi : null
        ];

        if ($ada_tanggal) {
            $data['tanggal_kalkulasi'] = date('Y-m-d H:i:s');
        }

        if (!$this->db->table_exists('kalkulasi_dosis_pupuk')) {
            echo json_encode([
                'success' => false,
                'message' => 'Sistem sedang bermasalah. Silakan hubungi administrator.'
            ]);
            return;
        }

        try {
            $kolom = array_keys($data);
            $nilai = array_values($data);
            $placeholder = implode(',', array_fill(0, count($nilai), '?'));
            $sql = "INSERT INTO kalkulasi_dosis_pupuk (" . implode(',', $kolom) . ") VALUES (" . $placeholder . ")";
            $this->db->query($sql, $nilai);

            if ($this->db->affected_rows() > 0) {
                echo json_encode(['success' => true, 'message' => 'Data dosis berhasil disimpan']);
            } else {
                log_message('error', 'Kalkulasi Dosis Pupuk: Gagal menyimpan data');
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal menyimpan data. Silakan coba lagi.'
                ]);
            }
        } catch (Exception $e) {
            log_message('error', 'Kalkulasi Dosis Pupuk Exception: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ]);
        }
    }
}
