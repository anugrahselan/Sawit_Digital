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
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/penyakit') ?>">Penyakit</a></li>
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
                                        <label for="nama_penyakit" class="form-label">Nama Penyakit</label>
                                        <input type="text" class="form-control" name="nama_penyakit" id="nama_penyakit" value="<?= set_value('nama_penyakit') ?>" aria-describedby="Nama penyakit">
                                        <?= form_error('nama_penyakit', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="penyebab" class="form-label">Penyebab</label>
                                        <textarea name="penyebab" id="penyebab" cols="30" rows="10" class="form-control"><?= set_value('penyebab') ?></textarea>
                                        <?= form_error('penyebab', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="gejala" class="form-label">Gejala</label>
                                        <textarea name="gejala" id="gejala" cols="30" rows="10" class="form-control"><?= set_value('gejala') ?></textarea>
                                        <?= form_error('gejala', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="cara_pengendalian" class="form-label">Cara Pengendalian</label>
                                        <textarea name="cara_pengendalian" id="cara_pengendalian" cols="30" rows="10" class="form-control"><?= set_value('cara_pengendalian') ?></textarea>
                                        <?= form_error('cara_pengendalian', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="gambar_ilustrasi" class="form-label">Gambar Ilustrasi</label>
                                        <input type="file" class="form-control" name="gambar_ilustrasi" id="gambar_ilustrasi" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                    <a href="<?= base_url(uri: 'admin/penyakit') ?>" class="btn btn-danger">Kembali</a>
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
