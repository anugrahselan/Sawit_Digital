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
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda harus login terlebih dahulu untuk menggunakan kalkulator panen</div>');
            redirect('login');
        }
    }

    private function require_login_ajax(): void
    {
        if (!$this->session->userdata('id_user')) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Anda harus login terlebih dahulu']);
            exit;
        }
    }

    public function index(): void
    {
        // Kalkulator bisa diakses tanpa login (untuk preview)
        // Tapi untuk menyimpan, user harus login (dicek di save)

        $data['page_title'] = 'Kalkulator Panen - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/kalkulator_panen.css';
        $data['page_js'] = 'user/kalkulator_panen.js';
        $data['kabupaten'] = $this->db->get('kabupaten')->result();
        $data['perusahaan'] = $this->Perusahaan_model->get_all();
        $data['is_logged_in'] = $this->session->userdata('id_user') ? true : false;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/kalkulator_panen/index', $data);
        $this->load->view('user/templates/footer');
    }

    // API: Get perusahaan berdasarkan kabupaten (untuk AJAX)
    public function get_perusahaan_by_kabupaten(): void
    {
        header('Content-Type: application/json');

        $id_kabupaten = $this->input->get('id_kabupaten');

        if (!$id_kabupaten) {
            echo json_encode(['success' => false, 'message' => 'ID Kabupaten tidak valid']);
            return;
        }

        // Pastikan model sudah di-load
        $this->load->model('Perusahaan_model');

        try {
            $perusahaan = $this->Perusahaan_model->get_by_kabupaten($id_kabupaten);

            echo json_encode([
                'success' => true,
                'data' => $perusahaan,
                'count' => count($perusahaan),
                'id_kabupaten' => $id_kabupaten
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error get_perusahaan_by_kabupaten: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // API: Get harga TBS terbaru berdasarkan perusahaan dan kabupaten
    public function get_harga_tbs(): void
    {
        header('Content-Type: application/json');

        $id_perusahaan = $this->input->get('id_perusahaan');
        $id_kabupaten = $this->input->get('id_kabupaten');

        if (!$id_perusahaan || !$id_kabupaten) {
            echo json_encode(['success' => false, 'message' => 'ID Perusahaan dan Kabupaten harus diisi']);
            return;
        }

        // Ambil harga TBS terbaru untuk perusahaan dan kabupaten tersebut
        $this->load->model('Harga_tbs_model');
        $this->db->where('harga_tbs.id_perusahaan', $id_perusahaan);
        $this->db->where('harga_tbs.id_kabupaten', $id_kabupaten);
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $this->db->limit(1);
        $harga_tbs = $this->db->get('harga_tbs')->row();

        if ($harga_tbs) {
            echo json_encode([
                'success' => true,
                'harga_per_kg' => (float) $harga_tbs->harga_per_kg,
                'tanggal' => $harga_tbs->tanggal
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak ada data harga TBS untuk perusahaan dan kabupaten ini'
            ]);
        }
    }

    public function save(): void
    {
        header('Content-Type: application/json');

        // Cek apakah user sudah login
        $this->require_login_ajax();

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

        // Cek struktur tabel yang sebenarnya
        $columns = $this->db->list_fields('kalkulasi_panen');

        // Dari screenshot phpMyAdmin, struktur tabel kalkulasi_panen yang SEBENARNYA:
        // 1. id_kalkulasi - int, NOT NULL, AUTO_INCREMENT
        // 2. id_kabupaten - int, NOT NULL
        // 3. id_perusahaan - int, NOT NULL (BUKAN NULL! Ini masalahnya)
        // 4. harga_per_kg - decimal(10,2), NOT NULL
        // 5. berat_kotor - int, NOT NULL (BUKAN decimal!)
        // 6. potongan - int, NULL, Default 0
        // 7. upah_panen - int, NULL, Default 0
        // 8. biaya_transportasi - int, NULL, Default 0
        // 9. potong_hutang - int, NULL, Default 0
        // 10. hasil_bersih - decimal(10,2), NOT NULL
        // TIDAK ADA kolom id_user dan username di tabel yang sebenarnya!

        // Handle id_perusahaan: karena NOT NULL, kita HARUS set nilai (tidak bisa NULL)
        // Jika Mitra (kosong), dapatkan atau buat record "Mitra" di tabel perusahaan
        if (empty($id_perusahaan) || $id_perusahaan === '' || $id_perusahaan === null) {
            // Dapatkan atau buat record "Mitra" untuk kabupaten ini
            $id_perusahaan = $this->Perusahaan_model->get_or_create_mitra($id_kabupaten);
        } else {
            $id_perusahaan = (int) $id_perusahaan;
            if ($id_perusahaan <= 0) {
                // Jika tidak valid, buat record "Mitra"
                $id_perusahaan = $this->Perusahaan_model->get_or_create_mitra($id_kabupaten);
            }
        }

        // Log untuk debugging
        log_message('debug', 'Panen Save - id_perusahaan: ' . $id_perusahaan . ' (original: ' . $this->input->post('id_perusahaan') . ')');

        // Ambil id_user dari session
        $id_user = $this->session->userdata('id_user');

        // Debug: Log id_user dari session
        log_message('debug', 'Panen Save - id_user dari session: ' . ($id_user ?: 'NULL'));

        // Cek apakah kolom id_user dan tanggal_kalkulasi ada di tabel
        $columns = $this->db->list_fields('kalkulasi_panen');
        $has_id_user = in_array('id_user', $columns);
        $has_tanggal = in_array('tanggal_kalkulasi', $columns);

        // Debug: Log kolom yang ada
        log_message('debug', 'Panen Save - Kolom kalkulasi_panen: ' . implode(', ', $columns));
        log_message('debug', 'Panen Save - has_id_user: ' . ($has_id_user ? 'true' : 'false'));
        log_message('debug', 'Panen Save - has_tanggal: ' . ($has_tanggal ? 'true' : 'false'));

        // Sesuaikan dengan struktur database
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

        // Tambahkan id_user jika kolom ada (WAJIB jika kolom ada)
        if ($has_id_user) {
            if ($id_user) {
                $data['id_user'] = (int) $id_user;
                log_message('debug', 'Panen Save - id_user ditambahkan ke data: ' . $data['id_user']);
            } else {
                log_message('error', 'Panen Save - ERROR: id_user tidak ada di session tapi kolom id_user ada di tabel!');
            }
        }

        // Tambahkan tanggal_kalkulasi jika kolom ada (akan di-set otomatis oleh database jika DEFAULT CURRENT_TIMESTAMP)
        if ($has_tanggal) {
            $data['tanggal_kalkulasi'] = date('Y-m-d H:i:s');
            log_message('debug', 'Panen Save - tanggal_kalkulasi ditambahkan: ' . $data['tanggal_kalkulasi']);
        }

        // Cek apakah tabel ada
        if (!$this->db->table_exists('kalkulasi_panen')) {
            echo json_encode([
                'success' => false,
                'message' => 'Tabel kalkulasi_panen tidak ditemukan. Silakan hubungi administrator.'
            ]);
            return;
        }

        // Log data sebelum insert untuk debugging
        log_message('debug', 'Panen Save - Data sebelum insert: ' . json_encode($data));

        // Coba insert dengan error handling yang lebih baik
        try {
            // Insert langsung karena semua field sudah sesuai dengan struktur database
            $this->db->insert('kalkulasi_panen', $data);

            $error = $this->db->error();

            if ($this->db->affected_rows() > 0) {
                log_message('info', 'Panen Save - Data berhasil disimpan: ' . json_encode($data));
                echo json_encode(['success' => true, 'message' => 'Data berhasil disimpan']);
            } else {
                // Tampilkan error yang lebih detail untuk debugging
                $error_message = 'Gagal menyimpan data';

                // Cek error database
                if (!empty($error['code']) && $error['code'] != 0) {
                    $error_message .= ' (Error Code: ' . $error['code'] . ')';
                }
                if (!empty($error['message'])) {
                    $error_message .= ': ' . $error['message'];
                }

                // Jika tidak ada error code tapi affected_rows = 0, mungkin ada masalah lain
                if (empty($error['code']) || $error['code'] == 0) {
                    $error_message .= '. Tidak ada data yang tersimpan.';
                }

                // Log error untuk debugging
                log_message('error', 'Kalkulasi Panen Save Error: ' . json_encode($error));
                log_message('error', 'Data yang dikirim: ' . json_encode($data));
                log_message('error', 'Affected Rows: ' . $this->db->affected_rows());
                log_message('error', 'Last Query: ' . $this->db->last_query());

                echo json_encode([
                    'success' => false,
                    'message' => $error_message,
                    'debug' => ENVIRONMENT !== 'production' ? [
                        'error' => $error,
                        'affected_rows' => $this->db->affected_rows(),
                        'data' => $data,
                        'last_query' => $this->db->last_query()
                    ] : null
                ]);
            }
        } catch (Exception $e) {
            log_message('error', 'Kalkulasi Panen Exception: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'debug' => ENVIRONMENT !== 'production' ? [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ] : null
            ]);
        }
    }
}

