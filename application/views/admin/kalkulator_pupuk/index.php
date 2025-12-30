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
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Jenis Pupuk</th>
                                            <th scope="col">Jenis Tanah</th>
                                            <th scope="col">Usia Tanaman</th>
                                            <th scope="col">Jumlah Pohon</th>
                                            <th scope="col">Dosis/Pohon</th>
                                            <th scope="col">Total Dosis</th>
                                            <th scope="col">Periode/Tahun</th>
                                            <th scope="col">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($dosis)): ?>
                                            <?php $i = 1; foreach ($dosis as $d): ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <strong><?= htmlspecialchars($d->user_username ?: '-') ?></strong>
                                                        <?php if (!empty($d->user_nama)): ?>
                                                            <br><small class="text-muted"><?= htmlspecialchars($d->user_nama) ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $d->nama_pupuk ?: 'ID: ' . $d->id_pupuk ?></td>
                                                    <td><?= $d->nama_tanah ?: 'ID: ' . $d->id_tanah ?></td>
                                                    <td><?= $d->usia_tanaman ?> bulan</td>
                                                    <td><?= number_format($d->jumlah_pohon, 0) ?></td>
                                                    <td><strong><?= number_format($d->dosis_per_pohon, 2) ?> kg</strong></td>
                                                    <td><strong><?= number_format($d->total_dosis, 2) ?> kg</strong></td>
                                                    <td><?= $d->periode_per_tahun ?>x</td>
                                                    <td>
                                                        <?php 
                                                        if (isset($d->tanggal_kalkulasi) && !empty($d->tanggal_kalkulasi)) {
                                                            echo date('d M Y H:i', strtotime($d->tanggal_kalkulasi));
                                                        } else {
                                                            echo '-';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada data</td>
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
