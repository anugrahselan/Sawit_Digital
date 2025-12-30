<div class="container">
    <article class="disease-detail">
        <?php
        // Cek dan ambil gambar
        $gambar = null;
        $gambar_url = null;
        if (property_exists($penyakit, 'gambar_ilustrasi') && !empty($penyakit->gambar_ilustrasi)) {
            $gambar = trim($penyakit->gambar_ilustrasi);

            // Jika path sudah lengkap (sudah ada assets/img/penyakit/), ambil hanya nama file
            if (strpos($gambar, 'assets/img/penyakit/') !== false) {
                $gambar = basename($gambar);
            }

            // Buat URL lengkap
            $gambar_url = base_url('assets/img/penyakit/' . $gambar);
        }
        ?>

        <div class="disease-detail-content">
            <div class="disease-main-layout">
                <?php if ($gambar_url): ?>
                    <div class="disease-image-section">
                        <div class="disease-header-image">
                            <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($penyakit->nama_penyakit) ?>"
                                onerror="this.onerror=null; this.style.display='none'; console.error('Gambar gagal dimuat: <?= $gambar_url ?>');">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="disease-info-section">
                    <div class="disease-header-info">
                        <h1 class="disease-title"><?= htmlspecialchars($penyakit->nama_penyakit) ?></h1>
                        <div class="disease-badge">
                            <span class="badge-icon">🦠</span>
                            <span>Penyakit Tanaman Sawit</span>
                        </div>
                    </div>

                    <div class="disease-info-grid">
                        <?php if (!empty($penyakit->penyebab)): ?>
                            <div class="disease-section">
                                <div class="disease-section-header">
                                    <span class="section-icon">🔍</span>
                                    <h2 class="disease-section-title">Penyebab</h2>
                                </div>
                                <div class="disease-section-content">
                                    <p><?= nl2br(htmlspecialchars($penyakit->penyebab)) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($penyakit->gejala)): ?>
                            <div class="disease-section">
                                <div class="disease-section-header">
                                    <span class="section-icon">⚠️</span>
                                    <h2 class="disease-section-title">Gejala</h2>
                                </div>
                                <div class="disease-section-content">
                                    <p><?= nl2br(htmlspecialchars($penyakit->gejala)) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($penyakit->cara_pengendalian)): ?>
                            <div class="disease-section">
                                <div class="disease-section-header">
                                    <span class="section-icon">💊</span>
                                    <h2 class="disease-section-title">Cara Pengendalian</h2>
                                </div>
                                <div class="disease-section-content">
                                    <p><?= nl2br(htmlspecialchars($penyakit->cara_pengendalian)) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="disease-actions">
            <a href="<?= site_url('penyakit') ?>" class="btn btn-secondary">
                <span>←</span> Kembali ke Daftar Jenis Penyakit
            </a>
        </div>
    </article>
</div>