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

    private function cek_login()
    {
        if (!$this->session->userdata('id_user')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
            exit;
        }
    }

    public function index()
    {
        $data['page_title'] = 'Kalkulator Panen - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/kalkulator_panen.css';
        $data['page_js'] = 'user/kalkulator_panen.js';
        $sql = "SELECT * FROM kabupaten ORDER BY nama_kabupaten ASC";
        $data['kabupaten'] = $this->db->query($sql)->result();
        $data['perusahaan'] = $this->Perusahaan_model->get_all();
        $data['is_logged_in'] = $this->session->userdata('id_user') ? true : false;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/kalkulator_panen/index', $data);
        $this->load->view('user/templates/footer');
    }

    public function get_perusahaan_by_kabupaten()
    {
        header('Content-Type: application/json');

        $id_kabupaten = $this->input->get('id_kabupaten');

        if (!$id_kabupaten) {
            echo json_encode(['success' => false, 'message' => 'Pilih kabupaten terlebih dahulu']);
            return;
        }

        try {
            $perusahaan = $this->Perusahaan_model->get_by_kabupaten($id_kabupaten);
            echo json_encode([
                'success' => true,
                'data' => $perusahaan,
                'count' => count($perusahaan)
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error get_perusahaan_by_kabupaten: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Gagal mengambil data perusahaan'
            ]);
        }
    }

    public function get_harga_tbs()
    {
        header('Content-Type: application/json');

        $id_perusahaan = $this->input->get('id_perusahaan');
        $id_kabupaten = $this->input->get('id_kabupaten');

        if (!$id_perusahaan || !$id_kabupaten) {
            echo json_encode(['success' => false, 'message' => 'Pilih perusahaan dan kabupaten terlebih dahulu']);
            return;
        }

        $this->load->model('Harga_tbs_model');
        $sql = "SELECT * FROM harga_tbs WHERE id_perusahaan = ? AND id_kabupaten = ? ORDER BY tanggal DESC LIMIT 1";
        $harga_tbs = $this->db->query($sql, [$id_perusahaan, $id_kabupaten])->row();

        if ($harga_tbs) {
            echo json_encode([
                'success' => true,
                'harga_per_kg' => (float) $harga_tbs->harga_per_kg,
                'tanggal' => $harga_tbs->tanggal
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Harga TBS belum tersedia untuk perusahaan ini'
            ]);
        }
    }

    public function simpan()
    {
        header('Content-Type: application/json');

        $this->cek_login();

        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Metode tidak diizinkan']);
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
            echo json_encode(['success' => false, 'message' => 'Isi semua data yang wajib']);
            return;
        }

        if (!$hasil_bersih) {
            $total_pendapatan = $harga_per_kg * $berat_kotor;
            $potongan_rp = ($total_pendapatan * $potongan) / 100;
            $hasil_bersih = $total_pendapatan - $potongan_rp - $upah_panen - $biaya_transportasi - $potong_hutang;
        }

        if (empty($id_perusahaan)) {
            $id_perusahaan = $this->Perusahaan_model->get_or_create_mitra($id_kabupaten);
        } else {
            $id_perusahaan = (int) $id_perusahaan;
            if ($id_perusahaan <= 0) {
                $id_perusahaan = $this->Perusahaan_model->get_or_create_mitra($id_kabupaten);
            }
        }

        $id_user = $this->session->userdata('id_user');

        $kolom_tabel = $this->db->list_fields('kalkulasi_panen');
        $ada_id_user = in_array('id_user', $kolom_tabel);
        $ada_tanggal = in_array('tanggal_kalkulasi', $kolom_tabel);

        $data = [
            'id_kabupaten' => (int) $id_kabupaten,
            'id_perusahaan' => (int) $id_perusahaan,
            'harga_per_kg' => (float) $harga_per_kg,
            'berat_kotor' => (int) $berat_kotor,
            'potongan' => !empty($potongan) ? (int) $potongan : 0,
            'upah_panen' => !empty($upah_panen) ? (int) $upah_panen : 0,
            'biaya_transportasi' => !empty($biaya_transportasi) ? (int) $biaya_transportasi : 0,
            'potong_hutang' => !empty($potong_hutang) ? (int) $potong_hutang : 0,
            'hasil_bersih' => (float) $hasil_bersih
        ];

        if ($ada_id_user && $id_user) {
            $data['id_user'] = (int) $id_user;
        }

        if ($ada_tanggal) {
            $data['tanggal_kalkulasi'] = date('Y-m-d H:i:s');
        }

        if (!$this->db->table_exists('kalkulasi_panen')) {
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
            $sql = "INSERT INTO kalkulasi_panen (" . implode(',', $kolom) . ") VALUES (" . $placeholder . ")";
            $this->db->query($sql, $nilai);

            if ($this->db->affected_rows() > 0) {
                echo json_encode(['success' => true, 'message' => 'Data berhasil disimpan']);
            } else {
                log_message('error', 'Kalkulasi Panen: Gagal menyimpan data');
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal menyimpan data. Silakan coba lagi.'
                ]);
            }
        } catch (Exception $e) {
            log_message('error', 'Kalkulasi Panen Exception: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ]);
        }
    }
}
