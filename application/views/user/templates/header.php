<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Sistem Penyuluhan Sawit' ?></title>
    <?php $cache = '?v=' . time(); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/global.css') . $cache; ?>" rel="stylesheet">
    <?php if (isset($page_css) && !empty($page_css)): ?>
        <link href="<?= base_url('assets/css/' . $page_css) . $cache; ?>" rel="stylesheet">
    <?php endif; ?>
    <script src="<?= base_url('assets/js/user/dropdown.js') ?>" defer></script>
    <script src="<?= base_url('assets/js/user/pencarian.js') ?>" defer></script>
</head>

<body>

    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="<?= site_url('beranda') ?>" class="logo-link">
                    <?php
                    $logo = '';

                    $logo_formats = ['logo.png', 'logo.svg', 'logo.jpg', 'logo.jpeg', 'logo.webp'];
                    foreach ($logo_formats as $format) {
                        $logo_path = FCPATH . 'assets/img/logo/' . $format;
                        if (file_exists($logo_path)) {
                            $logo = base_url('assets/img/logo/' . $format);
                            break;
                        }
                    }
                    if ($logo): ?>
                        <img src="<?= $logo ?>" alt="Sawit Digital" class="logo-image">
                        <span class="logo-text">Sawit Digital</span>
                    <?php else: ?>
                        <span class="logo-text">Sawit Digital</span>
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
                        <li><a href="<?= site_url('penyakit') ?>">Jenis Penyakit</a></li>
                    </ul>
                </li>
                <li><a href="<?= site_url('informasi') ?>">Informasi</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Profil <span class="arrow">▼</span></a>
                    <ul class="dropdown-menu">
                        <?php if ($this->session->userdata('id_user')): ?>
                            <li>
                                <a href="<?= site_url('profil') ?>" class="user-profile-link">
                                    <?php
                                    $foto = $this->session->userdata('foto_profil');
                                    $foto_url = base_url('assets/img/users/default.png');
                                    if (!empty($foto)):
                                        $foto = strpos($foto, 'assets/img/users/') !== false ? basename($foto) : basename(trim($foto));
                                        $foto_url = base_url('assets/img/users/' . $foto);
                                    endif;
                                    ?>
                                    <img src="<?= $foto_url ?>" alt="Profile" class="user-avatar"
                                        onerror="this.src='<?= base_url('assets/img/users/default.png') ?>'">
                                    <span class="user-name"><?= $this->session->userdata('nama_lengkap') ?></span>
                                </a>
                            </li>
                            <?php

                            $user_role = $this->session->userdata('role');
                            if ($user_role === 'admin'):
                                ?>
                                <li><a href="<?= site_url('admin/dashboard') ?>">Kembali ke Admin</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <?php endif; ?>
                            <li><a href="<?= site_url('riwayat') ?>">Riwayat Kalkulasi</a></li>
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

    $current_uri = uri_string();
    $is_beranda = false;

    if ($current_uri == 'beranda' || $current_uri == '' || $current_uri == 'index.php' || $current_uri == 'Home' || strpos($current_uri, 'beranda') === 0) {
        $is_beranda = true;
    }

    if (isset($show_hero)) {
        $is_beranda = (bool) $show_hero;
    }

    if ($is_beranda):
        ?>
        <section class="hero-banner" <?php
        $hero = '';
        $exts = ['webp', 'jpg', 'png'];
        foreach ($exts as $ext) {
            if (file_exists(FCPATH . 'assets/img/hero/hero-banner.' . $ext)) {
                $hero = base_url('assets/img/hero/hero-banner.' . $ext);
                break;
            }
        }
        if ($hero)
            echo ' style="background-image: url(\'' . $hero . '\');"';
        ?>>
            <div class="hero-overlay"></div>
            <div class="container">
                <h1 class="hero-title">Sistem Penyuluhan Sawit Digital</h1>
                <p class="hero-subtitle">Platform lengkap untuk petani sawit mendapatkan informasi, kalkulator, dan edukasi
                    terbaik</p>
            </div>
        </section>

        <section class="search-section">
            <div class="container">
                <form class="search-form" id="searchForm">
                    <input type="text" name="q" placeholder="Cari artikel, pupuk, atau informasi..." class="search-input"
                        id="searchInput" autocomplete="off">
                    <button type="submit" class="btn btn-search">Cari</button>
                </form>
                <div id="searchResults" style="display: none;">
                    <div id="searchResultsContent"></div>
                </div>
            </div>
        </section>
    <?php endif; ?>