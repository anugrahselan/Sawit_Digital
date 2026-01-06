<div class="container">
    <h1 class="page-title">Informasi & Edukasi</h1>
    <p class="page-subtitle">Artikel edukasi terbaru tentang budidaya sawit</p>

    <div class="articles-grid" id="articles-grid">
        <?php if(!empty($articles)): ?>
            <?php foreach($articles as $article): ?>
                <?php $this->load->view('user/partials/kartu_artikel', ['article' => $article]); ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada artikel tersedia.</p>
        <?php endif; ?>
    </div>
</div>

