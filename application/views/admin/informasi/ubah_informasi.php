
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
                                        <input type="text" class="form-control" name="judul" id="judul" value="<?= set_value('judul', $article['judul']) ?>" aria-describedby="Judul">
                                        <?= form_error('judul', '<div class="text-danger small">', '</div>') ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori" class="form-label">Kategori</label>
                                            <input type="text" class="form-control" name="kategori" id="kategori" value="<?= set_value('kategori', $article['kategori']) ?>" placeholder="Contoh: Budidaya, Pemupukan, dll" aria-describedby="Kategori">
                                            <?= form_error('kategori', '<div class="text-danger small">', '</div>') ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="penulis" class="form-label">Penulis</label>
                                            <input type="text" class="form-control" name="penulis" id="penulis" value="<?= set_value('penulis', $article['penulis']) ?>" placeholder="Nama penulis artikel" aria-describedby="Penulis">
                                            <?= form_error('penulis', '<div class="text-danger small">', '</div>') ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="gambar_header" class="form-label">Gambar Header</label>
                                        <?php if (!empty($article['gambar_header'])): 
                                            $gambar_header = trim($article['gambar_header']);
                                            if (strpos($gambar_header, 'assets/img/articles/') !== false) {
                                                $gambar_header = basename($gambar_header);
                                            }
                                            $gambar_url = base_url(uri: 'assets/img/articles/' . $gambar_header);
                                        ?>
                                            <div class="mb-2">
                                                <img src="<?= $gambar_url ?>" alt="Gambar Header saat ini" style="max-width: 200px; height: auto; border-radius: 4px;" onerror="this.onerror=null; this.style.display='none';">
                                                <p class="text-muted small mt-1">Gambar Header saat ini</p>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" name="gambar_header" id="gambar_header" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Thumbnail</label>
                                        <?php if (!empty($article['thumbnail'])): 
                                            $thumbnail = trim($article['thumbnail']);
                                            if (strpos($thumbnail, 'assets/img/articles/') !== false) {
                                                $thumbnail = basename($thumbnail);
                                            }
                                            $thumbnail_url = base_url(uri: 'assets/img/articles/' . $thumbnail);
                                        ?>
                                            <div class="mb-2">
                                                <img src="<?= $thumbnail_url ?>" alt="Thumbnail saat ini" style="max-width: 200px; height: auto; border-radius: 4px;" onerror="this.onerror=null; this.style.display='none';">
                                                <p class="text-muted small mt-1">Thumbnail saat ini</p>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="konten" class="form-label">Konten</label>
                                        <textarea name="konten" id="konten" cols="30" rows="15" class="form-control"><?= set_value('konten', $article['konten']) ?></textarea>
                                        <?= form_error('konten', '<div class="text-danger small">', '</div>') ?>
                                        <small class="text-muted">Gunakan HTML untuk formatting teks</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= set_value('tanggal', $article['tanggal']) ?>" aria-describedby="Tanggal">
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
