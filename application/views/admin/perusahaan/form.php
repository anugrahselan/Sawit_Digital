<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= isset($perusahaan) ? 'Edit' : 'Tambah' ?> Perusahaan</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open(current_url()); ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_perusahaan" class="form-control" 
                                   value="<?= isset($perusahaan) ? $perusahaan->nama_perusahaan : set_value('nama_perusahaan') ?>" required>
                            <?= form_error('nama_perusahaan', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kabupaten <span class="text-danger">*</span></label>
                            <select name="id_kabupaten" class="form-select" required>
                                <option value="">Pilih Kabupaten</option>
                                <?php foreach ($kabupaten_list as $kab): ?>
                                    <option value="<?= $kab->id_kabupaten ?>" 
                                        <?= (isset($perusahaan) && $perusahaan->id_kabupaten == $kab->id_kabupaten) ? 'selected' : '' ?>
                                        <?= set_select('id_kabupaten', $kab->id_kabupaten) ?>>
                                        <?= $kab->nama_kabupaten ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_kabupaten', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3"><?= isset($perusahaan) ? $perusahaan->alamat : set_value('alamat') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control" 
                                   value="<?= isset($perusahaan) ? $perusahaan->kontak : set_value('kontak') ?>">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('admin/perusahaan') ?>" class="btn btn-secondary">
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


