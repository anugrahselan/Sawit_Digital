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
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="<?= site_url('admin/dashboard') ?>" class="sidebar-logo">
                    <i class="bi bi-tree-fill"></i>
                    <span class="logo-text">Sawit Digital</span>
                </a>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="<?= site_url('admin/dashboard') ?>" class="nav-link <?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/pupuk') ?>" class="nav-link <?= strpos(uri_string(), 'admin/pupuk') !== false ? 'active' : '' ?>">
                            <i class="bi bi-flower1"></i>
                            <span>Jenis Pupuk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/penyakit') ?>" class="nav-link <?= strpos(uri_string(), 'admin/penyakit') !== false ? 'active' : '' ?>">
                            <i class="bi bi-bug"></i>
                            <span>Jenis Penyakit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/kabupaten') ?>" class="nav-link <?= strpos(uri_string(), 'admin/kabupaten') !== false ? 'active' : '' ?>">
                            <i class="bi bi-geo-alt"></i>
                            <span>Kabupaten</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/perusahaan') ?>" class="nav-link <?= strpos(uri_string(), 'admin/perusahaan') !== false ? 'active' : '' ?>">
                            <i class="bi bi-building"></i>
                            <span>Perusahaan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/informasi') ?>" class="nav-link <?= strpos(uri_string(), 'admin/informasi') !== false ? 'active' : '' ?>">
                            <i class="bi bi-file-text"></i>
                            <span>Informasi Tambahan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/harga_tbs') ?>" class="nav-link <?= strpos(uri_string(), 'admin/harga_tbs') !== false ? 'active' : '' ?>">
                            <i class="bi bi-currency-dollar"></i>
                            <span>Harga TBS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/tanah') ?>" class="nav-link <?= strpos(uri_string(), 'admin/tanah') !== false ? 'active' : '' ?>">
                            <i class="bi bi-moisture"></i>
                            <span>Jenis Tanah</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/kalkulator_panen') ?>" class="nav-link <?= strpos(uri_string(), 'admin/kalkulator_panen') !== false ? 'active' : '' ?>">
                            <i class="bi bi-calculator"></i>
                            <span>Kalkulasi Panen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/kalkulator_pupuk') ?>" class="nav-link <?= strpos(uri_string(), 'admin/kalkulator_pupuk') !== false ? 'active' : '' ?>">
                            <i class="bi bi-calculator"></i>
                            <span>Kalkulasi Pupuk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/pupuk') ?>" class="nav-link <?= strpos(uri_string(), 'admin/pupuk') !== false ? 'active' : '' ?>">
                            <i class="bi bi-box-seam"></i>
                            <span>Jenis Pupuk</span>
                        </a>
                    </li>
                    <?php if ($this->session->userdata('user_role') == 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/users') ?>" class="nav-link <?= strpos(uri_string(), 'admin/users') !== false ? 'active' : '' ?>">
                            <i class="bi bi-people"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="sidebar-toggle-mobile" id="sidebarToggleMobile">
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
                        <form action="<?= site_url('admin/search') ?>" method="get" class="search-form">
                            <input type="text" name="q" class="form-control" placeholder="Cari..." value="<?= $this->input->get('q') ?>">
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
