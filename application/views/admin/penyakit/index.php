
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $page_title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $page_title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="card-title">Daftar Jenis Penyakit</h3>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?= base_url(uri: 'admin/penyakit/tambah') ?>" class="btn btn-primary">
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

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Cari nama penyakit...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success w-100" type="button" id="searchBtn">
                                            <i class="fa fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($penyakit)): ?>
                                <div class="riwayat-table-wrapper">
                                    <table class="riwayat-table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 50px;"></th>
                                                <th style="text-align: center;">GAMBAR</th>
                                                <th style="text-align: center;">PENYAKIT</th>
                                                <th style="width: 150px; text-align: center;">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($penyakit as $p): ?>
                                                <tr class="riwayat-row" data-id="<?= $p['id_penyakit'] ?>">
                                                    <td>
                                                        <button class="expand-btn" data-target="detail-penyakit-<?= $p['id_penyakit'] ?>">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if (!empty($p['gambar_ilustrasi'])): 
                                                            $gambar_penyakit = trim($p['gambar_ilustrasi']);
                                                            if (strpos($gambar_penyakit, 'assets/img/penyakit/') !== false) {
                                                                $gambar_penyakit = basename($gambar_penyakit);
                                                            }
                                                            $gambar_url = base_url(uri: 'assets/img/penyakit/' . $gambar_penyakit);
                                                        ?>
                                                            <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($p['nama_penyakit']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;" onerror="this.onerror=null; this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-muted\'>-</span>';">
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="text-align: center;"><strong><?= htmlspecialchars($p['nama_penyakit']) ?></strong></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= base_url('penyakit/detail/' . $p['id_penyakit']) ?>" class="btn btn-sm btn-info" target="_blank" title="Lihat">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="<?= base_url(uri: 'admin/penyakit/ubah/') ?><?= $p['id_penyakit'] ?>" class="btn btn-sm btn-success" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="<?= base_url(uri: 'admin/penyakit/hapus/') ?><?= $p['id_penyakit'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="detail-row" id="detail-penyakit-<?= $p['id_penyakit'] ?>">
                                                    <td colspan="4">
                                                        <div class="detail-content">
                                                            <div class="detail-grid detail-grid-3cols">
                                                                <?php if (!empty($p['penyebab'])): ?>
                                                                    <div class="detail-item">
                                                                        <span class="detail-label">Penyebab:</span>
                                                                        <div class="detail-value" style="margin-top: 0.5rem; padding: 1rem; background: rgba(255, 255, 255, 0.9); border-radius: 8px; border: 1px solid rgba(27, 94, 32, 0.1); max-height: 250px; overflow-y: auto;">
                                                                            <?= nl2br(htmlspecialchars($p['penyebab'])) ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($p['gejala'])): ?>
                                                                    <div class="detail-item">
                                                                        <span class="detail-label">Gejala:</span>
                                                                        <div class="detail-value" style="margin-top: 0.5rem; padding: 1rem; background: rgba(255, 255, 255, 0.9); border-radius: 8px; border: 1px solid rgba(27, 94, 32, 0.1); max-height: 250px; overflow-y: auto;">
                                                                            <?= nl2br(htmlspecialchars($p['gejala'])) ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($p['cara_pengendalian'])): ?>
                                                                    <div class="detail-item">
                                                                        <span class="detail-label">Cara Pengendalian:</span>
                                                                        <div class="detail-value" style="margin-top: 0.5rem; padding: 1rem; background: rgba(255, 255, 255, 0.9); border-radius: 8px; border: 1px solid rgba(27, 94, 32, 0.1); max-height: 250px; overflow-y: auto;">
                                                                            <?= nl2br(htmlspecialchars($p['cara_pengendalian'])) ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (empty($p['penyebab']) && empty($p['gejala']) && empty($p['cara_pengendalian'])): ?>
                                                                    <div class="detail-item full-width">
                                                                        <span class="detail-label">Tidak ada informasi tambahan</span>
                                                                        <div class="detail-value" style="color: var(--admin-text-light); font-style: italic;">
                                                                            Tidak ada informasi penyebab, gejala, atau cara pengendalian yang tersedia untuk penyakit ini.
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
                                    <div class="empty-icon">🦠</div>
                                    <h3>Belum Ada Data Penyakit</h3>
                                    <p>Anda belum menambahkan data penyakit. Klik tombol "Tambah Data" untuk menambahkan data baru.</p>
                                    <a href="<?= base_url(uri: 'admin/penyakit/tambah') ?>" class="btn btn-primary">Tambah Data</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

:root {
    --admin-primary: 
    --admin-secondary: 
    --admin-accent: 
    --admin-bg: 
    --admin-text: 
    --admin-border: 
    --admin-text-light: 
}

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

    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(27, 94, 32, 0.3);
}

.riwayat-table-wrapper {
    background: linear-gradient(135deg, 
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
    text-align: center;
}

.riwayat-table tbody td:nth-child(3) {
    text-align: center;
}

.riwayat-table tbody td:first-child {
    width: 50px;
    text-align: center;
}

.riwayat-table tbody td:last-child {
    width: 150px;
    text-align: center;
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

.detail-grid-3cols {
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .detail-grid-3cols {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
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

(function() {
    'use strict';

    function handleExpandClick(e) {
        var expandBtn = e.target.closest('.expand-btn');
        if (!expandBtn) {
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
            detailRow.classList.remove('expanded');
            expandBtn.classList.remove('expanded');
        } else {
            var expandedRows = document.querySelectorAll('.detail-row.expanded');
            expandedRows.forEach(function(row) {
                row.classList.remove('expanded');
            });

            var expandedBtns = document.querySelectorAll('.expand-btn.expanded');
            expandedBtns.forEach(function(b) {
                b.classList.remove('expanded');
            });

            detailRow.classList.add('expanded');
            expandBtn.classList.add('expanded');
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            var tbody = document.querySelector('.riwayat-table tbody');
            if (tbody) {
                tbody.addEventListener('click', handleExpandClick);
            }

            var expandButtons = document.querySelectorAll('.expand-btn');
            expandButtons.forEach(function(btn) {
                btn.addEventListener('click', handleExpandClick);
            });
        });
    } else {
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
                        $('#detail-penyakit-' + id).hide().removeClass('expanded');
                    }
                });

                if (!found && keyword !== '') {
                    if ($('#no-results').length === 0) {
                        $('tbody').append('<tr id="no-results"><td colspan="4" class="text-center py-4"><p class="text-muted mb-0">Tidak ada hasil ditemukan</p></td></tr>');
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
                            var rowId = row.getAttribute('data-id');
                            if (rowId) {
                                var detailRow = document.getElementById('detail-penyakit-' + rowId);
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
</script>
