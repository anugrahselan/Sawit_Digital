<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();

        $this->load->model('Harga_tbs_model');
    }

    public function index()
    {
        $data['page_title'] = 'Dashboard Admin';
        $data['page_css'] = 'dashboard.css';

        $data['total_perusahaan'] = $this->get_total_perusahaan();
        $data['total_kabupaten'] = $this->get_total_kabupaten();
        $data['total_users'] = $this->get_total_users();
        $data['total_kalkulasi_panen'] = $this->get_total_kalkulasi_panen();
        $data['total_kalkulasi_pupuk'] = $this->get_total_kalkulasi_pupuk();
        $data['avg_harga_tbs'] = $this->get_avg_harga_tbs();
        $data['total_jenis_pupuk'] = $this->get_total_jenis_pupuk();
        $data['total_penyakit'] = $this->get_total_penyakit();

        $data['tbs_prices'] = $this->get_harga_tbs_dengan_perubahan();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/templates/footer');
    }

    private function get_total_perusahaan()
    {
        return $this->db->table_exists('perusahaan') ? $this->db->count_all('perusahaan') : 0;
    }

    private function get_total_kabupaten()
    {
        return $this->db->count_all('kabupaten');
    }

    private function get_total_users()
    {
        return $this->db->count_all('users');
    }

    private function get_total_kalkulasi_panen()
    {
        return $this->db->table_exists('kalkulasi_panen') ? $this->db->count_all('kalkulasi_panen') : 0;
    }

    private function get_total_kalkulasi_pupuk()
    {
        return $this->db->table_exists('kalkulasi_dosis_pupuk') ? $this->db->count_all('kalkulasi_dosis_pupuk') : 0;
    }

    private function get_avg_harga_tbs()
    {
        $query = $this->db->query('SELECT AVG(harga_per_kg) as avg_harga_per_kg FROM harga_tbs');
        $result = $query->row();
        return $result ? (float) $result->avg_harga_per_kg : 0;
    }

    private function get_total_jenis_pupuk()
    {
        return $this->db->table_exists('jenis_pupuk') ? $this->db->count_all('jenis_pupuk') : 0;
    }

    private function get_total_penyakit()
    {
        return $this->db->table_exists('jenis_penyakit') ? $this->db->count_all('jenis_penyakit') : 0;
    }

    private function get_harga_tbs_dengan_perubahan()
    {
        $daftar_harga = $this->Harga_tbs_model->get_harga_hari_ini();
        if (empty($daftar_harga)) {
            $daftar_harga = $this->Harga_tbs_model->get_harga_terbaru_per_perusahaan();
        }

        $daftar_harga = array_slice($daftar_harga, 0, 10);

        foreach ($daftar_harga as $harga) {
            $tanggal_sekarang = date('Y-m-d', strtotime($harga->tanggal));
            $harga_sebelumnya = $this->Harga_tbs_model->get_harga_sebelumnya(
                $harga->id_kabupaten,
                $harga->id_perusahaan,
                $tanggal_sekarang
            );

            if ($harga_sebelumnya && isset($harga_sebelumnya->harga_per_kg)) {
                $harga_sekarang = (float) $harga->harga_per_kg;
                $harga_kemarin = (float) $harga_sebelumnya->harga_per_kg;
                $selisih = $harga_sekarang - $harga_kemarin;

                $harga->perubahan = $selisih;
                $harga->status_perubahan = $selisih > 0 ? 'naik' : ($selisih < 0 ? 'turun' : 'tidak_ada');
                $harga->harga_kemarin = $harga_kemarin;
            } else {
                $harga->perubahan = null;
                $harga->status_perubahan = 'tidak_ada';
                $harga->harga_kemarin = null;
            }
        }

        return $daftar_harga;
    }
}
