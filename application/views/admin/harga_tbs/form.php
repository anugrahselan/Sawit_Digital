<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= isset($price) ? 'Edit' : 'Tambah' ?> Harga TBS</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open(current_url()); ?>
                        <div class="mb-3">
                            <label class="form-label">Kabupaten <span class="text-danger">*</span></label>
                            <select name="id_kabupaten" id="id_kabupaten" class="form-select" required>
                                <option value="">Pilih Kabupaten</option>
                                <?php foreach ($kabupaten_list as $kab): ?>
                                    <option value="<?= $kab->id_kabupaten ?>" 
                                        <?= (isset($price) && $price->id_kabupaten == $kab->id_kabupaten) ? 'selected' : '' ?>
                                        <?= set_select('id_kabupaten', $kab->id_kabupaten) ?>>
                                        <?= $kab->nama_kabupaten ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_kabupaten', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Perusahaan <span class="text-danger">*</span></label>
                            <select name="id_perusahaan" id="id_perusahaan" class="form-select" required>
                                <option value="">Pilih Perusahaan</option>
                                <?php 
                                // Jika edit, tampilkan perusahaan yang sesuai dengan kabupaten yang dipilih
                                if (isset($price) && $price->id_kabupaten):
                                    $perusahaan_filtered = [];
                                    foreach ($perusahaan_list as $pt) {
                                        if ($pt->id_kabupaten == $price->id_kabupaten) {
                                            $perusahaan_filtered[] = $pt;
                                        }
                                    }
                                    foreach ($perusahaan_filtered as $pt): 
                                ?>
                                    <option value="<?= $pt->id_perusahaan ?>" 
                                        <?= ($price->id_perusahaan == $pt->id_perusahaan) ? 'selected' : '' ?>>
                                        <?= $pt->nama_perusahaan ?>
                                    </option>
                                <?php 
                                    endforeach;
                                endif; 
                                ?>
                            </select>
                            <?= form_error('id_perusahaan', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" 
                                   value="<?= isset($price) ? $price->tanggal : set_value('tanggal', date('Y-m-d')) ?>" required>
                            <?= form_error('tanggal', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga per Kg (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga_per_kg" class="form-control" 
                                   value="<?= isset($price) ? $price->harga_per_kg : set_value('harga_per_kg') ?>" 
                                   step="0.01" min="0" required>
                            <?= form_error('harga_per_kg', '<div class="text-danger small">', '</div>') ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('admin/harga_tbs') ?>" class="btn btn-secondary">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kabupatenSelect = document.getElementById('id_kabupaten');
    const perusahaanSelect = document.getElementById('id_perusahaan');
    const initialKabupatenId = kabupatenSelect.value; // Simpan kabupaten awal (untuk edit)
    const initialPerusahaanId = perusahaanSelect.value; // Simpan perusahaan awal (untuk edit)
    
    // Fungsi untuk load perusahaan berdasarkan kabupaten
    function loadPerusahaan(id_kabupaten, preserveSelection = false) {
        if (!id_kabupaten) {
            // Jika kabupaten tidak dipilih, kosongkan perusahaan
            perusahaanSelect.innerHTML = '<option value="">Pilih Perusahaan</option>';
            perusahaanSelect.disabled = true;
            return;
        }
        
        // Tampilkan loading
        perusahaanSelect.innerHTML = '<option value="">Memuat...</option>';
        perusahaanSelect.disabled = true;
        
        // AJAX request untuk mendapatkan perusahaan
        fetch('<?= site_url('admin/harga_tbs/get_perusahaan') ?>?id_kabupaten=' + id_kabupaten)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Kosongkan select
                    perusahaanSelect.innerHTML = '<option value="">Pilih Perusahaan</option>';
                    
                    // Tambahkan opsi perusahaan
                    if (data.data && data.data.length > 0) {
                        let foundSelected = false;
                        data.data.forEach(function(pt) {
                            const option = document.createElement('option');
                            option.value = pt.id_perusahaan;
                            option.textContent = pt.nama_perusahaan;
                            
                            // Jika preserve selection dan perusahaan ini sama dengan yang dipilih sebelumnya
                            if (preserveSelection && initialPerusahaanId && initialPerusahaanId == pt.id_perusahaan) {
                                option.selected = true;
                                foundSelected = true;
                            }
                            
                            perusahaanSelect.appendChild(option);
                        });
                        
                        // Jika perusahaan yang dipilih sebelumnya tidak ada di kabupaten baru, reset
                        if (preserveSelection && !foundSelected && initialPerusahaanId) {
                            perusahaanSelect.value = '';
                        }
                    } else {
                        perusahaanSelect.innerHTML = '<option value="">Tidak ada perusahaan di kabupaten ini</option>';
                    }
                    perusahaanSelect.disabled = false;
                } else {
                    perusahaanSelect.innerHTML = '<option value="">Error memuat data</option>';
                    perusahaanSelect.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                perusahaanSelect.innerHTML = '<option value="">Error memuat data</option>';
                perusahaanSelect.disabled = false;
            });
    }
    
    // Event listener untuk perubahan kabupaten
    kabupatenSelect.addEventListener('change', function() {
        const id_kabupaten = this.value;
        // Jika kabupaten berubah, reset perusahaan (tidak preserve selection)
        if (id_kabupaten != initialKabupatenId) {
            loadPerusahaan(id_kabupaten, false);
        } else {
            // Jika kembali ke kabupaten awal, preserve selection
            loadPerusahaan(id_kabupaten, true);
        }
    });
    
    // Load perusahaan saat halaman pertama kali dimuat
    <?php if (isset($price) && $price->id_kabupaten): ?>
    // Jika edit, perusahaan sudah di-load di PHP, enable select
    perusahaanSelect.disabled = false;
    <?php else: ?>
    // Jika create, disable perusahaan sampai kabupaten dipilih
    perusahaanSelect.disabled = true;
    <?php endif; ?>
});
</script>


