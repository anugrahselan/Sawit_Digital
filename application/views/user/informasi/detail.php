<div class="container">
    <article class="article-detail">
        <?php 

        $gambar = null;

        if (isset($article['gambar_header']) && !empty($article['gambar_header'])) {
            $gambar = trim($article['gambar_header']);
        } 

        elseif (isset($article['thumbnail']) && !empty($article['thumbnail'])) {
            $gambar = trim($article['thumbnail']);
        }

        if ($gambar): 

            $gambar = trim($gambar);

            if (strpos($gambar, 'assets/img/articles/') !== false) {

                $gambar = basename($gambar);
            }

            $gambar_url = base_url('assets/img/articles/' . $gambar);
        ?>
            <div class="article-header-image">
                <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($article['judul']) ?>" 
                    style="max-width: 100%; height: auto; display: block;"
                    onerror="this.onerror=null; this.style.display='none';">
            </div>
        <?php else: ?>
        <?php endif; ?>
        <div class="article-detail-content">
            <span class="article-category"><?= $article['kategori'] ?></span>
            <h1 class="article-title"><?= $article['judul'] ?></h1>
            <div class="article-meta">
                <span>Oleh: <?= $article['penulis'] ?></span>
                <span>•</span>
                <span><?= date('d M Y', strtotime($article['tanggal'])) ?></span>
            </div>
            <div class="article-body">
                <?= $article['konten'] ?>
            </div>
        </div>
        <div class="article-actions">
            <a href="<?= site_url('informasi') ?>" class="btn btn-secondary">← Kembali ke Daftar</a>
        </div>
    </article>
</div>
