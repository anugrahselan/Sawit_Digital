<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencarian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Informasi_tambahan_model');
        $this->load->model('Jenis_pupuk_model');
    }

    public function index()
    {
        $keyword = $this->input->get('q');
        if (empty($keyword)) {
            redirect('beranda');
        }

        $data['page_title'] = 'Hasil Pencarian - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/informasi.css';
        $data['keyword'] = $keyword;
        $data['articles'] = $this->Informasi_tambahan_model->search($keyword);
        $data['fertilizers'] = $this->Jenis_pupuk_model->search($keyword);

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/pencarian/hasil', $data);
        $this->load->view('user/templates/footer');
    }
}

