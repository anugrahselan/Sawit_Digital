<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Penyakit_model');
        $this->load->database();
    }

    public function index() {
        $data['page_title'] = 'Jenis Penyakit Sawit - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/penyakit.css';
        $data['penyakit'] = $this->Penyakit_model->get_all();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/penyakit/index', $data);
        $this->load->view('user/templates/footer');
    }

    public function detail($id = null) {
        if ($id !== null) {
            $id = (int) $id;
        }
        
        if (!$id || $id <= 0) {
            show_404();
        }

        $penyakit = $this->Penyakit_model->get_by_id($id);
        if (!$penyakit) {
            show_404();
        }

        $data['page_title'] = $penyakit->nama_penyakit . ' - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/penyakit.css';
        $data['penyakit'] = $penyakit;

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/penyakit/detail', $data);
        $this->load->view('user/templates/footer');
    }
}

