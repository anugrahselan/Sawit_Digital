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
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/pupuk') ?>">Pupuk</a></li>
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
                            <h5 class="card-title"><?= $page_title ?></h5>
                            <p class="card-text">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger">
                                        <?= $error ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="nama_pupuk" class="form-label">Nama Pupuk</label>
                                        <input type="text" class="form-control" name="nama_pupuk" id="nama_pupuk" value="<?= set_value('nama_pupuk') ?>" aria-describedby="Nama pupuk">
                                        <?= form_error('nama_pupuk', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="kandungan" class="form-label">Kandungan</label>
                                        <input type="text" class="form-control" name="kandungan" id="kandungan" value="<?= set_value('kandungan') ?>" placeholder="Contoh: N 46%, P2O5 0%, K2O 0%" aria-describedby="Kandungan">
                                        <?= form_error('kandungan', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="fungsi" class="form-label">Fungsi</label>
                                        <textarea name="fungsi" id="fungsi" cols="30" rows="10" class="form-control"><?= set_value('fungsi') ?></textarea>
                                        <?= form_error('fungsi', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="waktu_aplikasi" class="form-label">Waktu Aplikasi</label>
                                        <input type="text" class="form-control" name="waktu_aplikasi" id="waktu_aplikasi" value="<?= set_value('waktu_aplikasi') ?>" placeholder="Contoh: Pagi atau sore hari" aria-describedby="Waktu aplikasi">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="catatan_khusus" class="form-label">Catatan Khusus</label>
                                        <textarea name="catatan_khusus" id="catatan_khusus" cols="30" rows="10" class="form-control"><?= set_value('catatan_khusus') ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="gambar_pupuk" class="form-label">Gambar Pupuk</label>
                                        <input type="file" class="form-control" name="gambar_pupuk" id="gambar_pupuk" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                    <a href="<?= base_url('admin/pupuk') ?>" class="btn btn-danger">Kembali</a>
                                </form>
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
