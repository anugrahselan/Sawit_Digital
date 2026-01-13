<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_kalkulator_panen extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        $data['page_title'] = 'Kalkulasi Panen';
        $data['page_css'] = 'kalkulator_panen.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kalkulasi Panen', 'url' => site_url('admin/kalkulator_panen')]
        ];

        $kolom_tabel = $this->db->list_fields('kalkulasi_panen');
        $ada_id_user = in_array('id_user', $kolom_tabel);

        if ($ada_id_user) {
            $sql = "SELECT kalkulasi_panen.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan, 
                           users.username as user_username, users.nama_lengkap as user_nama
                    FROM kalkulasi_panen
                    LEFT JOIN kabupaten ON kabupaten.id_kabupaten = kalkulasi_panen.id_kabupaten
                    LEFT JOIN perusahaan ON perusahaan.id_perusahaan = kalkulasi_panen.id_perusahaan
                    LEFT JOIN users ON users.id_user = kalkulasi_panen.id_user
                    ORDER BY kalkulasi_panen.id_kalkulasi ASC";
        } else {
            $sql = "SELECT kalkulasi_panen.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan
                    FROM kalkulasi_panen
                    LEFT JOIN kabupaten ON kabupaten.id_kabupaten = kalkulasi_panen.id_kabupaten
                    LEFT JOIN perusahaan ON perusahaan.id_perusahaan = kalkulasi_panen.id_perusahaan
                    ORDER BY kalkulasi_panen.id_kalkulasi ASC";
        }

        $data['kalkulasi'] = $this->db->query($sql)->result();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kalkulator_panen/index', $data);
        $this->load->view('admin/templates/footer');
    }
}