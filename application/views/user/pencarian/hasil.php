<div class="container">
    <h1 class="page-title">Hasil Pencarian</h1>
    <p class="page-subtitle">Hasil pencarian untuk: "<strong><?= htmlspecialchars($keyword) ?></strong>"</p>

    <?php if (!empty($articles) || !empty($fertilizers) || !empty($penyakit)): ?>
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

        <?php if (!empty($penyakit)): ?>
            <section class="search-section">
                <h2 class="section-title">Penyakit (<?= count($penyakit) ?>)</h2>
                <div class="disease-grid">
                    <?php foreach ($penyakit as $p): ?>
                        <div class="disease-card">
                            <a href="<?= site_url('penyakit/detail/' . $p->id_penyakit) ?>" class="disease-card-link">
                                <div class="disease-header">
                                    <?php if (!empty($p->gambar_ilustrasi)):
                                        $gambar_penyakit = trim($p->gambar_ilustrasi);
                                        if (strpos($gambar_penyakit, 'assets/img/penyakit/') !== false) {
                                            $gambar_penyakit = basename($gambar_penyakit);
                                        }
                                        $gambar_url = base_url('assets/img/penyakit/' . $gambar_penyakit);
                                    ?>
                                        <div class="disease-image">
                                            <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($p->nama_penyakit) ?>"
                                                style="max-width: 100%; height: auto; display: block;"
                                                onerror="this.onerror=null; this.style.display='none';">
                                        </div>
                                    <?php endif; ?>
                                    <h3><?= htmlspecialchars($p->nama_penyakit) ?></h3>
                                </div>
                                <div class="disease-body">
                                    <?php if (!empty($p->penyebab)): ?>
                                        <div class="disease-section">
                                            <h4>Penyebab</h4>
                                            <p><?= character_limiter($p->penyebab, 150) ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($p->gejala)): ?>
                                        <div class="disease-section">
                                            <h4>Gejala</h4>
                                            <p><?= character_limiter($p->gejala, 150) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="disease-card-footer">
                                    <span class="read-more">Baca Selengkapnya →</span>
                                </div>
                            </a>
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