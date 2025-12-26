<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Harga TBS</h1>
            <p class="text-muted mb-0">Kelola data harga TBS per perusahaan</p>
        </div>
        <?php if (isset($can_edit) && $can_edit): ?>
            <a href="<?= site_url('admin/harga_tbs/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Harga TBS
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

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" action="<?= site_url('admin/harga_tbs') ?>" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Kabupaten</label>
                    <select name="kabupaten" class="form-select">
                        <option value="">Semua Kabupaten</option>
                        <?php foreach ($kabupaten_list as $kab): ?>
                            <option value="<?= $kab->id_kabupaten ?>" <?= ($filters['kabupaten'] == $kab->id_kabupaten) ? 'selected' : '' ?>>
                                <?= $kab->nama_kabupaten ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Perusahaan</label>
                    <select name="perusahaan" class="form-select">
                        <option value="">Semua Perusahaan</option>
                        <?php foreach ($perusahaan_list as $pt): ?>
                            <option value="<?= $pt->id_perusahaan ?>" <?= ($filters['perusahaan'] == $pt->id_perusahaan) ? 'selected' : '' ?>>
                                <?= $pt->nama_perusahaan ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="<?= $filters['date_from'] ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="<?= $filters['date_to'] ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kabupaten</th>
                            <th>Perusahaan</th>
                            <th>Harga/Kg</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($prices)): ?>
                            <?php $no = 1; foreach ($prices as $price): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d M Y', strtotime($price->tanggal)) ?></td>
                                    <td><?= $price->nama_kabupaten ?: '-' ?></td>
                                    <td><?= $price->nama_perusahaan ?: '-' ?></td>
                                    <td><strong>Rp <?= number_format($price->harga_per_kg, 0, ',', '.') ?></strong></td>
                                    <td>
                                        <?php if (isset($can_edit) && $can_edit): ?>
                                            <a href="<?= site_url('admin/harga_tbs/update/' . $price->id_harga) ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (isset($can_delete) && $can_delete): ?>
                                            <a href="<?= site_url('admin/harga_tbs/delete/' . $price->id_harga) ?>" 
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
                                    <i class="bi bi-inbox"></i> Belum ada data harga TBS
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

