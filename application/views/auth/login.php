<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Masuk - Sistem Penyuluhan Sawit' ?></title>
    <?php $cache = '?v=' . time(); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Inter:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css') . $cache; ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth/login.css') . $cache; ?>">
</head>

<body class="auth-page">
    <div class="auth-container">
        <!-- LEFT SIDE - ILLUSTRATION SECTION (45%) -->
        <div class="auth-illustration" style="background-image: url('<?= base_url('assets/img/hero/login.jpg') ?>');">
            <!-- Header -->
            <div class="illustration-header">
                <div class="logo-container">
                    <div class="logo-icon">
                        <img src="<?= base_url('assets/img/logo/logo.png') ?>" alt="Sawit Digital Logo"
                            class="logo-image">
                    </div>
                    <div class="logo-text">
                        <div class="logo-main">SAWIT DIGITAL</div>
                        <div class="logo-subtitle">Sistem Penyuluhan</div>
                    </div>
                </div>
            </div>

            <!-- Center - Main Illustration -->
            <div class="illustration-center">
                <div class="illustration-icon-wrapper">
                    <div class="illustration-icon">
                        <img src="<?= base_url('assets/img/logo/logo.png') ?>" alt="Sawit Digital"
                            class="illustration-logo">
                    </div>
                    <div class="illustration-circle"></div>
                </div>
                <div class="illustration-text">
                    <h2 class="illustration-heading">Selamat Datang</h2>
                    <p class="illustration-description">Sistem Informasi Penyuluhan Sawit Digital untuk kemajuan
                        perkebunan kelapa sawit Indonesia</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="illustration-footer">
                <p>© 2025 Sawit Digital | Powered by Sawit Digital</p>
            </div>

            <!-- Background Blur Circles -->
            <div class="blur-circles">
                <div class="blur-circle circle-1"></div>
                <div class="blur-circle circle-2"></div>
                <div class="blur-circle circle-3"></div>
                <div class="blur-circle circle-4"></div>
            </div>
        </div>

        <!-- RIGHT SIDE - FORM SECTION (55%) -->
        <div class="auth-form-section">
            <div class="form-wrapper">
                <!-- LOGIN FORM -->
                <div class="auth-form" id="loginForm"
                    style="display: <?= isset($register_error) && !empty($register_error) ? 'none' : 'block' ?>;">
                    <div class="form-header">
                        <h1 class="form-title">Login</h1>
                        <p class="form-subtitle">Silakan masuk ke akun Anda</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="form-error">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span><?= htmlspecialchars($error) ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= site_url('masuk') ?>" id="loginFormSubmit">
                        <div class="form-group">
                            <label for="login_username" class="form-label">Username Or Email</label>
                            <input type="text" id="login_username" name="username" class="form-input" required
                                placeholder="Masukkan username Or Email" value="<?= set_value('username') ?>"
                                autocomplete="username">
                        </div>

                        <div class="form-group">
                            <div class="label-row">
                                <label for="login_password" class="form-label">Password</label>
                                <a href="#" class="forgot-link">Lupa Password?</a>
                            </div>
                            <input type="password" id="login_password" name="password" class="form-input" required
                                placeholder="Masukkan password" autocomplete="current-password">
                        </div>

                        <button type="submit" class="submit-btn" id="loginBtn">
                            <span>Login</span>
                        </button>
                    </form>

                    <div class="form-toggle">
                        <p>Belum punya akun? <a href="#" id="showRegister">Daftar Sekarang</a></p>
                    </div>

                    <div class="form-footer">
                        <a href="#" class="footer-link">Terms and Services</a>
                    </div>
                </div>

                <!-- REGISTER FORM -->
                <div class="auth-form" id="registerForm"
                    style="display: <?= isset($register_error) && !empty($register_error) ? 'block' : 'none' ?>;">
                    <div class="form-header">
                        <h1 class="form-title">Daftar</h1>
                        <p class="form-subtitle">Buat akun baru Anda</p>
                    </div>

                    <?php if (isset($register_error)): ?>
                        <div class="form-error">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span><?= htmlspecialchars($register_error) ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= site_url('auth/register') ?>" id="registerFormSubmit">
                        <div class="form-group">
                            <label for="register_username" class="form-label">Username</label>
                            <input type="text" id="register_username" name="username" class="form-input" required
                                placeholder="Masukkan username" maxlength="50" value="<?= set_value('username') ?>"
                                autocomplete="username">
                            <?= form_error('username', '<div class="field-error">', '</div>') ?>
                        </div>

                        <div class="form-group">
                            <label for="register_nama" class="form-label">Nama Lengkap</label>
                            <input type="text" id="register_nama" name="nama_lengkap" class="form-input" required
                                placeholder="Masukkan nama lengkap" maxlength="100"
                                value="<?= set_value('nama_lengkap') ?>" autocomplete="name">
                            <?= form_error('nama_lengkap', '<div class="field-error">', '</div>') ?>
                        </div>

                        <div class="form-group">
                            <label for="register_email" class="form-label">Email</label>
                            <input type="email" id="register_email" name="email" class="form-input"
                                placeholder="Masukkan email" maxlength="100" value="<?= set_value('email') ?>"
                                autocomplete="email">
                            <?= form_error('email', '<div class="field-error">', '</div>') ?>
                        </div>

                        <div class="form-group">
                            <label for="register_password" class="form-label">Password</label>
                            <input type="password" id="register_password" name="password" class="form-input" required
                                placeholder="Masukkan password (min. 8 karakter)" minlength="8"
                                autocomplete="new-password">
                            <?= form_error('password', '<div class="field-error">', '</div>') ?>
                        </div>

                        <div class="form-group">
                            <label for="register_password_confirm" class="form-label">Confirm Password</label>
                            <input type="password" id="register_password_confirm" name="password_confirm"
                                class="form-input" required placeholder="Masukkan password (min. 8 karakter)"
                                minlength="8" autocomplete="new-password">
                            <?= form_error('password_confirm', '<div class="field-error">', '</div>') ?>
                        </div>

                        <button type="submit" class="submit-btn" id="registerBtn">
                            <span>Daftar</span>
                        </button>
                    </form>

                    <div class="form-toggle">
                        <p>Sudah punya akun? <a href="#" id="showLogin">Login</a></p>
                    </div>

                    <div class="form-footer">
                        <p>Dengan mendaftar, Anda menyetujui <a href="#" class="footer-link">Terms and Services</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle between Login and Register
        const showRegisterBtn = document.getElementById('showRegister');
        const showLoginBtn = document.getElementById('showLogin');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        if (showRegisterBtn) {
            showRegisterBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (loginForm) loginForm.style.display = 'none';
                if (registerForm) registerForm.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        if (showLoginBtn) {
            showLoginBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (registerForm) registerForm.style.display = 'none';
                if (loginForm) loginForm.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Form submission loading states
        const loginFormSubmit = document.getElementById('loginFormSubmit');
        const registerFormSubmit = document.getElementById('registerFormSubmit');
        const loginBtn = document.getElementById('loginBtn');
        const registerBtn = document.getElementById('registerBtn');

        if (loginFormSubmit) {
            loginFormSubmit.addEventListener('submit', function () {
                if (loginBtn) {
                    loginBtn.classList.add('loading');
                    loginBtn.disabled = true;
                    const span = loginBtn.querySelector('span');
                    if (span) span.textContent = 'Memproses...';
                }
            });
        }

        if (registerFormSubmit) {
            registerFormSubmit.addEventListener('submit', function () {
                if (registerBtn) {
                    registerBtn.classList.add('loading');
                    registerBtn.disabled = true;
                    const span = registerBtn.querySelector('span');
                    if (span) span.textContent = 'Mendaftar...';
                }
            });
        }

        // Input focus effects
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function () {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>

</html>