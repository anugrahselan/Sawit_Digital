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
                                <div class="col-md-12">
                                    <h3 class="card-title">Daftar Kalkulasi Panen</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Search Bar -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari username, perusahaan, harga, berat, atau hasil bersih...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success w-100" type="button" id="searchBtn">
                                            <i class="fa fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($kalkulasi)): ?>
                                <div class="riwayat-table-wrapper">
                                    <table class="riwayat-table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 50px;"></th>
                                                <th style="text-align: center;">USERNAME</th>
                                                <th style="text-align: center;">PERUSAHAAN</th>
                                                <th style="text-align: center;">HARGA</th>
                                                <th style="text-align: center;">BERAT KOTOR</th>
                                                <th style="text-align: center;">HASIL BERSIH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $index = 0;
                                            foreach ($kalkulasi as $k): ?>
                                                <?php
                                                $uniqueId = !empty($k->id_kalkulasi) ? $k->id_kalkulasi : 'panen-' . $index;
                                                $targetId = 'detail-panen-' . $uniqueId;
                                                ?>
                                                <tr class="riwayat-row" data-id="<?= $uniqueId ?>">
                                                    <td style="text-align: center;">
                                                        <button class="expand-btn" data-target="<?= $targetId ?>">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <?php if (isset($k->user_username) && !empty($k->user_username)): ?>
                                                            <strong><?= htmlspecialchars($k->user_username) ?></strong>
                                                            <?php if (!empty($k->user_nama)): ?>
                                                                <br><small
                                                                    class="text-muted"><?= htmlspecialchars($k->user_nama) ?></small>
                                                            <?php endif; ?>
                                                        <?php elseif (isset($k->username) && !empty($k->username)): ?>
                                                            <strong><?= htmlspecialchars($k->username) ?></strong>
                                                        <?php else: ?>
                                                            <strong>-</strong>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?= htmlspecialchars($k->nama_perusahaan ?: '-') ?>
                                                    </td>
                                                    <td style="text-align: center;">Rp
                                                        <?= number_format($k->harga_per_kg, 0, ',', '.') ?>
                                                    </td>
                                                    <td style="text-align: center;"><?= number_format($k->berat_kotor, 2) ?> kg
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <strong>
                                                            <?php
                                                            // Gunakan hasil_bersih dari database jika ada, jika tidak hitung
                                                            if (isset($k->hasil_bersih) && $k->hasil_bersih !== null) {
                                                                echo 'Rp ' . number_format($k->hasil_bersih, 0, ',', '.');
                                                            } else {
                                                                // Hitung hasil bersih: (harga_per_kg * berat_kotor) - potongan - upah_panen - biaya_transportasi - potong_hutang
                                                                $total_pendapatan = $k->harga_per_kg * $k->berat_kotor;
                                                                $potongan_rp = ($total_pendapatan * $k->potongan) / 100;
                                                                $hasil_bersih = $total_pendapatan - $potongan_rp - $k->upah_panen - $k->biaya_transportasi - $k->potong_hutang;
                                                                echo 'Rp ' . number_format($hasil_bersih, 0, ',', '.');
                                                            }
                                                            ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr class="detail-row" id="<?= $targetId ?>">
                                                    <td colspan="6">
                                                        <div class="detail-content">
                                                            <div class="detail-grid">
                                                                <div class="detail-item">
                                                                    <span class="detail-label">ID Kalkulasi:</span>
                                                                    <div class="detail-value"><?= $k->id_kalkulasi ?? '-' ?>
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Kabupaten:</span>
                                                                    <div class="detail-value">
                                                                        <?= htmlspecialchars($k->nama_kabupaten ?: '-') ?>
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Potongan:</span>
                                                                    <div class="detail-value">
                                                                        <?= number_format($k->potongan, 2) ?>%
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Upah Panen:</span>
                                                                    <div class="detail-value">Rp
                                                                        <?= number_format($k->upah_panen, 0, ',', '.') ?>
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Biaya Transportasi:</span>
                                                                    <div class="detail-value">Rp
                                                                        <?= number_format($k->biaya_transportasi, 0, ',', '.') ?>
                                                                    </div>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <span class="detail-label">Potong Hutang:</span>
                                                                    <div class="detail-value">Rp
                                                                        <?= number_format($k->potong_hutang, 0, ',', '.') ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $index++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <div class="empty-icon">📊</div>
                                    <h3>Belum Ada Data Kalkulasi Panen</h3>
                                    <p>Belum ada data kalkulasi panen yang tersimpan.</p>
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
            table-layout: auto;
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

        .riwayat-table tbody td:nth-child(2) {
            text-align: left;
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

        /* Expand Button Styles */
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

        .expand-btn.expanded {
            background: rgba(27, 94, 32, 0.1);
            transform: rotate(180deg);
        }

        .expand-btn.expanded:hover {
            background: rgba(27, 94, 32, 0.15);
        }

        /* Detail Row Styles */
        .detail-row {
            display: none;
        }

        .detail-row.expanded {
            display: table-row;
        }

        .detail-content {
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(27, 94, 32, 0.02) 0%, rgba(46, 125, 50, 0.01) 100%);
            border-top: 2px solid rgba(27, 94, 32, 0.1);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .detail-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--admin-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 1rem;
            color: var(--admin-text);
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            border: 1px solid rgba(27, 94, 32, 0.1);
        }
    </style>

    <script>
        // Expand/Collapse functionality
        (function () {
            'use strict';

            function handleExpandClick(e) {
                // Cek jika klik pada icon atau button
                var expandBtn = e.target.closest('.expand-btn');

                // Jika tidak ditemukan, coba cari dari icon
                if (!expandBtn) {
                    if (e.target.classList.contains('fa') || e.target.classList.contains('fa-chevron-down')) {
                        expandBtn = e.target.closest('button.expand-btn');
                        if (!expandBtn && e.target.parentElement) {
                            expandBtn = e.target.parentElement.closest('.expand-btn');
                        }
                    }
                }

                if (!expandBtn) return;

                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

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
                    // Tutup semua detail row yang terbuka
                    var expandedRows = document.querySelectorAll('.detail-row.expanded');
                    expandedRows.forEach(function (row) {
                        row.classList.remove('expanded');
                    });

                    // Reset semua button yang expanded
                    var expandedBtns = document.querySelectorAll('.expand-btn.expanded');
                    expandedBtns.forEach(function (b) {
                        b.classList.remove('expanded');
                    });

                    // Buka detail row yang dipilih
                    detailRow.classList.add('expanded');
                    expandBtn.classList.add('expanded');
                }
            }

            function initExpandButtons() {
                var tbody = document.querySelector('.riwayat-table tbody');
                if (tbody) {
                    // Gunakan event delegation pada tbody
                    tbody.addEventListener('click', handleExpandClick, true);
                }

                // Juga attach langsung ke semua button sebagai backup
                var expandButtons = document.querySelectorAll('.expand-btn');
                expandButtons.forEach(function (btn) {
                    btn.addEventListener('click', handleExpandClick, true);
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initExpandButtons);
            } else {
                initExpandButtons();
            }
        })();

        // Search Functionality
        (function () {
            'use strict';

            function performSearch() {
                var searchInput = document.getElementById('searchInput');
                var keyword = searchInput ? searchInput.value.toLowerCase().trim() : '';
                var rows = document.querySelectorAll('tbody tr.riwayat-row');
                var visibleCount = 0;

                rows.forEach(function (row) {
                    var rowText = row.textContent.toLowerCase();
                    if (keyword === '' || rowText.includes(keyword)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                        var rowId = row.getAttribute('data-id');
                        if (rowId) {
                            var detailRow = document.getElementById('detail-panen-' + rowId);
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
                    searchInput.addEventListener('keyup', function (e) {
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