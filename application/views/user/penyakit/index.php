<div class="container">
    <h1 class="page-title">Jenis Penyakit Sawit</h1>
    <p class="page-subtitle">Kenali berbagai penyakit yang dapat menyerang tanaman sawit</p>

    <div class="disease-grid">
        <?php if(!empty($penyakit)): ?>
            <?php foreach($penyakit as $p): ?>
                <div class="disease-card">
                    <a href="<?= site_url('penyakit/detail/' . $p['id_penyakit']) ?>" class="disease-card-link">
                        <div class="disease-header">
                            <?php if(!empty($p['gambar_ilustrasi'])): 

                                $gambar_penyakit = trim($p['gambar_ilustrasi']);

                                if (strpos($gambar_penyakit, 'assets/img/penyakit/') !== false) {
                                    $gambar_penyakit = basename($gambar_penyakit);
                                }

                                $gambar_url = base_url('assets/img/penyakit/' . $gambar_penyakit);
                            ?>
                                <div class="disease-image">
                                    <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($p['nama_penyakit']) ?>" 
                                        style="max-width: 100%; height: auto; display: block;"
                                        onerror="this.onerror=null; this.style.display='none'; console.error('Gambar gagal dimuat: <?= $gambar_url ?>');">
                                </div>
                            <?php endif; ?>
                            <h3><?= $p['nama_penyakit'] ?></h3>
                        </div>
                        <div class="disease-body">
                            <?php if(!empty($p['penyebab'])): ?>
                                <div class="disease-section">
                                    <h4>Penyebab</h4>
                                    <p><?= mb_substr($p['penyebab'], 0, 150) ?><?= mb_strlen($p['penyebab']) > 150 ? '...' : '' ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($p['gejala'])): ?>
                                <div class="disease-section">
                                    <h4>Gejala</h4>
                                    <p><?= mb_substr($p['gejala'], 0, 150) ?><?= mb_strlen($p['gejala']) > 150 ? '...' : '' ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="disease-card-footer">
                            <span class="read-more">Baca Selengkapnya →</span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada data penyakit tersedia.</p>
        <?php endif; ?>
    </div>
</div>
