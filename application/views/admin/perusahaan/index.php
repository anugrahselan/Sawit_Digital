<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Perusahaan</h1>
            <p class="text-muted mb-0">Kelola data perusahaan</p>
        </div>
        <?php if (isset($can_edit) && $can_edit): ?>
            <a href="<?= site_url('admin/perusahaan/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Perusahaan
            </a>
        <?php endif; ?>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Perusahaan</th>
                            <th>Kabupaten</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($perusahaan)): ?>
                            <?php $no = 1; foreach ($perusahaan as $pt): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $pt->nama_perusahaan ?></td>
                                    <td><?= $pt->nama_kabupaten ?: '-' ?></td>
                                    <td><?= $pt->alamat ?: '-' ?></td>
                                    <td><?= $pt->kontak ?: '-' ?></td>
                                    <td>
                                        <?php if (isset($can_edit) && $can_edit): ?>
                                            <a href="<?= site_url('admin/perusahaan/update/' . $pt->id_perusahaan) ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (isset($can_delete) && $can_delete): ?>
                                            <a href="<?= site_url('admin/perusahaan/delete/' . $pt->id_perusahaan) ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada data perusahaan
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (isset($pagination_links)): ?>
                <div class="mt-3">
                    <?= $pagination_links ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

