<div class="container">
    <div class="page-header">
        <h1 class="page-title">Edit Profil</h1>
        <p class="page-subtitle">Kelola informasi dan foto profil Anda</p>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-error">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <div class="profile-edit-container">
        <div class="profile-edit-form">
            <form method="POST" enctype="multipart/form-data" id="profileForm">
                <div class="form-section">
                    <h2 class="section-title">Foto Profil</h2>
                    <div class="profile-photo-section">
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
                                 onerror="this.src='<?= base_url('assets/img/users/default.png') ?>'">
                        </div>
                        <div class="form-group">
                            <label for="foto_profil" class="form-label">Unggah Foto Profil</label>
                            <input type="file" name="foto_profil" id="foto_profil" class="form-control" 
                                   accept="image/*" onchange="previewPhoto(this)">
                            <small class="form-hint">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Informasi Akun</h2>
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <span class="label-text">Username</span>
                            <span class="label-required">*</span>
                        </label>
                        <input type="text" name="username" id="username" class="form-control" 
                               value="<?= htmlspecialchars($user->username) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap" class="form-label">
                            <span class="label-text">Nama Lengkap</span>
                            <span class="label-required">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" 
                               value="<?= htmlspecialchars($user->nama_lengkap) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <span class="label-text">Email</span>
                            <span class="label-hint">(Opsional)</span>
                        </label>
                        <input type="email" name="email" id="email" class="form-control" 
                               value="<?= htmlspecialchars($user->email ?? '') ?>">
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Ubah Password</h2>
                    <p class="section-description">Kosongkan jika tidak ingin mengubah password</p>
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <span class="label-text">Password Baru</span>
                            <span class="label-hint">(Opsional)</span>
                        </label>
                        <input type="password" name="password" id="password" class="form-control" 
                               minlength="6" placeholder="Minimal 6 karakter">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-text">Simpan Perubahan</span>
                    </button>
                    <a href="<?= site_url('beranda') ?>" class="btn btn-secondary">
                        <span class="btn-text">Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

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

