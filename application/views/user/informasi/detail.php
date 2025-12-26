<div class="container">
    <article class="article-detail">
        <?php 
        // Debug: uncomment untuk melihat data
        // echo '<pre>'; var_dump($article); echo '</pre>';
        
        // Cek dan ambil gambar - prioritas: gambar_header, lalu thumbnail
        $gambar = null;
        
        // Cek gambar_header dulu
        if (property_exists($article, 'gambar_header') && !empty($article->gambar_header)) {
            $gambar = trim($article->gambar_header);
        } 
        // Jika gambar_header kosong, cek thumbnail
        elseif (property_exists($article, 'thumbnail') && !empty($article->thumbnail)) {
            $gambar = trim($article->thumbnail);
        }
        
        if ($gambar): 
            // Bersihkan path dari prefix yang mungkin ada
            $gambar = trim($gambar);
            
            // Jika path sudah lengkap (sudah ada assets/img/articles/), ambil hanya nama file
            if (strpos($gambar, 'assets/img/articles/') !== false) {
                // Ambil hanya nama file setelah assets/img/articles/
                $gambar = basename($gambar);
            }
            
            // Buat URL lengkap
            $gambar_url = base_url('assets/img/articles/' . $gambar);
        ?>
            <div class="article-header-image">
                <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($article->judul) ?>" 
                    style="max-width: 100%; height: auto; display: block;"
                    onerror="this.onerror=null; this.style.display='none'; console.error('Gambar gagal dimuat: <?= $gambar_url ?>');">
            </div>
            <!-- Debug: Path DB: <?= property_exists($article, 'gambar_header') ? $article->gambar_header : '' ?>, File: <?= $gambar ?>, URL: <?= $gambar_url ?> -->
        <?php else: ?>
            <!-- Debug: Gambar tidak ditemukan. Thumbnail: <?= property_exists($article, 'thumbnail') ? ($article->thumbnail ?: 'KOSONG') : 'TIDAK ADA' ?>, Gambar Header: <?= property_exists($article, 'gambar_header') ? ($article->gambar_header ?: 'KOSONG') : 'TIDAK ADA' ?> -->
        <?php endif; ?>
        <div class="article-detail-content">
            <span class="article-category"><?= $article->kategori ?></span>
            <h1 class="article-title"><?= $article->judul ?></h1>
            <div class="article-meta">
                <span>Oleh: <?= $article->penulis ?></span>
                <span>•</span>
                <span><?= date('d M Y', strtotime($article->tanggal)) ?></span>
            </div>
            <div class="article-body">
                <?= $article->konten ?>
            </div>
        </div>
        <div class="article-actions">
            <a href="<?= site_url('informasi') ?>" class="btn btn-secondary">← Kembali ke Daftar</a>
        </div>
    </article>
</div>

