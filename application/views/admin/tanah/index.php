<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Jenis Tanah</h1>
            <p class="text-muted mb-0">Kelola data jenis tanah</p>
        </div>
        <?php if (isset($can_edit) && $can_edit): ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">
                <i class="bi bi-plus-circle"></i> Tambah Jenis Tanah
            </button>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tanah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tanah)): ?>
                            <?php $no = 1; foreach ($tanah as $t): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $t->nama_tanah ?></td>
                                    <td>
                                        <?php if (isset($can_edit) && $can_edit): ?>
                                            <button class="btn btn-sm btn-warning" onclick="editTanah(<?= $t->id_tanah ?>, '<?= htmlspecialchars($t->nama_tanah) ?>')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        <?php endif; ?>
                                        <?php if (isset($can_delete) && $can_delete): ?>
                                            <button class="btn btn-sm btn-danger" onclick="deleteTanah(<?= $t->id_tanah ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada data jenis tanah
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jenis Tanah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="tanahForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_tanah" id="id_tanah">
                    <div class="mb-3">
                        <label class="form-label">Nama Tanah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_tanah" id="nama_tanah" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editTanah(id, nama) {
    document.getElementById('id_tanah').value = id;
    document.getElementById('nama_tanah').value = nama;
    document.querySelector('#formModal .modal-title').textContent = 'Edit Jenis Tanah';
    new bootstrap.Modal(document.getElementById('formModal')).show();
}

function deleteTanah(id) {
    if (confirm('Yakin ingin menghapus data ini?')) {
        window.location.href = '<?= site_url('admin/tanah/delete/') ?>' + id;
    }
}

document.getElementById('tanahForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const id = formData.get('id_tanah');
    const url = id ? '<?= site_url('admin/tanah/update/') ?>' + id : '<?= site_url('admin/tanah/create') ?>';
    
    fetch(url, {
        method: 'POST',
        body: formData
    }).then(() => {
        location.reload();
    });
});

document.getElementById('formModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('tanahForm').reset();
    document.getElementById('id_tanah').value = '';
    document.querySelector('#formModal .modal-title').textContent = 'Tambah Jenis Tanah';
});
</script>

