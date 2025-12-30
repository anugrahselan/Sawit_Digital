<!-- Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="<?= site_url('admin/dashboard') ?>" class="sidebar-logo">
            <img src="<?= base_url('assets/img/logo/logo.png') ?>" alt="Sawit Digital" class="logo-image">
            <span class="logo-text">Sawit Digital</span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?= site_url('admin/dashboard') ?>"
                    class="nav-link <?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/pupuk') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/pupuk') !== false ? 'active' : '' ?>">
                    <i class="bi bi-flower1"></i>
                    <span>Jenis Pupuk</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/penyakit') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/penyakit') !== false ? 'active' : '' ?>">
                    <i class="bi bi-bug"></i>
                    <span>Jenis Penyakit</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/kabupaten') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/kabupaten') !== false ? 'active' : '' ?>">
                    <i class="bi bi-geo-alt"></i>
                    <span>Kabupaten</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/perusahaan') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/perusahaan') !== false ? 'active' : '' ?>">
                    <i class="bi bi-building"></i>
                    <span>Perusahaan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/informasi') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/informasi') !== false ? 'active' : '' ?>">
                    <i class="bi bi-file-text"></i>
                    <span>Informasi Tambahan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/harga_tbs') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/harga_tbs') !== false ? 'active' : '' ?>">
                    <i class="bi bi-currency-dollar"></i>
                    <span>Harga TBS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/tanah') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/tanah') !== false ? 'active' : '' ?>">
                    <i class="bi bi-moisture"></i>
                    <span>Jenis Tanah</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/kalkulator_panen') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/kalkulator_panen') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calculator"></i>
                    <span>Kalkulasi Panen</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/kalkulator_pupuk') ?>"
                    class="nav-link <?= strpos(uri_string(), 'admin/kalkulator_pupuk') !== false ? 'active' : '' ?>">
                    <i class="bi bi-calculator"></i>
                    <span>Kalkulasi Pupuk</span>
                </a>
            </li>
            <?php if ($this->session->userdata('user_role') == 'admin'): ?>
                <li class="nav-item">
                    <a href="<?= site_url('admin/users') ?>"
                        class="nav-link <?= strpos(uri_string(), 'admin/users') !== false ? 'active' : '' ?>">
                        <i class="bi bi-people"></i>
                        <span>Users</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</aside>