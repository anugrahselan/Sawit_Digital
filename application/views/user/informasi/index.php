<div class="container">
    <h1 class="page-title">Informasi & Edukasi</h1>
    <p class="page-subtitle">Artikel edukasi terbaru tentang budidaya sawit</p>

    <div class="articles-grid" id="articles-grid">
        <?php if(!empty($articles)): ?>
            <?php 
            $article_count = 0;
            foreach($articles as $article): 
                $article_count++;
                if($article_count > 3):
            ?>
                <div class="hidden-article" style="display: none;">
                    <?php $this->load->view('user/partials/kartu_artikel', ['article' => $article]); ?>
                </div>
            <?php else: ?>
                <?php $this->load->view('user/partials/kartu_artikel', ['article' => $article]); ?>
            <?php 
                endif;
            endforeach; 
            ?>
        <?php else: ?>
            <p>Tidak ada artikel tersedia.</p>
        <?php endif; ?>
    </div>

    <?php if(!empty($articles) && count($articles) > 3): ?>
        <div class="show-more-container">
            <button class="btn-show-more" id="btnShowMoreArticles">
                <span class="btn-text">Lihat Lainnya</span>
                <span class="btn-icon">▼</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(isset($pagination_links)): ?>
        <div class="pagination">
            <?= $pagination_links ?>
        </div>
    <?php endif; ?>
</div>

