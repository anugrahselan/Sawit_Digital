<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_kalkulator_pupuk extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        $data['page_title'] = 'Kalkulasi Pupuk';
        $data['page_css'] = 'kalkulator_pupuk.css';
        $data['breadcrumbs'] = [
            ['label' => 'Dashboard', 'url' => site_url('admin/dashboard')],
            ['label' => 'Kalkulasi Pupuk', 'url' => site_url('admin/kalkulator_pupuk')]
        ];

        $kolom_tabel = $this->db->list_fields('kalkulasi_dosis_pupuk');
        $ada_id_user = in_array('id_user', $kolom_tabel);

        if ($ada_id_user) {
            $sql = "SELECT kalkulasi_dosis_pupuk.*, jenis_pupuk.nama_pupuk, jenis_tanah.nama_tanah, 
                           users.username as user_username, users.nama_lengkap as user_nama
                    FROM kalkulasi_dosis_pupuk
                    LEFT JOIN jenis_pupuk ON jenis_pupuk.id_pupuk = kalkulasi_dosis_pupuk.id_pupuk
                    LEFT JOIN jenis_tanah ON jenis_tanah.id_tanah = kalkulasi_dosis_pupuk.id_tanah
                    LEFT JOIN users ON users.id_user = kalkulasi_dosis_pupuk.id_user
                    ORDER BY kalkulasi_dosis_pupuk.id_kalkulasi ASC";
        } else {
            $sql = "SELECT kalkulasi_dosis_pupuk.*, jenis_pupuk.nama_pupuk, jenis_tanah.nama_tanah
                    FROM kalkulasi_dosis_pupuk
                    LEFT JOIN jenis_pupuk ON jenis_pupuk.id_pupuk = kalkulasi_dosis_pupuk.id_pupuk
                    LEFT JOIN jenis_tanah ON jenis_tanah.id_tanah = kalkulasi_dosis_pupuk.id_tanah
                    ORDER BY kalkulasi_dosis_pupuk.id_kalkulasi ASC";
        }

        $data['dosis'] = $this->db->query($sql)->result();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/kalkulator_pupuk/index', $data);
        $this->load->view('admin/templates/footer');
    }
}
