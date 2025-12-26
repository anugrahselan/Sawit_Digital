<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyakit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $data['page_title'] = 'Penyakit Sawit - Sistem Penyuluhan Sawit';
        $data['page_css'] = 'user/penyakit.css';
        $data['penyakit'] = $this->db->get('jenis_penyakit')->result();

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/penyakit/index', $data);
        $this->load->view('user/templates/footer');
    }
}

