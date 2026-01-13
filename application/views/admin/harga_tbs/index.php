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
                            <div class="row" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div class="col-md-6" style="flex: 1;">
                                    <h3 class="card-title" style="font-weight: 700; font-size: 1.5rem; margin: 0;">Daftar Harga TBS</h3>
                                </div>
                                <div class="col-md-6 text-right" style="display: flex; justify-content: flex-end; align-items: center; flex: 1;">
                                    <a href="<?= base_url(uri: 'admin/harga_tbs/tambah') ?>" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Tambah Data
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('message')): 
                                $message_type = $this->session->flashdata('message_type') ?: 'success';
                                $icon = '';
                                if ($message_type == 'success') {
                                    $icon = '<i class="bi bi-check-circle me-2"></i>';
                                } elseif ($message_type == 'danger') {
                                    $icon = '<i class="bi bi-exclamation-circle me-2"></i>';
                                } elseif ($message_type == 'warning') {
                                    $icon = '<i class="bi bi-exclamation-triangle me-2"></i>';
                                } else {
                                    $icon = '<i class="bi bi-check-circle me-2"></i>';
                                    $message_type = 'success';
                                }
                            ?>
                                <div class="alert alert-<?= $message_type ?> alert-dismissible fade show mb-3" role="alert">
                                    <?= $icon ?><?= $this->session->flashdata('message') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Search Bar -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Cari tanggal, kabupaten, perusahaan, atau harga...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success w-100" type="button" id="searchBtn">
                                            <i class="fa fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($prices)): ?>
                                <div class="riwayat-table-wrapper">
                                    <table class="riwayat-table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">NO</th>
                                                <th style="text-align: center;">TANGGAL</th>
                                                <th style="text-align: center;">KABUPATEN</th>
                                                <th style="text-align: center;">PERUSAHAAN</th>
                                                <th style="text-align: center;">HARGA/KG</th>
                                                <th style="width: 150px; text-align: center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($prices as $price): ?>
                                                <tr class="riwayat-row" data-id="<?= $price->id_harga ?>">
                                                    <td style="text-align: center;"><?= $i ?></td>
                                                    <td style="text-align: center;"><?= date('d M Y', strtotime($price->tanggal)) ?></td>
                                                    <td style="text-align: center;"><?= htmlspecialchars($price->nama_kabupaten ?: '-') ?></td>
                                                    <td style="text-align: center;"><?= htmlspecialchars($price->nama_perusahaan ?: '-') ?></td>
                                                    <td style="text-align: center;"><strong>Rp <?= number_format($price->harga_per_kg, 0, ',', '.') ?></strong></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= base_url(uri: 'admin/harga_tbs/ubah/') ?><?= $price->id_harga ?>" class="btn btn-sm btn-success" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="<?= base_url(uri: 'admin/harga_tbs/hapus/') ?><?= $price->id_harga ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <?php if (isset($pagination_links)): ?>
                                    <div class="mt-3">
                                        <?= $pagination_links ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="empty-state">
                                    <div class="empty-icon">💰</div>
                                    <h3>Belum Ada Data Harga TBS</h3>
                                    <p>Anda belum menambahkan data harga TBS. Klik tombol "Tambah Data" untuk menambahkan data baru.</p>
                                    <a href="<?= base_url(uri: 'admin/harga_tbs/tambah') ?>" class="btn btn-primary">Tambah Data</a>
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
    border-bottom: 1px solid var(--border-color);
    background: #FAFAFA;
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
    flex: 1;
}

.card-title {
    font-weight: 700 !important;
    font-size: 1.5rem;
    color: var(--admin-text);
    margin: 0;
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
    text-align: center;
}

.riwayat-table tbody td:last-child {
    width: 150px;
    text-align: center;
}

.riwayat-table tbody td .btn-group {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.riwayat-table tbody td .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 8px;
    transition: all 0.3s ease;
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

/* Search Bar Styles */
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
}

.input-group .form-control:focus {
    border-color: var(--admin-primary);
    box-shadow: 0 0 0 0.2rem rgba(27, 94, 32, 0.15), 0 2px 4px rgba(0, 0, 0, 0.05);
    outline: none;
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
</style>

<script>
// Search Functionality
(function() {
    'use strict';
    
    function performSearch() {
        var searchInput = document.getElementById('searchInput');
        var keyword = searchInput ? searchInput.value.toLowerCase().trim() : '';
        var rows = document.querySelectorAll('tbody tr.riwayat-row');
        var visibleCount = 0;
        
        rows.forEach(function(row) {
            var rowText = row.textContent.toLowerCase();
            if (keyword === '' || rowText.includes(keyword)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        var noResults = document.getElementById('no-results');
        if (keyword !== '' && visibleCount === 0) {
            if (!noResults) {
                var tbody = document.querySelector('tbody');
                if (tbody) {
                    var tr = document.createElement('tr');
                    tr.id = 'no-results';
                    tr.innerHTML = '<td colspan="6" class="text-center py-4"><p class="text-muted mb-0">Tidak ada hasil ditemukan</p></td>';
                    tbody.appendChild(tr);
                }
            }
        } else {
            if (noResults) {
                noResults.remove();
            }
        }
    }
    
    function initSearch() {
        var searchBtn = document.getElementById('searchBtn');
        var searchInput = document.getElementById('searchInput');
        
        if (searchBtn) {
            searchBtn.addEventListener('click', performSearch);
        }
        
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
        }
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearch);
    } else {
        initSearch();
    }
})();
</script>
