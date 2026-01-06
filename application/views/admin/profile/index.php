<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header. (Page Header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $page_title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if (isset($breadcrumbs)): ?>
                            <?php foreach ($breadcrumbs as $index => $crumb): ?>
                                <?php if ($index == count($breadcrumbs) - 1): ?>
                                    <li class="breadcrumb-item active"><?= $crumb['label'] ?></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item"><a href="<?= $crumb['url'] ?>"><?= $crumb['label'] ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?= $page_title ?></li>
                        <?php endif; ?>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-person-circle"></i> Edit Profil</h5>
                        </div>
                        <div class="card-body">
                            <?php if (isset($error) && !empty($error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-circle"></i> <?= $error ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form method="POST" enctype="multipart/form-data" id="profileForm">
                                <!-- Foto Profil -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Foto Profil</label>
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="profile-photo-preview">
                                            <?php
                                            $foto_url = base_url('assets/img/users/default.png');
                                            if (!empty($user->foto_profil)) {
                                                $foto = $user->foto_profil;
                                                if (strpos($foto, 'assets/img/users/') !== false) {
                                                    $foto = basename($foto);
                                                }
                                                $foto_url = base_url('assets/img/users/' . $foto);
                                            }
                                            ?>
                                            <img src="<?= $foto_url ?>" alt="Foto Profil" id="photoPreview" 
                                                 class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #dee2e6;"
                                                 onerror="this.src='<?= base_url('assets/img/users/default.png') ?>'">
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="foto_profil" id="foto_profil" class="form-control" 
                                                   accept="image/*" onchange="previewPhoto(this)">
                                            <small class="form-text text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Informasi Akun -->
                                <div class="mb-3">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle"></i> Informasi Akun</h6>
                                    
                                    <div class="mb-3">
                                        <label for="username" class="form-label">
                                            Username <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="username" id="username" class="form-control" 
                                               value="<?= htmlspecialchars($user->username) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" 
                                               value="<?= htmlspecialchars($user->nama_lengkap) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            Email <span class="text-muted">(Opsional)</span>
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control" 
                                               value="<?= htmlspecialchars($user->email ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" value="<?= ucfirst($user->role ?? 'admin') ?>" disabled>
                                        <small class="form-text text-muted">Role tidak dapat diubah</small>
                                    </div>
                                </div>

                                <hr>

                                <!-- Ubah Password -->
                                <div class="mb-3">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-key"></i> Ubah Password</h6>
                                    <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">
                                            Password Baru <span class="text-muted">(Opsional)</span>
                                        </label>
                                        <input type="password" name="password" id="password" class="form-control" 
                                               minlength="6" placeholder="Minimal 6 karakter">
                                        <small class="form-text text-muted">Password minimal 6 karakter</small>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Simpan Perubahan
                                    </button>
                                    <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>




