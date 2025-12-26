<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Users & Roles</h1>
            <p class="text-muted mb-0">Kelola pengguna dan peran</p>
        </div>
        <a href="#" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php $no = 1; foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $user->nama_lengkap ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->username ?></td>
                                    <td>
                                        <?php
                                        $badge_class = 'secondary';
                                        if ($user->role == 'admin') $badge_class = 'danger';
                                        elseif ($user->role == 'penyuluh') $badge_class = 'warning';
                                        ?>
                                        <span class="badge bg-<?= $badge_class ?>"><?= ucfirst($user->role) ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Belum ada data user
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


