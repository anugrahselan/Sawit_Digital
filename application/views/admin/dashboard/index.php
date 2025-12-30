<!-- Dashboard Content -->
<div class="dashboard-container">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <a href="<?= site_url('admin/users') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon info">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stats-card-value"><?= number_format($total_users) ?></div>
                            <div class="stats-card-label">Total Users</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/kalkulator_panen') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon warning">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div class="stats-card-value"><?= number_format($total_kalkulasi_panen) ?></div>
                            <div class="stats-card-label">Kalkulasi Panen</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/kalkulator_pupuk') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon warning">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div class="stats-card-value"><?= number_format($total_kalkulasi_pupuk) ?></div>
                            <div class="stats-card-label">Kalkulasi Pupuk</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/harga_tbs') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon success">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="stats-card-value">Rp <?= number_format($avg_harga_tbs, 0, ',', '.') ?></div>
                            <div class="stats-card-label">Harga TBS Rata-rata</div>
                            <div class="stats-card-subtitle">
                                <small class="text-muted">per kilogram</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Additional Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <a href="<?= site_url('admin/kabupaten') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon success">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="stats-card-value"><?= number_format($total_kabupaten) ?></div>
                            <div class="stats-card-label">Total Kabupaten</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/pupuk') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon warning">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="stats-card-value"><?= number_format($total_jenis_pupuk) ?></div>
                            <div class="stats-card-label">Jenis Pupuk</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/penyakit') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon danger">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="stats-card-value"><?= number_format($total_penyakit) ?></div>
                            <div class="stats-card-label">Jenis Penyakit</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= site_url('admin/perusahaan') ?>" class="stats-card-link">
                        <div class="stats-card">
                            <div class="stats-card-icon primary">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="stats-card-value"><?= number_format($total_perusahaan) ?></div>
                            <div class="stats-card-label">Total Perusahaan</div>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Harga TBS Terbaru -->
                <div class="col-12">
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
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Belum ada data harga TBS</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
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
