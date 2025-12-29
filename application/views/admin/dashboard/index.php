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
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
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
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-card-icon primary">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="stats-card-value"><?= number_format($total_perusahaan) ?></div>
                        <div class="stats-card-label">Total Perusahaan</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-card-icon success">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="stats-card-value"><?= number_format($total_kabupaten) ?></div>
                        <div class="stats-card-label">Total Kabupaten</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-card-icon warning">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="stats-card-value"><?= number_format($total_harga_tbs) ?></div>
                        <div class="stats-card-label">Total Harga TBS</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-card-icon info">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stats-card-value"><?= number_format($total_users) ?></div>
                        <div class="stats-card-label">Total Users</div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Harga TBS Terbaru -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-currency-dollar"></i> Harga TBS Terbaru per Perusahaan</h5>
                            <a href="<?= base_url('admin/harga_tbs') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Perusahaan</th>
                                            <th>Kabupaten</th>
                                            <th>Tanggal</th>
                                            <th>Harga/Kg</th>
                                            <th>Perubahan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($tbs_prices)): ?>
                                            <?php foreach ($tbs_prices as $price): ?>
                                                <tr>
                                                    <td><?= $price->nama_perusahaan ?: '-' ?></td>
                                                    <td><?= $price->nama_kabupaten ?: '-' ?></td>
                                                    <td><?= date('d M Y', strtotime($price->tanggal)) ?></td>
                                                    <td><strong>Rp <?= number_format($price->harga_per_kg, 0, ',', '.') ?></strong></td>
                                                    <td>
                                                        <?php if (isset($price->status_perubahan)): ?>
                                                            <?php if ($price->status_perubahan == 'naik'): ?>
                                                                <span class="badge badge-success">
                                                                    <i class="bi bi-arrow-up"></i> Rp <?= number_format(abs($price->perubahan), 0, ',', '.') ?>
                                                                </span>
                                                            <?php elseif ($price->status_perubahan == 'turun'): ?>
                                                                <span class="badge badge-danger">
                                                                    <i class="bi bi-arrow-down"></i> Rp <?= number_format(abs($price->perubahan), 0, ',', '.') ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="badge badge-secondary">
                                                                    <i class="bi bi-dash"></i> -
                                                                </span>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Belum ada data harga TBS</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Perubahan Harga Widget -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-graph-up"></i> Perubahan Harga</h5>
                        </div>
                        <div class="card-body">
                            <?php 
                            $perubahan_data = [];
                            foreach ($tbs_prices as $price) {
                                if (isset($price->status_perubahan) && $price->status_perubahan != 'tidak_ada') {
                                    $perubahan_data[] = $price;
                                }
                            }
                            ?>
                            <?php if (!empty($perubahan_data)): ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach (array_slice($perubahan_data, 0, 5) as $price): ?>
                                        <div class="list-group-item border-0 px-0 py-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong><?= $price->nama_perusahaan ?: '-' ?></strong>
                                                    <small class="d-block text-muted"><?= $price->nama_kabupaten ?: '-' ?></small>
                                                </div>
                                                <div class="text-end">
                                                    <?php if ($price->status_perubahan == 'naik'): ?>
                                                        <span class="badge badge-success">
                                                            <i class="bi bi-arrow-up"></i> Rp <?= number_format(abs($price->perubahan), 0, ',', '.') ?>
                                                        </span>
                                                    <?php elseif ($price->status_perubahan == 'turun'): ?>
                                                        <span class="badge badge-danger">
                                                            <i class="bi bi-arrow-down"></i> Rp <?= number_format(abs($price->perubahan), 0, ',', '.') ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted text-center mb-0">Belum ada data perubahan harga</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Weekly Trends Chart -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Tren Harga TBS (7 Hari Terakhir)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="weeklyTrendsChart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
// Weekly Trends Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('weeklyTrendsChart');
    if (ctx) {
        const weeklyData = <?= json_encode($weekly_trends) ?>;
        
        const labels = weeklyData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short' });
        });
        const prices = weeklyData.map(item => parseFloat(item.avg_price));
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-rata Harga (Rp)',
                    data: prices,
                    borderColor: '#1B5E20',
                    backgroundColor: 'rgba(27, 94, 32, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
