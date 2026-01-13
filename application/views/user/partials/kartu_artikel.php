<div class="article-card">
    <?php
    $gambar = null;
    if (isset($article['thumbnail']) && !empty($article['thumbnail'])) {
        $gambar = trim($article['thumbnail']);
    } elseif (isset($article['gambar_header']) && !empty($article['gambar_header'])) {
        $gambar = trim($article['gambar_header']);
    }

    if ($gambar):
        $gambar = trim($gambar);
        if (strpos($gambar, 'assets/img/articles/') !== false) {
            $gambar = basename($gambar);
        }
        ?>
        <div class="article-image">
            <img src="<?= base_url('assets/img/articles/' . $gambar) ?>" alt="<?= htmlspecialchars($article['judul']) ?>" onerror="this.style.display='none';">
        </div>
    <?php endif; ?>
    <div class="article-content">
        <span class="article-category"><?= $article['kategori'] ?></span>
        <h3 class="article-title">
            <a href="<?= site_url('informasi/detail/' . $article['id_info']) ?>"><?= $article['judul'] ?></a>
        </h3>
        <p class="article-meta">
            <span>Oleh: <?= $article['penulis'] ?></span>
            <span>•</span>
            <span><?= date('d M Y', strtotime($article['tanggal'])) ?></span>
        </p>
        <p class="article-excerpt"><?= character_limiter(strip_tags($article['konten']), 150) ?></p>
        <a href="<?= site_url('informasi/detail/' . $article['id_info']) ?>" class="article-link">Baca Selengkapnya →</a>
    </div>
</div>