<div class="container">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Daftar</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            <?php echo form_open('daftar'); ?>
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                    value="<?= set_value('nama_lengkap') ?>">
                <?= form_error('nama_lengkap', '<div class="error">', '</div>') ?>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" required
                    value="<?= set_value('username') ?>">
                <?= form_error('username', '<div class="error">', '</div>') ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required
                    value="<?= set_value('email') ?>">
                <?= form_error('email', '<div class="error">', '</div>') ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <?= form_error('password', '<div class="error">', '</div>') ?>
            </div>
            <div class="form-group">
                <label for="password_confirm">Konfirmasi Password</label>
                <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                <?= form_error('password_confirm', '<div class="error">', '</div>') ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            <?php echo form_close(); ?>
            <p class="auth-link">Sudah punya akun? <a href="<?= base_url('masuk') ?>">Masuk di sini</a></p>
        </div>
    </div>
</div>