<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= isset($kabupaten) ? 'Edit' : 'Tambah' ?> Kabupaten</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open(current_url()); ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kabupaten" class="form-control" 
                                   value="<?= isset($kabupaten) ? $kabupaten->nama_kabupaten : set_value('nama_kabupaten') ?>" required>
                            <?= form_error('nama_kabupaten', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('admin/kabupaten') ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


