<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencarian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Informasi_tambahan_model');
        $this->load->model('Jenis_pupuk_model');
        $this->load->model('Penyakit_model');
    }

    public function index()
    {
        $kata_kunci = $this->input->get('q');
        if (empty($kata_kunci)) {
            redirect('beranda');
        }

        $data['page_title'] = 'Hasil Pencarian - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/informasi.css';
        $data['keyword'] = $kata_kunci;
        $data['articles'] = $this->Informasi_tambahan_model->cari($kata_kunci);
        $data['fertilizers'] = $this->Jenis_pupuk_model->cari($kata_kunci);
        $data['penyakit'] = $this->Penyakit_model->cari($kata_kunci);

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/pencarian/hasil', $data);
        $this->load->view('user/templates/footer');
    }
}