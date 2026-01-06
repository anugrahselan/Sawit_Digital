<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Home Controller - Wrapper untuk redirect ke user/Beranda
// CodeIgniter 3 tidak mendukung subfolder di default_controller
class Home extends CI_Controller
{
    public function index(): void
    {
        // Redirect ke user/Beranda
        redirect('beranda');
    }
}



