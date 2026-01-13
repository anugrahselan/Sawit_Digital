
<div class="content-wrapper">
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $page_title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/perusahaan') ?>">Perusahaan</a></li>
                        <li class="breadcrumb-item active"><?= $page_title ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
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
                                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan" value="<?= set_value('nama_perusahaan', $perusahaan['nama_perusahaan']) ?>" aria-describedby="Nama perusahaan">
                                        <?= form_error('nama_perusahaan', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="id_kabupaten" class="form-label">Kabupaten</label>
                                        <select class="form-control" name="id_kabupaten" id="id_kabupaten">
                                            <option value="">Pilih Kabupaten</option>
                                            <?php foreach ($kabupaten_list as $kab): ?>
                                                <option value="<?= $kab['id_kabupaten'] ?>" <?= (set_value('id_kabupaten', $perusahaan['id_kabupaten']) == $kab['id_kabupaten']) ? 'selected' : '' ?>><?= $kab['nama_kabupaten'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= form_error('id_kabupaten', '<div class="text-danger small">', '</div>') ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"><?= set_value('alamat', $perusahaan['alamat']) ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="kontak" class="form-label">Kontak</label>
                                        <input type="text" class="form-control" name="kontak" id="kontak" value="<?= set_value('kontak', $perusahaan['kontak']) ?>" aria-describedby="Kontak">
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                    <a href="<?= base_url(uri: 'admin/perusahaan') ?>" class="btn btn-danger">Kembali</a>
                                </form>
                            </p>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    