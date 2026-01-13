
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
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/informasi') ?>">Informasi</a></li>
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

                                <form method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" class="form-control" name="judul" id="judul" value="<?= set_value('judul') ?>" aria-describedby="Judul">
                                        <?= form_error('judul', '<div class="text-danger small">', '</div>') ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori" class="form-label">Kategori</label>
                                            <input type="text" class="form-control" name="kategori" id="kategori" value="<?= set_value('kategori') ?>" placeholder="Contoh: Budidaya, Pemupukan, dll" aria-describedby="Kategori">
                                            <?= form_error('kategori', '<div class="text-danger small">', '</div>') ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="penulis" class="form-label">Penulis</label>
                                            <input type="text" class="form-control" name="penulis" id="penulis" value="<?= set_value('penulis') ?>" placeholder="Nama penulis artikel" aria-describedby="Penulis">
                                            <?= form_error('penulis', '<div class="text-danger small">', '</div>') ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="gambar_header" class="form-label">Gambar Header</label>
                                        <input type="file" class="form-control" name="gambar_header" id="gambar_header" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Thumbnail</label>
                                        <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="konten" class="form-label">Konten</label>
                                        <textarea name="konten" id="konten" cols="30" rows="15" class="form-control"><?= set_value('konten') ?></textarea>
                                        <?= form_error('konten', '<div class="text-danger small">', '</div>') ?>
                                        <small class="text-muted">Gunakan HTML untuk formatting teks</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= set_value('tanggal', date('Y-m-d')) ?>" aria-describedby="Tanggal">
                                        <?= form_error('tanggal', '<div class="text-danger small">', '</div>') ?>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                    <a href="<?= base_url(uri: 'admin/informasi') ?>" class="btn btn-danger">Kembali</a>
                                </form>
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
