<div class="container">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-error">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <section class="tbs-section">
        <h2 class="section-title">Harga TBS Terkini</h2>
        <div id="tbs-table-container">
            <?php $this->load->view('user/partials/tabel_tbs', ['tbs_prices' => $tbs_prices]); ?>
        </div>
    </section>

    <section class="shortcut-grid">
        <h2 class="section-title">Fitur Utama</h2>
        <div class="grid" id="shortcut-grid">
            <?php
            $icon_pupuk = '<svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="2" fill="none"/><path d="M9 8H15M9 12H15M9 16H12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M7 3V5M17 3V5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M12 2C12 2 10.5 3.5 10.5 5C10.5 6.5 12 8 12 8C12 8 13.5 6.5 13.5 5C13.5 3.5 12 2 12 2Z" fill="currentColor" opacity="0.25"/></svg>';
            $this->load->view('user/partials/kartu_shortcut', ['title' => 'Kalkulator Pupuk', 'description' => 'Hitung dosis pupuk yang tepat', 'icon' => $icon_pupuk, 'link' => site_url('kalkulator-pupuk')]);

            $icon_panen = '<svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M12 3C12 3 9 5 9 8C9 10 11 12 12 12C13 12 15 10 15 8C15 5 12 3 12 3Z" fill="currentColor" opacity="0.25"/><path d="M10 7C10 7 7 9 7 12C7 13.5 8.5 15 10 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/><path d="M14 7C14 7 17 9 17 12C17 13.5 15.5 15 14 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/><circle cx="7.5" cy="11" r="1.5" fill="currentColor" opacity="0.4"/><circle cx="16.5" cy="11" r="1.5" fill="currentColor" opacity="0.4"/></svg>';
            $this->load->view('user/partials/kartu_shortcut', ['title' => 'Kalkulator Panen', 'description' => 'Estimasi hasil panen sawit', 'icon' => $icon_panen, 'link' => site_url('kalkulator-panen')]);

            $icon_jenis = '<svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L4 6.5L12 11L20 6.5L12 2Z" fill="currentColor" opacity="0.2"/><path d="M4 6.5L12 11L20 6.5M4 6.5V17.5L12 22L20 17.5V6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M12 11V22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><rect x="7" y="9" width="10" height="1.5" rx="0.5" fill="currentColor" opacity="0.3"/></svg>';
            $this->load->view('user/partials/kartu_shortcut', ['title' => 'Jenis Pupuk', 'description' => 'Pelajari berbagai jenis pupuk', 'icon' => $icon_jenis, 'link' => site_url('jenis-pupuk')]);

            $icon_penyakit = '<svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L4 5V11C4 16.55 7.16 21.74 12 23C16.84 21.74 20 16.55 20 11V5L12 2Z" fill="currentColor" opacity="0.15" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M12 8V16M8 12H16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>';
            $this->load->view('user/partials/kartu_shortcut', ['title' => 'Jenis Penyakit', 'description' => 'Kenali penyakit pada sawit', 'icon' => $icon_penyakit, 'link' => site_url('penyakit')]);

            $icon_info = '<svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 19.5C4 18.67 4.67 18 5.5 18H18.5C19.33 18 20 18.67 20 19.5C20 20.33 19.33 21 18.5 21H5.5C4.67 21 4 20.33 4 19.5Z" fill="currentColor" opacity="0.2" stroke="currentColor" stroke-width="2"/><path d="M4 4.5C4 3.67 4.67 3 5.5 3H18.5C19.33 3 20 3.67 20 4.5C20 5.33 19.33 6 18.5 6H5.5C4.67 6 4 5.33 4 4.5Z" fill="currentColor" opacity="0.2" stroke="currentColor" stroke-width="2"/><path d="M4 12C4 11.17 4.67 10.5 5.5 10.5H18.5C19.33 10.5 20 11.17 20 12C20 12.83 19.33 13.5 18.5 13.5H5.5C4.67 13.5 4 12.83 4 12Z" fill="currentColor" opacity="0.2" stroke="currentColor" stroke-width="2"/><path d="M6 7V17M18 7V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.3"/></svg>';
            ?>
            <div class="hidden-card" style="display: none;">
                <?php $this->load->view('user/partials/kartu_shortcut', ['title' => 'Informasi', 'description' => 'Artikel edukasi terbaru', 'icon' => $icon_info, 'link' => site_url('informasi')]); ?>
            </div>
        </div>
        <div class="show-more-container">
            <button class="btn-show-more" id="btnShowMore">
                <span class="btn-text">Lihat Lainnya</span>
                <span class="btn-icon">▼</span>
            </button>
        </div>
    </section>

    <section class="articles-section">
        <h2 class="section-title">Artikel Edukasi Terbaru</h2>
        <div class="articles-grid" id="articles-grid-beranda">
            <?php if (!empty($articles)): ?>
                <?php
                $article_count = 0;
                foreach ($articles as $article):
                    $article_count++;
                    if ($article_count > 3):
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

        <?php if (!empty($articles) && count($articles) > 3): ?>
            <div class="show-more-container">
                <button class="btn-show-more" id="btnShowMoreArticlesBeranda">
                    <span class="btn-text">Lihat Lainnya</span>
                    <span class="btn-icon">▼</span>
                </button>
            </div>
        <?php endif; ?>
    </section>
</div>