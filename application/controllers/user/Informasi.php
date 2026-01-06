<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Informasi_tambahan_model');
    }

    public function index(): void {
        $data['page_title'] = 'Informasi & Edukasi - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/informasi.css';
        $data['page_js'] = 'user/informasi.js';

        // Ambil semua artikel tanpa pagination
        $data['articles'] = $this->Informasi_tambahan_model->get_all();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/informasi/index', $data);
        $this->load->view('user/templates/footer');
    }

    public function detail($id = null): void {
        if (!$id) show_404();

        $article = $this->Informasi_tambahan_model->get_by_id($id);
        if (!$article) show_404();

        $data['page_title'] = $article->judul . ' - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/informasi.css';
        $data['article'] = $article;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/informasi/detail', $data);
        $this->load->view('user/templates/footer');
    }
}
