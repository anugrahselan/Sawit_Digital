<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bantuan extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function pusat_bantuan() {
        $data['page_title'] = 'Pusat Bantuan - Sawit Digital';
        $data['page_css'] = 'user/bantuan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/bantuan/pusat_bantuan', $data);
        $this->load->view('user/templates/footer');
    }

    public function faq() {
        $data['page_title'] = 'FAQ - Sawit Digital';
        $data['page_css'] = 'user/bantuan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/bantuan/faq', $data);
        $this->load->view('user/templates/footer');
    }

    public function syarat_ketentuan() {
        $data['page_title'] = 'Syarat & Ketentuan - Sawit Digital';
        $data['page_css'] = 'user/bantuan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/bantuan/syarat_ketentuan', $data);
        $this->load->view('user/templates/footer');
    }

    public function kebijakan_privasi() {
        $data['page_title'] = 'Kebijakan Privasi - Sawit Digital';
        $data['page_css'] = 'user/bantuan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/bantuan/kebijakan_privasi', $data);
        $this->load->view('user/templates/footer');
    }

    public function hubungi_kami() {
        $data['page_title'] = 'Hubungi Kami - Sawit Digital';
        $data['page_css'] = 'user/bantuan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/bantuan/hubungi_kami', $data);
        $this->load->view('user/templates/footer');
    }
}

