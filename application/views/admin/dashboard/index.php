<div class="dashboard-container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= site_url('admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <a href="<?= site_url('admin/users') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon info">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stats-card-content">
                                <div class="stats-card-label">Total Users</div>
                                <div class="stats-card-value"><?= number_format($total_users) ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/kalkulator_panen') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon warning">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div class="stats-card-content">
                                <div class="stats-card-label">Kalkulasi Panen</div>
                                <div class="stats-card-value"><?= number_format($total_kalkulasi_panen) ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/kalkulator_pupuk') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon warning">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div class="stats-card-content">
                                <div class="stats-card-label">Kalkulasi Pupuk</div>
                                <div class="stats-card-value"><?= number_format($total_kalkulasi_pupuk) ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/harga_tbs') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon success">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="stats-card-content">
                                <div class="stats-card-label">Harga TBS Rata-rata</div>
                                <div class="stats-card-value">Rp <?= number_format($avg_harga_tbs, 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <a href="<?= site_url('admin/kabupaten') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon success">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="stats-card-content">
                                <div class="stats-card-label">Total Kabupaten</div>
                                <div class="stats-card-value"><?= number_format($total_kabupaten) ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/pupuk') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon warning">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="stats-card-content">
                                <div class="stats-card-label">Jenis Pupuk</div>
                                <div class="stats-card-value"><?= number_format($total_jenis_pupuk) ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/penyakit') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon danger">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="stats-card-content">
                                <div class="stats-card-label">Jenis Penyakit</div>
                                <div class="stats-card-value"><?= number_format($total_penyakit) ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/perusahaan') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon primary">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="stats-card-content">
                                <div class="stats-card-label">Total Perusahaan</div>
                                <div class="stats-card-value"><?= number_format($total_perusahaan) ?></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title-sm">
                                Harga TBS Terbaru per Perusahaan
                            </h5>
                            <a href="<?= base_url('admin/harga_tbs') ?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i> Lihat Semua
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($tbs_prices)): ?>
                                <div class="riwayat-table-wrapper">
                                    <table class="riwayat-table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 50px;">NO</th>
                                                <th style="text-align: center;">KABUPATEN</th>
                                                <th style="text-align: center;">PT</th>
                                                <th style="text-align: center;">TANGGAL</th>
                                                <th style="text-align: center;">HARGA PER KG</th>
                                                <th style="text-align: center;">PERUBAHAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($tbs_prices as $price): ?>
                                                <tr class="riwayat-row">
                                                    <td class="text-center"><?= $i ?></td>
                                                    <td class="text-center">
                                                        <?= htmlspecialchars($price->nama_kabupaten ?: '-') ?>
                                                    </td>
                                                    <td><strong><?= htmlspecialchars($price->nama_perusahaan ?: '-') ?></strong>
                                                    </td>
                                                    <td class="text-center"><?= date('d M Y', strtotime($price->tanggal)) ?>
                                                    </td>
                                                    <td class="text-center"><strong>Rp
                                                            <?= number_format($price->harga_per_kg, 0, ',', '.') ?></strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (isset($price->perubahan) && $price->perubahan != 0): ?>
                                                            <?php
                                                            $perubahan = $price->perubahan;
                                                            $status = isset($price->status_perubahan) ? $price->status_perubahan : 'tidak_ada';
                                                            $badge_class = 'secondary';
                                                            $icon = '';
                                                            if ($status == 'naik') {
                                                                $badge_class = 'success';
                                                                $icon = '<i class="fa fa-arrow-up"></i> ';
                                                            } elseif ($status == 'turun') {
                                                                $badge_class = 'danger';
                                                                $icon = '<i class="fa fa-arrow-down"></i> ';
                                                            }
                                                            ?>
                                                            <span class="badge badge-<?= $badge_class ?>">
                                                                <?= $icon ?>Rp <?= number_format(abs($perubahan), 0, ',', '.') ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php $i++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <div class="empty-icon">💰</div>
                                    <h3>Belum Ada Data Harga TBS</h3>
                                    <p>Belum ada data harga TBS yang tersedia.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>

