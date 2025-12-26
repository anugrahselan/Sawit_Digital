<div class="container">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Masuk</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-error"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>
            <?php if (validation_errors()): ?>
                <div class="alert alert-error"><?= validation_errors() ?></div>
            <?php endif; ?>
            <?php echo form_open(site_url('masuk')); ?>
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
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            <?php echo form_close(); ?>
            <p class="auth-link">Belum punya akun? <a href="<?= base_url('daftar') ?>">Daftar di sini</a></p>
        </div>
    </div>
</div>