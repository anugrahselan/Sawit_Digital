<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= isset($pupuk) ? 'Edit' : 'Tambah' ?> Jenis Pupuk</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open_multipart(current_url()); ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Pupuk <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pupuk" class="form-control" 
                                   value="<?= isset($pupuk) ? $pupuk->nama_pupuk : set_value('nama_pupuk') ?>" required>
                            <?= form_error('nama_pupuk', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kandungan <span class="text-danger">*</span></label>
                            <input type="text" name="kandungan" class="form-control" 
                                   value="<?= isset($pupuk) ? $pupuk->kandungan : set_value('kandungan') ?>" 
                                   placeholder="Contoh: N 46%, P2O5 0%, K2O 0%" required>
                            <?= form_error('kandungan', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fungsi <span class="text-danger">*</span></label>
                            <textarea name="fungsi" class="form-control" rows="3" required><?= isset($pupuk) ? $pupuk->fungsi : set_value('fungsi') ?></textarea>
                            <?= form_error('fungsi', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Waktu Aplikasi</label>
                            <input type="text" name="waktu_aplikasi" class="form-control" 
                                   value="<?= isset($pupuk) ? $pupuk->waktu_aplikasi : set_value('waktu_aplikasi') ?>"
                                   placeholder="Contoh: Pagi atau sore hari">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Khusus</label>
                            <textarea name="catatan_khusus" class="form-control" rows="3"><?= isset($pupuk) ? $pupuk->catatan_khusus : set_value('catatan_khusus') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Pupuk</label>
                            <?php if (isset($pupuk) && !empty($pupuk->gambar_pupuk)): 
                                $gambar_pupuk = trim($pupuk->gambar_pupuk);
                                // Jika path sudah lengkap (sudah ada assets/img/pupuk/), ambil hanya nama file
                                if (strpos($gambar_pupuk, 'assets/img/pupuk/') !== false) {
                                    $gambar_pupuk = basename($gambar_pupuk);
                                }
                                $gambar_url = base_url('assets/img/pupuk/' . $gambar_pupuk);
                            ?>
                                <div class="mb-2">
                                    <img src="<?= $gambar_url ?>" 
                                         alt="Gambar saat ini" 
                                         style="max-width: 200px; height: auto; border-radius: 4px;"
                                         onerror="this.onerror=null; this.style.display='none';">
                                    <p class="text-muted small mt-1">Gambar saat ini</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="gambar_pupuk" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('admin/pupuk') ?>" class="btn btn-secondary">
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


