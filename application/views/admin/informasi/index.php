<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Informasi (Artikel)</h1>
            <p class="text-muted mb-0">Kelola artikel dan informasi</p>
        </div>
        <?php if (isset($can_edit) && $can_edit): ?>
            <a href="#" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Artikel
            </a>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($articles)): ?>
                            <?php $no = 1; foreach ($articles as $art): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $art->judul ?></td>
                                    <td><?= $art->kategori ?: '-' ?></td>
                                    <td><?= $art->penulis ?: '-' ?></td>
                                    <td><?= date('d M Y', strtotime($art->tanggal)) ?></td>
                                    <td>
                                        <a href="<?= site_url('informasi/' . $art->id_info) ?>" class="btn btn-sm btn-info" target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php if (isset($can_edit) && $can_edit): ?>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        <?php endif; ?>
                                        <?php if (isset($can_delete) && $can_delete): ?>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada artikel
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

