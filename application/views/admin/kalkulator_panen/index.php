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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">ID User</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Kabupaten</th>
                                            <th scope="col">Perusahaan</th>
                                            <th scope="col">Harga/Kg</th>
                                            <th scope="col">Berat Kotor</th>
                                            <th scope="col">Potongan</th>
                                            <th scope="col">Upah Panen</th>
                                            <th scope="col">Transportasi</th>
                                            <th scope="col">Potong Hutang</th>
                                            <th scope="col">Hasil Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($kalkulasi)): ?>
                                            <?php $i = 1; foreach ($kalkulasi as $k): ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $k->id_user ?: '-' ?></td>
                                                    <td>
                                                        <strong><?= htmlspecialchars($k->user_username ?: ($k->username ?: '-')) ?></strong>
                                                        <?php if (!empty($k->user_nama)): ?>
                                                            <br><small class="text-muted"><?= htmlspecialchars($k->user_nama) ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $k->nama_kabupaten ?: '-' ?></td>
                                                    <td><?= $k->nama_perusahaan ?: '-' ?></td>
                                                    <td>Rp <?= number_format($k->harga_per_kg, 0, ',', '.') ?></td>
                                                    <td><?= number_format($k->berat_kotor, 2) ?> kg</td>
                                                    <td><?= number_format($k->potongan, 2) ?>%</td>
                                                    <td>Rp <?= number_format($k->upah_panen, 0, ',', '.') ?></td>
                                                    <td>Rp <?= number_format($k->biaya_transportasi, 0, ',', '.') ?></td>
                                                    <td>Rp <?= number_format($k->potong_hutang, 0, ',', '.') ?></td>
                                                    <td>
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
                                            <?php $i++; endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="12" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </p>
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