<style>
    :root {
        --admin-primary: #1B5E20;
        --admin-secondary: #2E7D32;
        --admin-accent: #388E3C;
        --admin-bg: #FAFAFA;
        --admin-text: #2c3e50;
        --admin-border: #e9ecef;
        --admin-text-light: #6c757d;
    }

    .row.g-4 {
        margin-left: -0.75rem;
        margin-right: -0.75rem;
    }

    .row.g-4>[class*="col-"] {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .stats-card-link {
        text-decoration: none !important;
        color: inherit;
        display: block;
        height: 100%;
    }

    .stats-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border: 2px solid rgba(27, 94, 32, 0.1);
        border-radius: 16px;
        padding: 1.75rem;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--admin-primary);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(27, 94, 32, 0.15);
        border-color: var(--admin-primary);
        background: linear-gradient(135deg, #ffffff 0%, #f0f4f0 100%);
    }

    .stats-card:hover::before {
        opacity: 1;
    }

    .stats-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        flex-shrink: 0;
    }

    .stats-card-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 100%;
    }

    .stats-card-icon.primary {
        background: linear-gradient(135deg, rgba(27, 94, 32, 0.15), rgba(46, 125, 50, 0.1));
        color: var(--admin-primary);
    }

    .stats-card-icon.success {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.15), rgba(56, 142, 60, 0.1));
        color: var(--admin-secondary);
    }

    .stats-card-icon.warning {
        background: linear-gradient(135deg, rgba(249, 168, 37, 0.15), rgba(255, 183, 77, 0.1));
        color: #f9a825;
    }

    .stats-card-icon.info {
        background: linear-gradient(135deg, rgba(2, 119, 189, 0.15), rgba(3, 169, 244, 0.1));
        color: #0277bd;
    }

    .stats-card-icon.danger {
        background: linear-gradient(135deg, rgba(211, 47, 47, 0.15), rgba(244, 67, 54, 0.1));
        color: #d32f2f;
    }

    .stats-card-label {
        color: var(--admin-text-light);
        font-size: 0.875rem;
        font-weight: 600;
        line-height: 1.4;
        margin: 0 0 0.75rem 0;
    }

    .stats-card-value {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--admin-text);
        line-height: 1.2;
        word-break: break-word;
        margin: 0;
    }

    .stats-card-subtitle {
        margin-top: 0.5rem;
        font-size: 0.8rem;
        color: var(--admin-text-light);
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .stats-card {
            padding: 1.5rem;
        }

        .stats-card-icon {
            width: 48px;
            height: 48px;
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .stats-card-value {
            font-size: 1.5rem;
        }

        .stats-card-label {
            font-size: 0.8rem;
        }
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

    .riwayat-table thead th:first-child {
        width: 50px;
    }

    .riwayat-table tbody td:first-child {
        width: 50px;
        text-align: center;
    }

    .riwayat-table tbody td:nth-child(3) {
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

    .riwayat-table tbody td .badge {
        display: inline-block;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 6px;
        white-space: nowrap;
    }

    .riwayat-table tbody td .badge-success {
        background-color: #28a745;
        color: white;
    }

    .riwayat-table tbody td .badge-danger {
        background-color: #dc3545;
        color: white;
    }

    .riwayat-table tbody td .badge-secondary {
        background-color: #6c757d;
        color: white;
    }

    .card {
        border-radius: 16px;
        border: 2px solid rgba(27, 94, 32, 0.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        background: linear-gradient(135deg, rgba(27, 94, 32, 0.05) 0%, rgba(46, 125, 50, 0.02) 100%);
        border-bottom: 2px solid rgba(27, 94, 32, 0.1);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h5 {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--admin-text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-header h5 i {
        color: var(--admin-primary);
    }

    .card-body {
        padding: 1.5rem;
    }

    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .card-header .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>