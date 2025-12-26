<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Admin Login' ?> - Sawit Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Roboto', sans-serif;
        }
        .login-card {
            background: #FAFAFA;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            max-width: 450px;
            width: 100%;
            padding: 2.5rem;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo i {
            font-size: 3rem;
            color: #1B5E20;
        }
        .login-logo h1 {
            color: #1B5E20;
            font-size: 1.75rem;
            font-weight: 700;
            margin-top: 0.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0D4A12 0%, #1B5E20 100%);
        }
        .form-control:focus {
            border-color: #1B5E20;
            box-shadow: 0 0 0 0.2rem rgba(27, 94, 32, 0.25);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <i class="bi bi-tree-fill"></i>
            <h1>Sawit Digital</h1>
            <p class="text-muted mb-0">Admin Panel</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> <?= validation_errors() ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= site_url('admin/login') ?>" id="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i> Masuk
            </button>
        </form>
        
        <div class="text-center mt-4">
            <a href="<?= site_url('beranda') ?>" class="text-decoration-none text-muted">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

