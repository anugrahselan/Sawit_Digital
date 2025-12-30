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
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/harga_tbs') ?>">Harga TBS</a></li>
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
                                        <label for="id_kabupaten" class="form-label">Kabupaten</label>
                                        <select class="form-control" name="id_kabupaten" id="id_kabupaten">
                                            <option value="">Pilih Kabupaten</option>
                                            <?php foreach ($kabupaten_list as $kab): ?>
                                                <option value="<?= $kab->id_kabupaten ?>" <?= ($price->id_kabupaten == $kab->id_kabupaten) ? 'selected' : '' ?>><?= $kab->nama_kabupaten ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= form_error('id_kabupaten', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="id_perusahaan" class="form-label">Perusahaan</label>
                                        <select class="form-control" name="id_perusahaan" id="id_perusahaan">
                                            <option value="">Pilih Perusahaan</option>
                                            <?php 
                                            $perusahaan_filtered = [];
                                            foreach ($perusahaan_list as $pt) {
                                                if ($pt->id_kabupaten == $price->id_kabupaten) {
                                                    $perusahaan_filtered[] = $pt;
                                                }
                                            }
                                            foreach ($perusahaan_filtered as $pt): 
                                            ?>
                                                <option value="<?= $pt->id_perusahaan ?>" <?= ($price->id_perusahaan == $pt->id_perusahaan) ? 'selected' : '' ?>><?= $pt->nama_perusahaan ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= form_error('id_perusahaan', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $price->tanggal ?>" aria-describedby="Tanggal">
                                        <?= form_error('tanggal', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="harga_per_kg" class="form-label">Harga per Kg (Rp)</label>
                                        <input type="number" class="form-control" name="harga_per_kg" id="harga_per_kg" value="<?= $price->harga_per_kg ?>" step="0.01" min="0" aria-describedby="Harga per kg">
                                        <?= form_error('harga_per_kg', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                    <a href="<?= base_url(uri: 'admin/harga_tbs') ?>" class="btn btn-danger">Kembali</a>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kabupatenSelect = document.getElementById('id_kabupaten');
    const perusahaanSelect = document.getElementById('id_perusahaan');
    const initialKabupatenId = kabupatenSelect.value;
    const initialPerusahaanId = perusahaanSelect.value;
    
    function loadPerusahaan(id_kabupaten, preserveSelection = false) {
        if (!id_kabupaten) {
            perusahaanSelect.innerHTML = '<option value="">Pilih Kabupaten</option>';
            perusahaanSelect.disabled = true;
            return;
        }
        
        perusahaanSelect.innerHTML = '<option value="">Memuat...</option>';
        perusahaanSelect.disabled = true;
        
        fetch('<?= base_url(uri: 'admin/harga_tbs/get_perusahaan') ?>?id_kabupaten=' + id_kabupaten)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    perusahaanSelect.innerHTML = '<option value="">Pilih Perusahaan</option>';
                    if (data.data && data.data.length > 0) {
                        let foundSelected = false;
                        data.data.forEach(function(pt) {
                            const option = document.createElement('option');
                            option.value = pt.id_perusahaan;
                            option.textContent = pt.nama_perusahaan;
                            if (preserveSelection && initialPerusahaanId && initialPerusahaanId == pt.id_perusahaan) {
                                option.selected = true;
                                foundSelected = true;
                            }
                            perusahaanSelect.appendChild(option);
                        });
                        if (preserveSelection && !foundSelected && initialPerusahaanId) {
                            perusahaanSelect.value = '';
                        }
                        perusahaanSelect.disabled = false;
                    } else {
                        perusahaanSelect.innerHTML = '<option value="">Tidak ada perusahaan di kabupaten ini</option>';
                        perusahaanSelect.disabled = true;
                    }
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
    
    kabupatenSelect.addEventListener('change', function() {
        if (this.value != initialKabupatenId) {
            loadPerusahaan(this.value, false);
        } else {
            loadPerusahaan(this.value, true);
        }
    });
    
    perusahaanSelect.disabled = false;
});
</script>
