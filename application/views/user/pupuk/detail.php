<div class="container">
    <article class="fertilizer-detail">
        <?php 
        // Cek dan ambil gambar
        $gambar = null;
        if (property_exists($pupuk, 'gambar_pupuk') && !empty($pupuk->gambar_pupuk)) {
            $gambar = trim($pupuk->gambar_pupuk);
            
            // Jika path sudah lengkap (sudah ada assets/img/pupuk/), ambil hanya nama file
            if (strpos($gambar, 'assets/img/pupuk/') !== false) {
                $gambar = basename($gambar);
            }
            
            // Buat URL lengkap
            $gambar_url = base_url('assets/img/pupuk/' . $gambar);
            
            // Tampilkan gambar
            echo '<div class="fertilizer-header-image">';
            echo '<img src="' . $gambar_url . '" alt="' . htmlspecialchars($pupuk->nama_pupuk) . '" ';
            echo 'style="max-width: 100%; height: auto; display: block;" ';
            echo 'onerror="this.onerror=null; this.style.display=\'none\'; console.error(\'Gambar gagal dimuat: ' . $gambar_url . '\');">';
            echo '</div>';
        }
        ?>
        
        <div class="fertilizer-detail-content">
            <h1 class="fertilizer-title"><?= htmlspecialchars($pupuk->nama_pupuk) ?></h1>
            
            <?php if(!empty($pupuk->kandungan)): ?>
                <div class="fertilizer-section">
                    <h2 class="fertilizer-section-title">Kandungan</h2>
                    <div class="fertilizer-section-content">
                        <p><?= nl2br(htmlspecialchars($pupuk->kandungan)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($pupuk->fungsi)): ?>
                <div class="fertilizer-section">
                    <h2 class="fertilizer-section-title">Fungsi</h2>
                    <div class="fertilizer-section-content">
                        <p><?= nl2br(htmlspecialchars($pupuk->fungsi)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($pupuk->waktu_aplikasi)): ?>
                <div class="fertilizer-section">
                    <h2 class="fertilizer-section-title">Waktu Aplikasi</h2>
                    <div class="fertilizer-section-content">
                        <p><?= nl2br(htmlspecialchars($pupuk->waktu_aplikasi)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($pupuk->catatan_khusus)): ?>
                <div class="fertilizer-section">
                    <h2 class="fertilizer-section-title">Catatan Khusus</h2>
                    <div class="fertilizer-section-content">
                        <p><?= nl2br(htmlspecialchars($pupuk->catatan_khusus)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="fertilizer-actions">
            <a href="<?= site_url('pupuk/list') ?>" class="btn btn-secondary">← Kembali ke Daftar</a>
        </div>
    </article>
</div>

