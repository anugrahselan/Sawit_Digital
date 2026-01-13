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

        <div class="auth-illustration" style="background-image: url('<?= base_url('assets/img/hero/login.jpg') ?>');">

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

            <div class="illustration-footer">
                <p>© 2025 Sawit Digital | Powered by Sawit Digital</p>
            </div>

            <div class="blur-circles">
                <div class="blur-circle circle-1"></div>
                <div class="blur-circle circle-2"></div>
                <div class="blur-circle circle-3"></div>
                <div class="blur-circle circle-4"></div>
            </div>
        </div>

        <div class="auth-form-section">
            <div class="form-wrapper">

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
                            <div class="password-input-wrapper">
                                <input type="password" id="login_password" name="password" class="form-input" required
                                    placeholder="Masukkan password" autocomplete="current-password" data-form-type="password">
                                <button type="button" class="password-toggle" id="toggleLoginPassword" aria-label="Toggle password visibility">
                                    <svg class="eye-icon eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg class="eye-icon eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </button>
                            </div>
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
                            <div class="label-row">
                                <label for="register_password" class="form-label">Password</label>
                            </div>
                            <div class="password-input-wrapper">
                                <input type="password" id="register_password" name="password" class="form-input" required
                                    placeholder="Masukkan password (min. 8 karakter)" minlength="8"
                                    autocomplete="new-password" data-form-type="password">
                                <button type="button" class="password-toggle" id="toggleRegisterPassword" aria-label="Toggle password visibility">
                                    <svg class="eye-icon eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg class="eye-icon eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                            <?= form_error('password', '<div class="field-error">', '</div>') ?>
                        </div>

                        <div class="form-group">
                            <div class="label-row">
                                <label for="register_password_confirm" class="form-label">Confirm Password</label>
                            </div>
                            <div class="password-input-wrapper">
                                <input type="password" id="register_password_confirm" name="password_confirm"
                                    class="form-input" required placeholder="Masukkan password (min. 8 karakter)"
                                    minlength="8" autocomplete="new-password" data-form-type="password">
                                <button type="button" class="password-toggle" id="toggleRegisterPasswordConfirm" aria-label="Toggle password visibility">
                                    <svg class="eye-icon eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg class="eye-icon eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </button>
                            </div>
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

        // Auto-hide error messages after 5 seconds
        const errorMessages = document.querySelectorAll('.form-error');
        errorMessages.forEach(errorMsg => {
            setTimeout(() => {
                errorMsg.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                errorMsg.style.opacity = '0';
                errorMsg.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    errorMsg.remove();
                }, 500);
            }, 5000); // Hide after 5 seconds
        });

        // Password toggle functionality
        function setupPasswordToggle(toggleId, inputId) {
            const toggleBtn = document.getElementById(toggleId);
            const passwordInput = document.getElementById(inputId);
            
            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    const eyeOpen = toggleBtn.querySelector('.eye-open');
                    const eyeClosed = toggleBtn.querySelector('.eye-closed');
                    
                    if (type === 'text') {
                        eyeOpen.style.display = 'none';
                        eyeClosed.style.display = 'block';
                    } else {
                        eyeOpen.style.display = 'block';
                        eyeClosed.style.display = 'none';
                    }
                });
            }
        }

        // Setup password toggles
        setupPasswordToggle('toggleLoginPassword', 'login_password');
        setupPasswordToggle('toggleRegisterPassword', 'register_password');
        setupPasswordToggle('toggleRegisterPasswordConfirm', 'register_password_confirm');
    </script>
</body>

</html>