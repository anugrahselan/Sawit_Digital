<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil_perusahaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function tentang_kami(): void
    {
        $data['page_title'] = 'Tentang Kami - Sawit Digital';
        $data['page_css'] = 'user/perusahaan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/perusahaan/tentang_kami', $data);
        $this->load->view('user/templates/footer');
    }

    /**
     * @return void
     */
    public function visi_misi(): void
    {
        $data['page_title'] = 'Visi & Misi - Sawit Digital';
        $data['page_css'] = 'user/perusahaan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/perusahaan/visi_misi', $data);
        $this->load->view('user/templates/footer');
    }

    /**
     * @return void
     */
    public function mitra_kerjasama(): void
    {
        $data['page_title'] = 'Mitra Kerjasama - Sawit Digital';
        $data['page_css'] = 'user/perusahaan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/perusahaan/mitra_kerjasama', $data);
        $this->load->view('user/templates/footer');
    }

    /**
     * @return void
     */
    public function program(): void
    {
        $data['page_title'] = 'Program - Sawit Digital';
        $data['page_css'] = 'user/perusahaan.css';

        $this->load->view('user/templates/header', $data);
        $this->load->view('user/perusahaan/program', $data);
        $this->load->view('user/templates/footer');
    }
}



