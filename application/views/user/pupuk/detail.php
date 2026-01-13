<div class="container">
    <article class="fertilizer-detail">
        <?php 

        $gambar = null;
        $gambar_url = null;
        if (isset($pupuk['gambar_pupuk']) && !empty($pupuk['gambar_pupuk'])) {
            $gambar = trim($pupuk['gambar_pupuk']);
            
            if (strpos($gambar, 'assets/img/pupuk/') !== false) {
                $gambar = basename($gambar);
            }
            
            $gambar_url = base_url('assets/img/pupuk/' . $gambar);
        }
        ?>
        
        <div class="fertilizer-detail-content">
            <div class="fertilizer-main-layout">
                <?php if($gambar_url): ?>
                <div class="fertilizer-image-section">
                    <div class="fertilizer-header-image">
                        <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($pupuk['nama_pupuk']) ?>" 
                            onerror="this.onerror=null; this.style.display='none'; console.error('Gambar gagal dimuat: <?= $gambar_url ?>');">
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="fertilizer-info-section">
                    <div class="fertilizer-header-info">
                        <h1 class="fertilizer-title"><?= htmlspecialchars($pupuk['nama_pupuk']) ?></h1>
                        <div class="fertilizer-badge">
                            <span class="badge-icon">🌱</span>
                            <span>Jenis Pupuk Sawit</span>
                        </div>
                    </div>
            
                    <div class="fertilizer-info-grid">
                        <?php if(!empty($pupuk['kandungan'])): ?>
                        <div class="fertilizer-section">
                            <div class="fertilizer-section-header">
                                <h2 class="fertilizer-section-title">Kandungan</h2>
                            </div>
                            <div class="fertilizer-section-content">
                                <p><?= nl2br(htmlspecialchars($pupuk['kandungan'])) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($pupuk['fungsi'])): ?>
                        <div class="fertilizer-section">
                            <div class="fertilizer-section-header">
                                <h2 class="fertilizer-section-title">Fungsi</h2>
                            </div>
                            <div class="fertilizer-section-content">
                                <p><?= nl2br(htmlspecialchars($pupuk['fungsi'])) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($pupuk['waktu_aplikasi'])): ?>
                        <div class="fertilizer-section">
                            <div class="fertilizer-section-header">
                                <h2 class="fertilizer-section-title">Waktu Aplikasi</h2>
                            </div>
                            <div class="fertilizer-section-content">
                                <p><?= nl2br(htmlspecialchars($pupuk['waktu_aplikasi'])) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($pupuk['catatan_khusus'])): ?>
                        <div class="fertilizer-section">
                            <div class="fertilizer-section-header">
                                <h2 class="fertilizer-section-title">Catatan Khusus</h2>
                            </div>
                            <div class="fertilizer-section-content">
                                <p><?= nl2br(htmlspecialchars($pupuk['catatan_khusus'])) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="fertilizer-actions">
            <a href="<?= site_url('pupuk/list') ?>" class="btn btn-secondary">
                <span>←</span> Kembali ke Daftar Pupuk
            </a>
        </div>
    </article>
</div>
