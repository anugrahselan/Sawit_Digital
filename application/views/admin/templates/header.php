<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Admin Dashboard' ?> - Sawit Digital</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <!-- Custom Admin CSS -->
    <link href="<?= base_url('assets/css/admin/main.css') ?>" rel="stylesheet">
    
    <?php if (isset($page_css)): ?>
        <link href="<?= base_url('assets/css/admin/' . $page_css) ?>" rel="stylesheet">
    <?php endif; ?>
</head>
<body>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/templates/sidebar'); ?>
        
        <!-- Main Content -->
        <div class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="sidebar-toggle-btn" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <?php if (isset($breadcrumbs)): ?>
                                <?php foreach ($breadcrumbs as $index => $crumb): ?>
                                    <?php if ($index == count($breadcrumbs) - 1): ?>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $crumb['label'] ?></li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item"><a href="<?= $crumb['url'] ?>"><?= $crumb['label'] ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="breadcrumb-item active">Dashboard</li>
                            <?php endif; ?>
                        </ol>
                    </nav>
                </div>
                
                <div class="header-right">
                    <!-- Global Search -->
                    <div class="header-search">
                        <form id="adminSearchForm" class="search-form">
                            <input type="text" id="adminSearchInput" class="form-control" placeholder="Cari di halaman ini..." autocomplete="off">
                            <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="dropdown user-menu">
                        <button class="btn btn-link dropdown-toggle" type="button" id="userMenuDropdown" data-bs-toggle="dropdown">
                            <?php
                            $foto_profil = $this->session->userdata('foto_profil');
                            if (!empty($foto_profil)) {
                                $foto_profil = trim($foto_profil);
                                // Jika path sudah lengkap (sudah ada assets/img/users/), ambil hanya nama file
                                if (strpos($foto_profil, 'assets/img/users/') !== false) {
                                    $foto_profil = basename($foto_profil);
                                } else {
                                    $foto_profil = basename($foto_profil);
                                }
                                $foto_url = base_url('assets/img/users/' . $foto_profil);
                            } else {
                                $foto_url = base_url('assets/img/users/default.png');
                            }
                            ?>
                            <img src="<?= $foto_url ?>" 
                                 alt="User" class="user-avatar" 
                                 onerror="this.src='<?= base_url('assets/img/users/default.png') ?>'">
                            <span class="user-name"><?= $this->session->userdata('user_name') ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= site_url('admin/profile') ?>"><i class="bi bi-person"></i> Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= site_url('beranda') ?>"><i class="bi bi-house"></i> Kembali ke Beranda</a></li>
                            <li><a class="dropdown-item text-danger" href="<?= site_url('admin/logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </header>
            
            <!-- Content Area -->
            <main class="admin-content">
                <!-- Search Results -->
                <div id="adminSearchResults" class="alert alert-info" style="display: none; margin-bottom: 1rem;">
                    <div id="adminSearchResultsContent"></div>
                </div>
                
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('warning')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?= $this->session->flashdata('warning') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
