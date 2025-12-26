<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Jenis Penyakit</h1>
            <p class="text-muted mb-0">Kelola data penyakit sawit</p>
        </div>
        <?php if (isset($can_edit) && $can_edit): ?>
            <a href="<?= site_url('admin/penyakit/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Penyakit
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
                            <th>Gambar</th>
                            <th>Nama Penyakit</th>
                            <th>Penyebab</th>
                            <th>Gejala</th>
                            <th>Cara Pengendalian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($penyakit)): ?>
                            <?php $no = 1; foreach ($penyakit as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if (!empty($p->gambar_ilustrasi)): 
                                            $gambar_penyakit = trim($p->gambar_ilustrasi);
                                            // Jika path sudah lengkap (sudah ada assets/img/penyakit/), ambil hanya nama file
                                            if (strpos($gambar_penyakit, 'assets/img/penyakit/') !== false) {
                                                $gambar_penyakit = basename($gambar_penyakit);
                                            }
                                            $gambar_url = base_url('assets/img/penyakit/' . $gambar_penyakit);
                                        ?>
                                            <img src="<?= $gambar_url ?>" 
                                                 alt="<?= htmlspecialchars($p->nama_penyakit) ?>" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                                 onerror="this.onerror=null; this.style.display='none'; this.parentElement.innerHTML='<span class=\'text-muted\'>-</span>';">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= $p->nama_penyakit ?></strong></td>
                                    <td><?= character_limiter($p->penyebab, 50) ?: '-' ?></td>
                                    <td><?= character_limiter($p->gejala, 50) ?: '-' ?></td>
                                    <td><?= character_limiter($p->cara_pengendalian, 50) ?: '-' ?></td>
                                    <td>
                                        <?php if (isset($can_edit) && $can_edit): ?>
                                            <a href="<?= site_url('admin/penyakit/update/' . $p->id_penyakit) ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (isset($can_delete) && $can_delete): ?>
                                            <a href="<?= site_url('admin/penyakit/delete/' . $p->id_penyakit) ?>" 
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
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada data penyakit
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
