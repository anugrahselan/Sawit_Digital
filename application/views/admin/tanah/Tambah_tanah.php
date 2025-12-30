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
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/tanah') ?>">Tanah</a></li>
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
                                
                                <form method="post">
                                    <div class="mb-3">
                                        <label for="nama_tanah" class="form-label">Nama Tanah <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_tanah" id="nama_tanah" value="<?= set_value('nama_tanah') ?>" required>
                                        <?= form_error('nama_tanah', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="ph_min" class="form-label">pH Minimum</label>
                                            <input type="number" class="form-control" name="ph_min" id="ph_min" value="<?= set_value('ph_min') ?>" step="0.1" min="0" max="14" placeholder="Contoh: 5.5">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ph_max" class="form-label">pH Maksimum</label>
                                            <input type="number" class="form-control" name="ph_max" id="ph_max" value="<?= set_value('ph_max') ?>" step="0.1" min="0" max="14" placeholder="Contoh: 7.0">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="kandungan_n" class="form-label">Kandungan N (%)</label>
                                            <input type="number" class="form-control" name="kandungan_n" id="kandungan_n" value="<?= set_value('kandungan_n') ?>" step="0.01" min="0" placeholder="Contoh: 2.5">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="kandungan_p" class="form-label">Kandungan P (%)</label>
                                            <input type="number" class="form-control" name="kandungan_p" id="kandungan_p" value="<?= set_value('kandungan_p') ?>" step="0.01" min="0" placeholder="Contoh: 1.5">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="kandungan_k" class="form-label">Kandungan K (%)</label>
                                            <input type="number" class="form-control" name="kandungan_k" id="kandungan_k" value="<?= set_value('kandungan_k') ?>" step="0.01" min="0" placeholder="Contoh: 2.0">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="rekomendasi" class="form-label">Rekomendasi</label>
                                        <textarea class="form-control" name="rekomendasi" id="rekomendasi" rows="3" placeholder="Masukkan rekomendasi untuk jenis tanah ini"><?= set_value('rekomendasi') ?></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                    <a href="<?= base_url(uri: 'admin/tanah') ?>" class="btn btn-danger">Kembali</a>
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
