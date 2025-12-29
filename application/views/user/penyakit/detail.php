<div class="container">
    <article class="disease-detail">
        <?php 
        // Cek dan ambil gambar
        $gambar = null;
        if (property_exists($penyakit, 'gambar_ilustrasi') && !empty($penyakit->gambar_ilustrasi)) {
            $gambar = trim($penyakit->gambar_ilustrasi);
            
            // Jika path sudah lengkap (sudah ada assets/img/penyakit/), ambil hanya nama file
            if (strpos($gambar, 'assets/img/penyakit/') !== false) {
                $gambar = basename($gambar);
            }
            
            // Buat URL lengkap
            $gambar_url = base_url('assets/img/penyakit/' . $gambar);
            
            // Tampilkan gambar
            echo '<div class="disease-header-image">';
            echo '<img src="' . $gambar_url . '" alt="' . htmlspecialchars($penyakit->nama_penyakit) . '" ';
            echo 'style="max-width: 100%; height: auto; display: block;" ';
            echo 'onerror="this.onerror=null; this.style.display=\'none\'; console.error(\'Gambar gagal dimuat: ' . $gambar_url . '\');">';
            echo '</div>';
        }
        ?>
        
        <div class="disease-detail-content">
            <h1 class="disease-title"><?= htmlspecialchars($penyakit->nama_penyakit) ?></h1>
            
            <?php if(!empty($penyakit->penyebab)): ?>
                <div class="disease-section">
                    <h2 class="disease-section-title">Penyebab</h2>
                    <div class="disease-section-content">
                        <p><?= nl2br(htmlspecialchars($penyakit->penyebab)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($penyakit->gejala)): ?>
                <div class="disease-section">
                    <h2 class="disease-section-title">Gejala</h2>
                    <div class="disease-section-content">
                        <p><?= nl2br(htmlspecialchars($penyakit->gejala)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($penyakit->cara_pengendalian)): ?>
                <div class="disease-section">
                    <h2 class="disease-section-title">Cara Pengendalian</h2>
                    <div class="disease-section-content">
                        <p><?= nl2br(htmlspecialchars($penyakit->cara_pengendalian)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="disease-actions">
            <a href="<?= site_url('penyakit') ?>" class="btn btn-secondary">← Kembali ke Daftar</a>
        </div>
    </article>
</div>

