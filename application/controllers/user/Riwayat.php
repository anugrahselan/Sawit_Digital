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

    private function require_login(): void
    {
        if (!$this->session->userdata('id_user')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Anda harus login terlebih dahulu untuk melihat riwayat kalkulasi</div>');
            redirect('login');
        }
    }

    /**
     * Halaman utama riwayat kalkulasi
     * Menampilkan tab untuk panen dan pupuk
     */
    public function index(): void
    {
        $this->require_login();
        
        $data['page_title'] = 'Riwayat Kalkulasi - Sawit Digital';
        $data['page_css'] = 'user/riwayat.css';
        $data['page_js'] = 'user/riwayat.js';
        
        $id_user = $this->session->userdata('id_user');
        
        log_message('debug', 'Riwayat - id_user dari session: ' . $id_user);
        
        $this->db->where('id_user', $id_user);
        $count_panen = $this->db->count_all_results('kalkulasi_panen');
        log_message('debug', 'Riwayat - Jumlah kalkulasi_panen untuk id_user ' . $id_user . ': ' . $count_panen);
        
        $this->db->where('id_user', $id_user);
        $count_pupuk = $this->db->count_all_results('kalkulasi_dosis_pupuk');
        log_message('debug', 'Riwayat - Jumlah kalkulasi_dosis_pupuk untuk id_user ' . $id_user . ': ' . $count_pupuk);
        
        $data['kalkulasi_panen'] = $this->get_kalkulasi_panen($id_user);
        
        $data['kalkulasi_pupuk'] = $this->get_kalkulasi_pupuk($id_user);
        
        log_message('debug', 'Riwayat - Jumlah hasil kalkulasi_panen: ' . count($data['kalkulasi_panen']));
        log_message('debug', 'Riwayat - Jumlah hasil kalkulasi_pupuk: ' . count($data['kalkulasi_pupuk']));
        
        $this->load->view('user/templates/header', $data);
        $this->load->view('user/riwayat/index', $data);
        $this->load->view('user/templates/footer');
    }

    /**
     * Get kalkulasi panen untuk user yang login
     */
    private function get_kalkulasi_panen($id_user)
    {
        $columns = $this->db->list_fields('kalkulasi_panen');
        $has_id_user = in_array('id_user', $columns);
        
        log_message('debug', 'Riwayat - Kolom kalkulasi_panen: ' . implode(', ', $columns));
        log_message('debug', 'Riwayat - has_id_user: ' . ($has_id_user ? 'true' : 'false'));
        
        if (!$has_id_user) {
            log_message('debug', 'Riwayat - Kolom id_user tidak ada di tabel kalkulasi_panen');
            return [];
        }
        
        $this->db->select('kp.*, k.nama_kabupaten, p.nama_perusahaan');
        $this->db->from('kalkulasi_panen kp');
        $this->db->join('kabupaten k', 'kp.id_kabupaten = k.id_kabupaten', 'left');
        $this->db->join('perusahaan p', 'kp.id_perusahaan = p.id_perusahaan', 'left');
        $this->db->where('kp.id_user', $id_user);
        
        if (in_array('tanggal_kalkulasi', $columns)) {
            $this->db->order_by('kp.tanggal_kalkulasi', 'DESC');
        } else {
            $this->db->order_by('kp.id_kalkulasi', 'DESC');
        }
        
        $query = $this->db->get();
        
        log_message('debug', 'Riwayat - SQL Query Panen: ' . $this->db->last_query());
        log_message('debug', 'Riwayat - Num Rows Panen: ' . $query->num_rows());
        
        return $query->result();
    }

    /**
     * Get kalkulasi pupuk untuk user yang login
     */
    private function get_kalkulasi_pupuk($id_user)
    {
        $columns = $this->db->list_fields('kalkulasi_dosis_pupuk');
        $has_id_user = in_array('id_user', $columns);
        
        log_message('debug', 'Riwayat - Kolom kalkulasi_dosis_pupuk: ' . implode(', ', $columns));
        log_message('debug', 'Riwayat - has_id_user: ' . ($has_id_user ? 'true' : 'false'));
        
        if (!$has_id_user) {
            log_message('debug', 'Riwayat - Kolom id_user tidak ada di tabel kalkulasi_dosis_pupuk');
            return [];
        }
        
        $this->db->select('kdp.*, jp.nama_pupuk, jp.kandungan, jp.fungsi, jt.nama_tanah, jt.ph_min, jt.ph_max');
        $this->db->from('kalkulasi_dosis_pupuk kdp');
        $this->db->join('jenis_pupuk jp', 'kdp.id_pupuk = jp.id_pupuk', 'left');
        $this->db->join('jenis_tanah jt', 'kdp.id_tanah = jt.id_tanah', 'left');
        $this->db->where('kdp.id_user', $id_user);
        
        if (in_array('tanggal_kalkulasi', $columns)) {
            $this->db->order_by('kdp.tanggal_kalkulasi', 'DESC');
        } else {
            $this->db->order_by('kdp.id_kalkulasi', 'DESC');
        }
        
        $query = $this->db->get();
        
        log_message('debug', 'Riwayat - SQL Query Pupuk: ' . $this->db->last_query());
        log_message('debug', 'Riwayat - Num Rows Pupuk: ' . $query->num_rows());
        
        return $query->result();
    }

    /**
     * Hapus kalkulasi panen
     */
    public function hapus_panen($id_kalkulasi): void
    {
        $this->require_login();
        
        $columns = $this->db->list_fields('kalkulasi_panen');
        $has_id_user = in_array('id_user', $columns);
        
        if (!$has_id_user) {
            $this->session->set_flashdata('error', 'Fitur ini memerlukan update database. Silakan hubungi administrator.');
            redirect('riwayat');
            return;
        }
        
        $id_user = $this->session->userdata('id_user');
        
        $kalkulasi = $this->db->get_where('kalkulasi_panen', [
            'id_kalkulasi' => $id_kalkulasi,
            'id_user' => $id_user
        ])->row();
        
        if (!$kalkulasi) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan atau Anda tidak memiliki akses');
            redirect('riwayat');
            return;
        }
        
        $this->db->where('id_kalkulasi', $id_kalkulasi);
        $this->db->where('id_user', $id_user);
        $this->db->delete('kalkulasi_panen');
        
        $this->session->set_flashdata('success', 'Data kalkulasi panen berhasil dihapus');
        redirect('riwayat');
    }

    /**
     * Debug method - Hapus setelah selesai debugging
     */
    public function debug(): void
    {
        $this->require_login();
        
        $id_user = $this->session->userdata('id_user');
        
        echo "<h2>Debug Info - Riwayat Kalkulasi</h2>";
        echo "<p><strong>ID User dari Session:</strong> " . ($id_user ?: 'NULL') . "</p>";
    
        $columns_panen = $this->db->list_fields('kalkulasi_panen');
        echo "<h3>Kolom kalkulasi_panen:</h3>";
        echo "<pre>" . print_r($columns_panen, true) . "</pre>";
        echo "<p><strong>Has id_user:</strong> " . (in_array('id_user', $columns_panen) ? 'YES' : 'NO') . "</p>";
        echo "<p><strong>Has tanggal_kalkulasi:</strong> " . (in_array('tanggal_kalkulasi', $columns_panen) ? 'YES' : 'NO') . "</p>";
        
        $all_panen = $this->db->get('kalkulasi_panen')->result();
        echo "<h3>Semua Data kalkulasi_panen (" . count($all_panen) . " records):</h3>";
        echo "<pre>" . print_r($all_panen, true) . "</pre>";
        
        if (in_array('id_user', $columns_panen)) {
            $this->db->where('id_user', $id_user);
            $user_panen = $this->db->get('kalkulasi_panen')->result();
            echo "<h3>Data kalkulasi_panen untuk id_user " . $id_user . " (" . count($user_panen) . " records):</h3>";
            echo "<pre>" . print_r($user_panen, true) . "</pre>";
        }
        
        $columns_pupuk = $this->db->list_fields('kalkulasi_dosis_pupuk');
        echo "<h3>Kolom kalkulasi_dosis_pupuk:</h3>";
        echo "<pre>" . print_r($columns_pupuk, true) . "</pre>";
        echo "<p><strong>Has id_user:</strong> " . (in_array('id_user', $columns_pupuk) ? 'YES' : 'NO') . "</p>";
        echo "<p><strong>Has tanggal_kalkulasi:</strong> " . (in_array('tanggal_kalkulasi', $columns_pupuk) ? 'YES' : 'NO') . "</p>";
        
        $all_pupuk = $this->db->get('kalkulasi_dosis_pupuk')->result();
        echo "<h3>Semua Data kalkulasi_dosis_pupuk (" . count($all_pupuk) . " records):</h3>";
        echo "<pre>" . print_r($all_pupuk, true) . "</pre>";
        
        if (in_array('id_user', $columns_pupuk)) {
            $this->db->where('id_user', $id_user);
            $user_pupuk = $this->db->get('kalkulasi_dosis_pupuk')->result();
            echo "<h3>Data kalkulasi_dosis_pupuk untuk id_user " . $id_user . " (" . count($user_pupuk) . " records):</h3>";
            echo "<pre>" . print_r($user_pupuk, true) . "</pre>";
        }
        
        echo "<h3>Test Query Panen:</h3>";
        $this->db->select('kp.*, k.nama_kabupaten, p.nama_perusahaan');
        $this->db->from('kalkulasi_panen kp');
        $this->db->join('kabupaten k', 'kp.id_kabupaten = k.id_kabupaten', 'left');
        $this->db->join('perusahaan p', 'kp.id_perusahaan = p.id_perusahaan', 'left');
        if (in_array('id_user', $columns_panen)) {
            $this->db->where('kp.id_user', $id_user);
        }
        $query_panen = $this->db->get();
        echo "<p><strong>SQL:</strong> " . $this->db->last_query() . "</p>";
        echo "<p><strong>Num Rows:</strong> " . $query_panen->num_rows() . "</p>";
        echo "<pre>" . print_r($query_panen->result(), true) . "</pre>";
    }

    /**
     * Hapus kalkulasi pupuk
     */
    public function hapus_pupuk($id_kalkulasi): void
    {
        $this->require_login();
        
        $columns = $this->db->list_fields('kalkulasi_dosis_pupuk');
        $has_id_user = in_array('id_user', $columns);
        
        if (!$has_id_user) {
            $this->session->set_flashdata('error', 'Fitur ini memerlukan update database. Silakan hubungi administrator.');
            redirect('riwayat');
            return;
        }
        
        $id_user = $this->session->userdata('id_user');
        
        $kalkulasi = $this->db->get_where('kalkulasi_dosis_pupuk', [
            'id_kalkulasi' => $id_kalkulasi,
            'id_user' => $id_user
        ])->row();
        
        if (!$kalkulasi) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan atau Anda tidak memiliki akses');
            redirect('riwayat');
            return;
        }
        
        $this->db->where('id_kalkulasi', $id_kalkulasi);
        $this->db->where('id_user', $id_user);
        $this->db->delete('kalkulasi_dosis_pupuk');
        
        $this->session->set_flashdata('success', 'Data kalkulasi pupuk berhasil dihapus');
        redirect('riwayat');
    }
}

