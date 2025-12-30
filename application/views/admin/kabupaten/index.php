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
                                <?php if ($this->session->flashdata('message')): ?>
                                    <div class="alert alert-<?= $this->session->flashdata('message_type') ?: 'info' ?> alert-dismissible fade show" role="alert">
                                        <?= $this->session->flashdata('message') ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?= base_url(uri: 'admin/kabupaten/tambah') ?>" class="btn btn-labeled btn-primary">
                                    <span class="btn-label"><i class="fa fa-plus"></i></span> Tambah Data
                                </a>
                                
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Kabupaten</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($kabupaten)): ?>
                                            <?php $i = 1; foreach ($kabupaten as $kab): ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $kab->nama_kabupaten ?></td>
                                                    <td>
                                                        <a href="<?= base_url(uri: 'admin/kabupaten/ubah/') ?><?= $kab->id_kabupaten ?>" class="badge badge-success">edit</a>
                                                        <a href="<?= base_url(uri: 'admin/kabupaten/hapus/') ?><?= $kab->id_kabupaten ?>" class="badge badge-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">delete</a>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                
                                <?php if (isset($pagination_links)): ?>
                                    <div class="mt-3">
                                        <?= $pagination_links ?>
                                    </div>
                                <?php endif; ?>
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
