<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Jenis Pupuk & Dosis Pupuk</h1>
            <p class="text-muted mb-0">Kelola data jenis pupuk dan lihat dosis yang diinput user</p>
        </div>
        <?php if (isset($can_edit) && $can_edit): ?>
            <a href="<?= site_url('admin/pupuk/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Jenis Pupuk
            </a>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Jenis Pupuk (Master Data)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Pupuk</th>
                                    <th>Kandungan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pupuk)): ?>
                                    <?php $no = 1; foreach ($pupuk as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?php if (!empty($p->gambar_pupuk)): 
                                                    $gambar_pupuk = trim($p->gambar_pupuk);
                                                    // Jika path sudah lengkap (sudah ada assets/img/pupuk/), ambil hanya nama file
                                                    if (strpos($gambar_pupuk, 'assets/img/pupuk/') !== false) {
                                                        $gambar_pupuk = basename($gambar_pupuk);
                                                    }
                                                    $gambar_url = base_url('assets/img/pupuk/' . $gambar_pupuk);
                                                ?>
                                                    <img src="<?= $gambar_url ?>" 
                                                         alt="<?= htmlspecialchars($p->nama_pupuk) ?>" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                                         onerror="this.onerror=null; this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-muted\'>-</span>';">
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $p->nama_pupuk ?></td>
                                            <td><?= $p->kandungan ?: '-' ?></td>
                                            <td>
                                                <?php if (isset($can_edit) && $can_edit): ?>
                                                    <a href="<?= site_url('admin/pupuk/update/' . $p->id_pupuk) ?>" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (isset($can_delete) && $can_delete): ?>
                                                    <a href="<?= site_url('admin/pupuk/delete/' . $p->id_pupuk) ?>" 
                                                       class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Dosis Pupuk (Input User)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pupuk</th>
                                    <th>Tanah</th>
                                    <th>Usia Min</th>
                                    <th>Usia Max</th>
                                    <th>Dosis/Pohon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dosis)): ?>
                                    <?php $no = 1; foreach ($dosis as $d): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $d->nama_pupuk ?: 'ID: ' . $d->id_pupuk ?></td>
                                            <td><?= $d->nama_tanah ?: 'ID: ' . $d->id_tanah ?></td>
                                            <td><?= $d->usia_tanaman_min ?> tahun</td>
                                            <td><?= $d->usia_tanaman_max ?> tahun</td>
                                            <td><strong><?= number_format($d->dosis_per_pohon, 2) ?> kg</strong></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox"></i> Belum ada data dosis dari user
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
