
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
                        <li class="breadcrumb-item"><a href="<?= base_url(uri: 'admin/kabupaten') ?>">Kabupaten</a></li>
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
                                    <label for="nama_kabupaten" class="form-label">Nama Kabupaten</label>
                                    <input type="text" class="form-control" name="nama_kabupaten" id="nama_kabupaten"
                                        value="<?= set_value('nama_kabupaten', $kabupaten['nama_kabupaten']) ?>" aria-describedby="Nama kabupaten">
                                    <?= form_error('nama_kabupaten', '<div class="text-danger small">', '</div>') ?>
                                </div>

                                <button type="submit" class="btn btn-primary">Tambah</button>
                                <a href="<?= base_url(uri: 'admin/kabupaten') ?>" class="btn btn-danger">Kembali</a>
                            </form>
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
