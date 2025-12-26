<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Kalkulasi Panen</h1>
            <p class="text-muted mb-0">Data kalkulasi hasil panen yang diinput oleh user</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kabupaten</th>
                            <th>Perusahaan</th>
                            <th>Harga/Kg</th>
                            <th>Berat Kotor</th>
                            <th>Potongan</th>
                            <th>Upah Panen</th>
                            <th>Transportasi</th>
                            <th>Potong Hutang</th>
                            <th>Hasil Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kalkulasi)): ?>
                            <?php $no = 1; foreach ($kalkulasi as $k): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php 
                                        if (isset($k->tanggal) && !empty($k->tanggal)) {
                                            echo date('d M Y', strtotime($k->tanggal));
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td><?= $k->nama_kabupaten ?: '-' ?></td>
                                    <td><?= $k->nama_perusahaan ?: '-' ?></td>
                                    <td>Rp <?= number_format($k->harga_per_kg, 0, ',', '.') ?></td>
                                    <td><?= number_format($k->berat_kotor, 2) ?> kg</td>
                                    <td><?= number_format($k->potongan, 2) ?>%</td>
                                    <td>Rp <?= number_format($k->upah_panen, 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($k->biaya_transportasi, 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($k->potong_hutang, 0, ',', '.') ?></td>
                                    <td><strong>Rp <?= number_format($k->hasil_bersih, 0, ',', '.') ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada data kalkulasi panen dari user
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

