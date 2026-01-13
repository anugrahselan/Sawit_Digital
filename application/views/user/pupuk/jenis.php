<div class="container">
    <h1 class="page-title">Jenis Pupuk</h1>
    <p class="page-subtitle">Pelajari berbagai jenis pupuk untuk tanaman sawit</p>

    <div class="fertilizer-grid">
        <?php if(!empty($fertilizers)): ?>
            <?php foreach($fertilizers as $fertilizer): ?>
                <div class="fertilizer-card">
                    <a href="<?= site_url('pupuk/detail/' . $fertilizer['id_pupuk']) ?>" class="fertilizer-card-link">
                        <div class="fertilizer-header">
                            <?php if(!empty($fertilizer['gambar_pupuk'])): 

                                $gambar_pupuk = trim($fertilizer['gambar_pupuk']);

                                if (strpos($gambar_pupuk, 'assets/img/pupuk/') !== false) {
                                    $gambar_pupuk = basename($gambar_pupuk);
                                }

                                $gambar_url = base_url('assets/img/pupuk/' . $gambar_pupuk);
                            ?>
                                <div class="fertilizer-image">
                                    <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($fertilizer['nama_pupuk']) ?>" 
                                        onerror="this.onerror=null; this.style.display='none'; console.error('Gambar gagal dimuat: <?= $gambar_url ?>');">
                                </div>
                            <?php endif; ?>
                            <h3><?= $fertilizer['nama_pupuk'] ?></h3>
                        </div>
                        <div class="fertilizer-body">
                            <?php if(!empty($fertilizer['kandungan'])): ?>
                                <div class="fertilizer-section">
                                    <h4>Kandungan</h4>
                                    <p><?= mb_substr($fertilizer['kandungan'], 0, 150) ?><?= mb_strlen($fertilizer['kandungan']) > 150 ? '...' : '' ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($fertilizer['fungsi'])): ?>
                                <div class="fertilizer-section">
                                    <h4>Fungsi</h4>
                                    <p><?= mb_substr($fertilizer['fungsi'], 0, 150) ?><?= mb_strlen($fertilizer['fungsi']) > 150 ? '...' : '' ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="fertilizer-card-footer">
                            <span class="read-more">Baca Selengkapnya →</span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada data pupuk tersedia.</p>
        <?php endif; ?>
    </div>
</div>
