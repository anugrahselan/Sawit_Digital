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
                                <?php if ($this->session->flashdata('message')): ?>
                                    <div class="alert alert-<?= $this->session->flashdata('message_type') ?: 'info' ?> alert-dismissible fade show" role="alert">
                                        <?= $this->session->flashdata('message') ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?= base_url('admin/tanah/tambah') ?>" class="btn btn-labeled btn-primary">
                                    <span class="btn-label"><i class="fa fa-plus"></i></span> Tambah Data
                                </a>
                                
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Tanah</th>
                                            <th scope="col">pH</th>
                                            <th scope="col">Kandungan NPK</th>
                                            <th scope="col">Rekomendasi</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($tanah)): ?>
                                            <?php $i = 1; foreach ($tanah as $t): ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><strong><?= htmlspecialchars($t->nama_tanah) ?></strong></td>
                                                    <td>
                                                        <?php if ($t->ph_min || $t->ph_max): ?>
                                                            <?= $t->ph_min ?: '?' ?> - <?= $t->ph_max ?: '?' ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $kandungan = [];
                                                        if ($t->kandungan_n) $kandungan[] = 'N: ' . $t->kandungan_n . '%';
                                                        if ($t->kandungan_p) $kandungan[] = 'P: ' . $t->kandungan_p . '%';
                                                        if ($t->kandungan_k) $kandungan[] = 'K: ' . $t->kandungan_k . '%';
                                                        echo !empty($kandungan) ? implode(', ', $kandungan) : '<span class="text-muted">-</span>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($t->rekomendasi): ?>
                                                            <span title="<?= htmlspecialchars($t->rekomendasi) ?>" style="cursor: help;">
                                                                <?= strlen($t->rekomendasi) > 50 ? substr($t->rekomendasi, 0, 50) . '...' : $t->rekomendasi ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($can_edit): ?>
                                                            <a href="<?= base_url('admin/tanah/ubah/' . $t->id_tanah) ?>" class="badge badge-success">Edit</a>
                                                        <?php endif; ?>
                                                        <?php if ($can_delete): ?>
                                                            <a href="<?= base_url('admin/tanah/hapus/' . $t->id_tanah) ?>" class="badge badge-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data</td>
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
