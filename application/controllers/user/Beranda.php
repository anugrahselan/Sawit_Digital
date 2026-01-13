<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Harga_tbs_model');
        $this->load->model('Informasi_tambahan_model');
    }

    public function index()
    {
        $data['page_title'] = 'Beranda - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/beranda.css';
        $data['page_js'] = 'user/beranda.js';

        $data['articles'] = $this->Informasi_tambahan_model->get_all();

        $daftar_harga_tbs = $this->Harga_tbs_model->get_harga_hari_ini();

        if (empty($daftar_harga_tbs)) {
            $daftar_harga_tbs = $this->Harga_tbs_model->get_terbaru_per_perusahaan();
        }

        foreach ($daftar_harga_tbs as $harga) {
            $harga_sebelumnya = $this->Harga_tbs_model->get_harga_sebelumnya(
                $harga->id_kabupaten,
                $harga->id_perusahaan,
                $harga->tanggal
            );

            if ($harga_sebelumnya) {
                $selisih = $harga->harga_per_kg - $harga_sebelumnya->harga_per_kg;
                $harga->perubahan = $selisih;
                $harga->status_perubahan = $selisih > 0 ? 'naik' : ($selisih < 0 ? 'turun' : 'tidak_ada');
                $harga->harga_kemarin = $harga_sebelumnya->harga_per_kg;
            } else {
                $harga->perubahan = null;
                $harga->status_perubahan = 'tidak_ada';
                $harga->harga_kemarin = null;
            }
        }

        $data['tbs_prices'] = $daftar_harga_tbs;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/beranda/index', $data);
        $this->load->view('user/templates/footer');
    }
}
