<div class="container">
    <h1 class="page-title">Hasil Pencarian</h1>
    <p class="page-subtitle">Hasil pencarian untuk: "<strong><?= htmlspecialchars($keyword) ?></strong>"</p>

    <?php if (!empty($articles) || !empty($fertilizers)): ?>
        <?php if (!empty($articles)): ?>
            <section class="search-section">
                <h2 class="section-title">Artikel (<?= count($articles) ?>)</h2>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <?php $this->load->view('user/partials/kartu_artikel', ['article' => $article]); ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($fertilizers)): ?>
            <section class="search-section">
                <h2 class="section-title">Pupuk (<?= count($fertilizers) ?>)</h2>
                <div class="fertilizer-grid">
                    <?php foreach ($fertilizers as $fertilizer): ?>
                        <div class="fertilizer-card">
                            <div class="fertilizer-header">
                                <?php if (!empty($fertilizer->gambar_pupuk)):
                                    $gambar_pupuk = trim($fertilizer->gambar_pupuk);
                                    if (strpos($gambar_pupuk, 'assets/img/pupuk/') !== false) {
                                        $gambar_pupuk = basename($gambar_pupuk);
                                    }
                                    $gambar_url = base_url('assets/img/pupuk/' . $gambar_pupuk);
                                    ?>
                                    <div class="fertilizer-image">
                                        <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($fertilizer->nama_pupuk) ?>"
                                            style="max-width: 100%; height: auto; display: block;"
                                            onerror="this.onerror=null; this.style.display='none';">
                                    </div>
                                <?php endif; ?>
                                <h3><?= $fertilizer->nama_pupuk ?></h3>
                            </div>
                            <div class="fertilizer-body">
                                <?php if (!empty($fertilizer->fungsi)): ?>
                                    <div class="fertilizer-section">
                                        <h4>Fungsi</h4>
                                        <p><?= character_limiter($fertilizer->fungsi, 150) ?></p>
                                    </div>
                                <?php endif; ?>
                                <a href="<?= site_url('jenis-pupuk') ?>" class="btn btn-primary"
                                    style="margin-top: 1rem; width: 100%; text-align: center;">Lihat Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    <?php else: ?>
        <div class="no-results">
            <div style="font-size: 4rem; margin-bottom: 1.5rem;">🔍</div>
            <h2 style="font-size: 1.8rem; margin-bottom: 1rem; color: var(--primary-color);">Tidak ada hasil ditemukan</h2>
            <p style="font-size: 1.1rem; color: var(--text-light); margin-bottom: 2rem;">Tidak ada hasil untuk pencarian
                "<strong><?= htmlspecialchars($keyword) ?></strong>"</p>
            <a href="<?= site_url('beranda') ?>" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    <?php endif; ?>
</div>