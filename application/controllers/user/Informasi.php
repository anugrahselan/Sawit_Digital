<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Informasi_tambahan_model');
    }

    public function index()
    {
        $data['page_title'] = 'Informasi & Edukasi - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/informasi.css';
        $data['page_js'] = 'user/informasi.js';
        $data['articles'] = $this->Informasi_tambahan_model->get_all();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/informasi/index', $data);
        $this->load->view('user/templates/footer');
    }

    public function detail_informasi($id = null)
    {
        if (!$id)
            show_404();

        $informasi = $this->Informasi_tambahan_model->get_by_id($id);
        if (!$informasi)
            show_404();

        $data['page_title'] = $informasi['judul'] . ' - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/informasi.css';
        $data['article'] = $informasi;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/informasi/detail', $data);
        $this->load->view('user/templates/footer');
    }
}
