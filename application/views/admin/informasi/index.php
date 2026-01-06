<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header. (Page Header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $page_title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $page_title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">Daftar Informasi</h3>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?= base_url(uri: 'admin/informasi/tambah') ?>" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Tambah Data
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('message')): ?>
                                <div class="alert alert-<?= $this->session->flashdata('message_type') ?: 'info' ?> alert-dismissible fade show" role="alert">
                                    <?= $this->session->flashdata('message') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Search Bar -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Cari judul, kategori, atau penulis...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success w-100" type="button" id="searchBtn">
                                            <i class="fa fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($articles)): ?>
                                <div class="riwayat-table-wrapper">
                                    <table class="riwayat-table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 50px;"></th>
                                                <th style="text-align: center;">JUDUL</th>
                                                <th style="text-align: center;">KATEGORI</th>
                                                <th style="text-align: center;">PENULIS</th>
                                                <th style="text-align: center;">TANGGAL</th>
                                                <th style="width: 150px; text-align: center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($articles as $art): ?>
                                                <tr class="riwayat-row" data-id="<?= $art->id_info ?>">
                                                    <td>
                                                        <button class="expand-btn" data-target="detail-info-<?= $art->id_info ?>">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                    </td>
                                                    <td><strong><?= htmlspecialchars($art->judul) ?></strong></td>
                                                    <td>
                                                        <span class="badge badge-secondary"><?= htmlspecialchars($art->kategori ?: '-') ?></span>
                                                    </td>
                                                    <td><?= htmlspecialchars($art->penulis ?: '-') ?></td>
                                                    <td><?= date('d M Y', strtotime($art->tanggal)) ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= base_url('informasi/detail/' . $art->id_info) ?>" class="btn btn-sm btn-info" target="_blank" title="Lihat">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="<?= base_url(uri: 'admin/informasi/ubah/') ?><?= $art->id_info ?>" class="btn btn-sm btn-success" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="<?= base_url(uri: 'admin/informasi/hapus/') ?><?= $art->id_info ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="detail-row" id="detail-info-<?= $art->id_info ?>">
                                                    <td colspan="6">
                                                        <div class="detail-content">
                                                            <div class="detail-grid">
                                                                <?php if (!empty($art->gambar_header) || !empty($art->thumbnail)): ?>
                                                                    <div class="detail-item full-width">
                                                                        <div class="images-row">
                                                                            <?php if (!empty($art->gambar_header)): 
                                                                                $gambar_header = trim($art->gambar_header);
                                                                                // Handle different path formats
                                                                                if (strpos($gambar_header, 'assets/img/') !== false) {
                                                                                    $gambar_header = basename($gambar_header);
                                                                                }
                                                                                // Controller menyimpan di assets/img/articles/
                                                                                $gambar_header_url = base_url('assets/img/articles/' . $gambar_header);
                                                                            ?>
                                                                                <div class="image-item">
                                                                                    <span class="detail-label">Gambar Header:</span>
                                                                                    <div class="detail-value">
                                                                                        <img src="<?= $gambar_header_url ?>" alt="Header" style="max-width: 100%; height: auto; border-radius: 8px; margin-top: 0.5rem;" 
                                                                                             onerror="console.error('Gambar tidak ditemukan: <?= $gambar_header_url ?>'); this.style.display='none';">
                                                                                    </div>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                            <?php if (!empty($art->thumbnail)): 
                                                                                $thumbnail = trim($art->thumbnail);
                                                                                // Handle different path formats
                                                                                if (strpos($thumbnail, 'assets/img/') !== false) {
                                                                                    $thumbnail = basename($thumbnail);
                                                                                }
                                                                                // Controller menyimpan di assets/img/articles/
                                                                                $thumbnail_url = base_url('assets/img/articles/' . $thumbnail);
                                                                            ?>
                                                                                <div class="image-item">
                                                                                    <span class="detail-label">Thumbnail:</span>
                                                                                    <div class="detail-value">
                                                                                        <img src="<?= $thumbnail_url ?>" alt="Thumbnail" style="max-width: 100%; height: auto; border-radius: 8px; margin-top: 0.5rem;" 
                                                                                             onerror="console.error('Gambar tidak ditemukan: <?= $thumbnail_url ?>'); this.style.display='none';">
                                                                                    </div>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($art->konten)): ?>
                                                                    <div class="detail-item full-width">
                                                                        <span class="detail-label">Konten Lengkap:</span>
                                                                        <div class="detail-value" style="margin-top: 0.5rem; padding: 1rem; background: rgba(255, 255, 255, 0.9); border-radius: 8px; border: 1px solid rgba(27, 94, 32, 0.1); max-height: 250px; overflow-y: auto;">
                                                                            <?= $art->konten ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (empty($art->gambar_header) && empty($art->thumbnail) && empty($art->konten)): ?>
                                                                    <div class="detail-item full-width">
                                                                        <span class="detail-label">Tidak ada informasi tambahan</span>
                                                                        <div class="detail-value" style="color: var(--admin-text-light); font-style: italic;">
                                                                            Tidak ada gambar header, thumbnail, atau konten yang tersedia untuk artikel ini.
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <div class="empty-icon">📄</div>
                                    <h3>Belum Ada Informasi</h3>
                                    <p>Anda belum menambahkan informasi. Klik tombol "Tambah Data" untuk menambahkan informasi baru.</p>
                                    <a href="<?= base_url(uri: 'admin/informasi/tambah') ?>" class="btn btn-primary">Tambah Data</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
    <style>
    /* Hybrid Table Styles for Admin */
    :root {
        --admin-primary: #1B5E20;
        --admin-secondary: #2E7D32;
        --admin-accent: #388E3C;
        --admin-bg: #FAFAFA;
        --admin-text: #2c3e50;
        --admin-border: #e9ecef;
        --admin-text-light: #6c757d;
    }

    /* Card Header Styles */
    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
    }

    .card-header .row {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 0;
    }

    .card-header .col-md-6:first-child {
        flex: 1;
    }

    .card-header .col-md-6:last-child {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .card-title {
        font-weight: 700 !important;
        font-size: 1.5rem;
        color: var(--admin-text);
        margin: 0;
    }

    .input-group {
        display: flex;
        gap: 0.75rem;
        align-items: stretch;
    }
    
    .input-group .form-control {
        flex: 1;
        margin: 0;
        padding: 0.75rem 1.25rem !important;
        border-radius: 10px !important;
        border-top-right-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
        border-top-left-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
        border: 1px solid rgba(27, 94, 32, 0.2);
        font-size: 0.95rem !important;
        line-height: 1.5 !important;
        height: auto !important;
        min-height: 42px !important;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        background-image: none !important;
        background-position: unset !important;
        background-repeat: no-repeat !important;
        padding-left: 1.25rem !important;
    }
    
    .input-group .form-control::before,
    .input-group .form-control::after {
        display: none !important;
        content: none !important;
    }
    
    .input-group .form-control::-webkit-search-decoration,
    .input-group .form-control::-webkit-search-cancel-button,
    .input-group .form-control::-webkit-search-results-button,
    .input-group .form-control::-webkit-search-results-decoration {
        display: none !important;
    }
    
    .input-group .form-control:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 0.2rem rgba(27, 94, 32, 0.15), 0 2px 4px rgba(0, 0, 0, 0.05);
        outline: none;
        background-image: none !important;
    }
    
    /* Override CSS dari assets/css/admin/informasi.css */
    .card-body .input-group .form-control {
        background-image: none !important;
        padding-left: 1.25rem !important;
    }
    
    .card-body .input-group .form-control:focus {
        background-image: none !important;
    }
    
    .input-group-append {
        margin-left: 0;
        display: flex;
    }
    
    .input-group-append .btn,
    #searchBtn {
        margin: 0;
        padding: 0.75rem 1.5rem !important;
        border-radius: 10px !important;
        font-weight: 600;
        font-size: 0.95rem !important;
        line-height: 1.5 !important;
        height: auto !important;
        min-height: 42px !important;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 4px rgba(27, 94, 32, 0.2);
    }
    
    .input-group-append .btn:hover,
    #searchBtn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(27, 94, 32, 0.3);
    }

    .riwayat-table-wrapper {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 16px;
        border: 2px solid rgba(27, 94, 32, 0.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        overflow-x: auto;
        margin-top: 1rem;
    }

    .riwayat-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        table-layout: fixed;
    }

    .riwayat-table thead {
        background: linear-gradient(135deg, rgba(27, 94, 32, 0.1) 0%, rgba(46, 125, 50, 0.05) 100%);
    }

    .riwayat-table thead th {
        padding: 1rem;
        text-align: center;
        font-weight: 700;
        color: var(--admin-primary);
        font-size: 0.95rem;
        border-bottom: 2px solid rgba(27, 94, 32, 0.2);
        white-space: nowrap;
        position: relative;
    }
    
    .riwayat-table thead .filter-row {
        background: rgba(27, 94, 32, 0.05);
        border-bottom: 1px solid rgba(27, 94, 32, 0.1);
    }
    
    .riwayat-table thead .filter-row th {
        padding: 0.5rem;
        border-bottom: none;
        background: transparent;
    }
    
    .column-filter {
        width: 100%;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        border: 1px solid rgba(27, 94, 32, 0.2);
        border-radius: 6px;
        background: #fff;
        transition: all 0.2s ease;
    }
    
    .column-filter:focus {
        outline: none;
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 2px rgba(27, 94, 32, 0.1);
    }
    
    .column-filter::placeholder {
        color: rgba(27, 94, 32, 0.4);
        font-size: 0.8rem;
    }
    
    .riwayat-table thead th:first-child {
        width: 50px;
    }
    
    .riwayat-table thead th:last-child {
        width: 150px;
    }

    .riwayat-table tbody tr.riwayat-row {
        border-bottom: 1px solid rgba(27, 94, 32, 0.08);
        transition: all 0.3s ease;
    }

    .riwayat-table tbody tr.riwayat-row:hover {
        background: rgba(27, 94, 32, 0.03);
    }

    .riwayat-table tbody td {
        padding: 1rem;
        font-size: 0.95rem;
        color: var(--admin-text);
        vertical-align: middle;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    .riwayat-table tbody td:first-child {
        width: 50px;
        text-align: center;
    }
    
    /* Kolom JUDUL - kiri */
    .riwayat-table tbody td:nth-child(2) {
        text-align: left;
    }
    
    /* Kolom KATEGORI - center */
    .riwayat-table tbody td:nth-child(3) {
        text-align: center;
    }
    
    /* Kolom PENULIS - kiri */
    .riwayat-table tbody td:nth-child(4) {
        text-align: left;
    }
    
    /* Kolom TANGGAL - center */
    .riwayat-table tbody td:nth-child(5) {
        text-align: center;
    }
    
    .riwayat-table tbody td:last-child {
        width: 150px;
        text-align: center;
    }
    
    .riwayat-table tbody td .badge {
        display: inline-block;
    }

    .expand-btn {
        background: transparent;
        border: none;
        color: var(--admin-primary);
        font-size: 1.1rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        position: relative;
        z-index: 10;
    }
    
    .expand-btn * {
        pointer-events: none;
    }

    .expand-btn:hover {
        background: rgba(27, 94, 32, 0.05);
        transform: scale(1.1);
    }

    .expand-btn.expanded i {
        transform: rotate(180deg);
    }

    .expand-btn i {
        transition: transform 0.3s ease;
        display: block;
        font-size: 1.2rem;
    }

    .detail-row {
        display: none;
        background: linear-gradient(135deg, rgba(27, 94, 32, 0.02) 0%, rgba(46, 125, 50, 0.01) 100%);
        border-bottom: 2px solid rgba(27, 94, 32, 0.1);
    }

    .detail-row.expanded {
        display: table-row;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            max-height: 0;
        }
        to {
            opacity: 1;
            max-height: 500px;
        }
    }

    .detail-row td {
        padding: 0 !important;
        border: none !important;
    }
    
    .detail-row td > div {
        width: 100%;
        box-sizing: border-box;
    }

    .detail-content {
        padding: 1.5rem;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 12px;
        border: 1px solid rgba(27, 94, 32, 0.1);
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        background: rgba(255, 255, 255, 1);
        border-color: rgba(27, 94, 32, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .images-row {
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
    }

    .images-row .image-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .images-row .image-item:first-child {
        margin-right: 0.75rem;
    }

    .images-row .image-item:last-child {
        margin-left: 0.75rem;
    }

    @media (max-width: 768px) {
        .images-row {
            flex-direction: column;
            gap: 1rem;
        }
        
        .images-row .image-item:first-child,
        .images-row .image-item:last-child {
            margin: 0;
        }
    }

    .detail-label {
        font-weight: 600;
        color: var(--admin-text);
        font-size: 0.9rem;
    }

    .detail-value {
        font-weight: 500;
        color: var(--admin-primary);
        font-size: 1rem;
    }

    .detail-value img {
        display: block;
        margin-top: 0.5rem;
    }

    .detail-value div {
        line-height: 1.6;
        color: var(--admin-text);
    }

    .detail-value div p {
        margin-bottom: 0.75rem;
    }

    .detail-value div p:last-child {
        margin-bottom: 0;
    }


    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, rgba(27, 94, 32, 0.03) 0%, rgba(46, 125, 50, 0.01) 100%);
        border-radius: 16px;
        border: 2px dashed rgba(27, 94, 32, 0.2);
        margin-top: 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-primary);
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        font-size: 1rem;
        color: var(--admin-text-light);
        margin-bottom: 1.5rem;
    }
    </style>
    
    <script>
    // Use vanilla JavaScript for expand/collapse (works immediately)
    (function() {
        'use strict';
        
        function handleExpandClick(e) {
            // Check if clicked element is expand button or inside it
            var expandBtn = e.target.closest('.expand-btn');
            if (!expandBtn) {
                // Also check if clicked on the icon inside
                if (e.target.classList.contains('fa-chevron-down') || e.target.closest('.fa-chevron-down')) {
                    expandBtn = e.target.closest('button.expand-btn') || e.target.parentElement.closest('.expand-btn');
                }
            }
            
            if (!expandBtn) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            var targetId = expandBtn.getAttribute('data-target');
            
            if (!targetId) {
                console.error('No target found for expand button');
                return;
            }
            
            var detailRow = document.getElementById(targetId);
            
            if (!detailRow) {
                console.error('Detail row not found:', targetId);
                return;
            }
            
            var isExpanded = detailRow.classList.contains('expanded');
            
            if (isExpanded) {
                // Collapse
                detailRow.classList.remove('expanded');
                expandBtn.classList.remove('expanded');
            } else {
                // Expand - close others first
                var expandedRows = document.querySelectorAll('.detail-row.expanded');
                expandedRows.forEach(function(row) {
                    row.classList.remove('expanded');
                });
                
                var expandedBtns = document.querySelectorAll('.expand-btn.expanded');
                expandedBtns.forEach(function(b) {
                    b.classList.remove('expanded');
                });
                
                // Expand this one
                detailRow.classList.add('expanded');
                expandBtn.classList.add('expanded');
            }
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                // Use event delegation on tbody
                var tbody = document.querySelector('.riwayat-table tbody');
                if (tbody) {
                    tbody.addEventListener('click', handleExpandClick);
                }
                
                // Also attach directly to all buttons as backup
                var expandButtons = document.querySelectorAll('.expand-btn');
                expandButtons.forEach(function(btn) {
                    btn.addEventListener('click', handleExpandClick);
                });
            });
        } else {
            // DOM already loaded
            var tbody = document.querySelector('.riwayat-table tbody');
            if (tbody) {
                tbody.addEventListener('click', handleExpandClick);
            }
            
            var expandButtons = document.querySelectorAll('.expand-btn');
            expandButtons.forEach(function(btn) {
                btn.addEventListener('click', handleExpandClick);
            });
        }
    })();
    
    // Column Filter Functionality
    (function() {
        'use strict';
        
        function initColumnFilters() {
            var filterInputs = document.querySelectorAll('.column-filter');
            
            filterInputs.forEach(function(input) {
                input.addEventListener('keyup', function() {
                    var columnIndex = parseInt(this.getAttribute('data-column'));
                    var filterValue = this.value.toLowerCase().trim();
                    var table = this.closest('.riwayat-table');
                    var rows = table.querySelectorAll('tbody tr.riwayat-row');
                    
                    rows.forEach(function(row) {
                        var cell = row.cells[columnIndex];
                        if (cell) {
                            var cellText = cell.textContent.toLowerCase().trim();
                            if (cellText.includes(filterValue)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                                // Hide detail row if main row is hidden
                                var rowId = row.getAttribute('data-id');
                                if (rowId) {
                                    var detailRow = document.getElementById('detail-info-' + rowId);
                                    if (detailRow) {
                                        detailRow.style.display = 'none';
                                        detailRow.classList.remove('expanded');
                                        var expandBtn = row.querySelector('.expand-btn');
                                        if (expandBtn) {
                                            expandBtn.classList.remove('expanded');
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
                
                // Clear filter on input clear
                input.addEventListener('input', function() {
                    if (this.value.trim() === '') {
                        var table = this.closest('.riwayat-table');
                        var rows = table.querySelectorAll('tbody tr.riwayat-row');
                        rows.forEach(function(row) {
                            row.style.display = '';
                        });
                    }
                });
            });
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initColumnFilters);
        } else {
            initColumnFilters();
        }
    })();
        
        // Search functionality (wait for jQuery)
        function initSearch() {
            if (typeof jQuery !== 'undefined') {
                jQuery(document).ready(function($) {
                    $('#searchBtn').on('click', function() {
                        var keyword = $('#searchInput').val().toLowerCase();
                        searchInPage(keyword);
                    });
                    
                    $('#searchInput').on('keyup', function(e) {
                        if (e.key === 'Enter') {
                            var keyword = $(this).val().toLowerCase();
                            searchInPage(keyword);
                        }
                    });
                    
                    function searchInPage(keyword) {
                        var found = false;
                        $('tbody tr.riwayat-row').each(function() {
                            var text = $(this).text().toLowerCase();
                            if (text.indexOf(keyword) > -1) {
                                $(this).show();
                                found = true;
                            } else {
                                $(this).hide();
                                var id = $(this).data('id');
                                $('#detail-info-' + id).hide().removeClass('expanded');
                            }
                        });
                        
                        if (!found && keyword !== '') {
                            if ($('#no-results').length === 0) {
                                $('tbody').append('<tr id="no-results"><td colspan="6" class="text-center py-4"><p class="text-muted mb-0">Tidak ada hasil ditemukan</p></td></tr>');
                            }
                        } else {
                            $('#no-results').remove();
                        }
                    }
                });
            } else {
                setTimeout(initSearch, 100);
            }
        }
        
        initSearch();
    </script>
