<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Sistem Penyuluhan Sawit' ?></title>
    <?php $cache = '?v=' . time(); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css') . $cache; ?>">
    <?php if (!empty($page_css)): ?>
        <link rel="stylesheet" href="<?= base_url('assets/css/' . $page_css) . $cache; ?>">
    <?php endif; ?>
    <script src="<?= base_url('assets/js/user/dropdown.js') ?>" defer></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="<?= site_url('beranda') ?>" class="logo-link">
                    <?php
                    $logo = '';
                    if (file_exists(FCPATH . 'assets/img/logo/logo.png')) {
                        $logo = base_url('assets/img/logo/logo.png');
                    } elseif (file_exists(FCPATH . 'assets/img/logo/logo.svg')) {
                        $logo = base_url('assets/img/logo/logo.svg');
                    }
                    if ($logo): ?>
                        <img src="<?= $logo ?>" alt="Sawit Digital" class="logo-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                        <span class="logo-text" style="display: none;">🌴 Sawit Digital</span>
                    <?php else: ?>
                        <span class="logo-text">🌴 Sawit Digital</span>
                    <?php endif; ?>
                </a>
            </div>
            <ul class="navbar-menu">
                <li><a href="<?= site_url('beranda') ?>">Beranda</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Fitur <span class="arrow">▼</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= site_url('kalkulator-pupuk') ?>">Kalkulator Pupuk</a></li>
                        <li><a href="<?= site_url('kalkulator-panen') ?>">Kalkulator Panen</a></li>
                        <li><a href="<?= site_url('jenis-pupuk') ?>">Jenis Pupuk</a></li>
                        <li><a href="<?= site_url('penyakit') ?>">Penyakit</a></li>
                    </ul>
                </li>
                <li><a href="<?= site_url('informasi') ?>">Informasi</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Profil <span class="arrow">▼</span></a>
                    <ul class="dropdown-menu">
                        <?php if ($this->session->userdata('user_id')): ?>
                            <li>
                                <a href="#" class="user-profile-link">
                                    <?php
                                    $foto = $this->session->userdata('foto_profil');
                                    if (!empty($foto)):
                                        $foto = strpos($foto, 'assets/img/users/') !== false ? basename($foto) : basename(trim($foto));
                                        ?>
                                        <img src="<?= base_url('assets/img/users/' . $foto) ?>" alt="Profile" class="user-avatar" onerror="this.style.display='none';">
                                    <?php endif; ?>
                                    <span class="user-name"><?= $this->session->userdata('user_name') ?></span>
                                </a>
                            </li>
                            <?php 
                            // Jika admin/penyuluh, tampilkan link ke admin
                            $user_role = $this->session->userdata('user_role');
                            if (in_array($user_role, ['admin', 'penyuluh'])): 
                            ?>
                                <li><a href="<?= site_url('admin/dashboard') ?>">Kembali ke Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li><a href="<?= site_url('keluar') ?>">Keluar</a></li>
                        <?php else: ?>
                            <li><a href="<?= site_url('masuk') ?>">Masuk</a></li>
                            <li><a href="<?= site_url('daftar') ?>">Daftar</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <?php 
    // Tampilkan hero banner dan search bar hanya di halaman beranda
    $current_uri = uri_string();
    $is_beranda = false;
    
    // Cek apakah ini halaman beranda
    if ($current_uri == 'beranda' || $current_uri == '' || $current_uri == 'index.php' || $current_uri == 'Home' || strpos($current_uri, 'beranda') === 0) {
        $is_beranda = true;
    }
    
    // Override dengan variabel $show_hero jika ada
    if (isset($show_hero)) {
        $is_beranda = (bool)$show_hero;
    }
    
    if ($is_beranda): 
    ?>
    <section class="hero-banner"<?php
    $hero = '';
    $exts = ['webp', 'jpg', 'png'];
    foreach ($exts as $ext) {
        if (file_exists(FCPATH . 'assets/img/hero/hero-banner.' . $ext)) {
            $hero = base_url('assets/img/hero/hero-banner.' . $ext);
            break;
        }
    }
    if ($hero) echo ' style="background-image: url(\'' . $hero . '\');"';
    ?>>
        <div class="hero-overlay"></div>
        <div class="container">
            <h1 class="hero-title">Sistem Penyuluhan Sawit Digital</h1>
            <p class="hero-subtitle">Platform lengkap untuk petani sawit mendapatkan informasi, kalkulator, dan edukasi
                terbaik</p>
            <a href="<?= site_url('daftar') ?>" class="btn btn-primary hero-register-btn" style="position: relative; z-index: 10; pointer-events: auto; cursor: pointer; text-decoration: none; display: inline-block;">Daftar Gratis</a>
        </div>
    </section>

    <!-- Search Bar -->
    <section class="search-section">
        <div class="container">
            <form action="<?= site_url('pencarian') ?>" method="get" class="search-form" id="searchForm">
                <input type="text" name="q" placeholder="Cari artikel, pupuk, atau informasi..." class="search-input"
                    id="searchInput">
                <button type="submit" class="btn btn-search">Cari</button>
            </form>
        </div>
    </section>
    <?php endif; ?>