
<footer class="footer">

    <section class="footer-cta">
        <div class="container">
            <div class="footer-cta-content">
                <h2>Siap Meningkatkan Hasil Panen?</h2>
                <p>Dapatkan rekomendasi pemupukan presisi dalam hitungan detik.</p>
                <a href="<?= site_url('kalkulator-pupuk') ?>" class="btn-cta-green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="2" width="16" height="20" rx="2" stroke="currentColor" stroke-width="2"
                            fill="none" />
                        <path d="M8 6H16M8 10H16M8 14H12" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                    <span>Mulai Hitung Sekarang</span>
                </a>

                <div class="footer-brand-section">
                    <div class="footer-logo">
                        <?php
                        $footer_logo = '';

                        $logo_formats = ['logo.png', 'logo.svg', 'logo.jpg', 'logo.jpeg', 'logo.webp'];
                        foreach ($logo_formats as $format) {
                            $logo_path = FCPATH . 'assets/img/logo/' . $format;
                            if (file_exists($logo_path)) {
                                $footer_logo = base_url('assets/img/logo/' . $format);
                                break;
                            }
                        }
                        if ($footer_logo): ?>
                            <img src="<?= $footer_logo ?>" alt="Sawit Digital" class="footer-logo-image">
                        <?php else: ?>
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3V21" stroke="#6ba83a" stroke-width="2" stroke-linecap="round" />
                                <path d="M12 3C12 3 9 5 9 8C9 10 11 12 12 12C13 12 15 10 15 8C15 5 12 3 12 3Z"
                                    fill="#6ba83a" opacity="0.3" />
                                <path d="M10 7C10 7 7 9 7 12C7 13.5 8.5 15 10 15" stroke="#6ba83a" stroke-width="2"
                                    stroke-linecap="round" fill="none" />
                                <path d="M14 7C14 7 17 9 17 12C17 13.5 15.5 15 14 15" stroke="#6ba83a" stroke-width="2"
                                    stroke-linecap="round" fill="none" />
                            </svg>
                        <?php endif; ?>
                        <span class="footer-logo-text">SawitDigital</span>
                    </div>
                    <p class="footer-description">
                        Platform penyuluhan digital terpercaya untuk petani sawit Indonesia. Bersama membangun pertanian
                        yang berkelanjutan dan sejahtera.
                    </p>
                    <div class="footer-social-icons">
                        <a href="<?= site_url('perusahaan/tentang-kami') ?>" class="social-icon-circle" aria-label="Website" title="Website Resmi">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                                <path d="M2 12H22M12 2C15 6 15 18 12 22C9 18 9 6 12 2" stroke="currentColor"
                                    stroke-width="2" />
                            </svg>
                        </a>
                        <a href="javascript:void(0);" class="social-icon-circle" aria-label="Share" title="Bagikan" onclick="sharePage()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="18" cy="5" r="3" stroke="currentColor" stroke-width="2" />
                                <circle cx="6" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                                <circle cx="18" cy="19" r="3" stroke="currentColor" stroke-width="2" />
                                <path d="M8.59 13.51L15.42 17.49M15.41 6.51L8.59 10.49" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </a>
                        <a href="javascript:void(0);" class="social-icon-circle" aria-label="Email" title="Hubungi via Email" onclick="openEmailContact()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor"
                                    stroke-width="2" />
                                <path d="M3 7L12 13L21 7" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="footer-content">
        <div class="container">
            <div class="footer-links">

                <div class="footer-column">
                    <h3>Layanan Kami</h3>
                    <ul>
                        <li><a href="<?= site_url('kalkulator-pupuk') ?>">Kalkulator Pupuk</a></li>
                        <li><a href="<?= site_url('kalkulator-panen') ?>">Kalkulator Panen</a></li>
                        <li><a href="<?= site_url('jenis-pupuk') ?>">Jenis Pupuk</a></li>
                        <li><a href="<?= site_url('penyakit') ?>">Jenis Penyakit</a></li>
                        <li><a href="<?= site_url('informasi') ?>">Artikel</a></li>
                        <li><a href="<?= site_url('beranda') ?>">Info Harga TBS</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Perusahaan</h3>
                    <ul>
                        <li><a href="<?= site_url('perusahaan/tentang-kami') ?>">Tentang Kami</a></li>
                        <li><a href="<?= site_url('perusahaan/visi-misi') ?>">Visi & Misi</a></li>
                        <li><a href="<?= site_url('perusahaan/mitra-kerjasama') ?>">Mitra Kerjasama</a></li>
                        <li><a href="<?= site_url('perusahaan/program') ?>">Program</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Bantuan</h3>
                    <ul>
                        <li><a href="<?= site_url('bantuan/pusat-bantuan') ?>">Pusat Bantuan</a></li>
                        <li><a href="<?= site_url('bantuan/faq') ?>">FAQ</a></li>
                        <li><a href="<?= site_url('bantuan/syarat-ketentuan') ?>">Syarat & Ketentuan</a></li>
                        <li><a href="<?= site_url('bantuan/kebijakan-privasi') ?>">Kebijakan Privasi</a></li>
                        <li><a href="<?= site_url('bantuan/hubungi-kami') ?>">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="footer-copyright-text">
                    &copy; 2024 Sawit Digital Indonesia. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
<script>

    var baseUrl = '<?= base_url() ?>';

    var userId = '<?= $this->session->userdata("id_user") ?: "" ?>';
    var isLoggedIn = <?= $this->session->userdata("id_user") ? "true" : "false" ?>;

    function sharePage() {
        const url = window.location.href;
        const title = document.title;
        const text = 'Lihat informasi menarik di Sawit Digital: ' + title;

        if (navigator.share) {
            navigator.share({
                title: title,
                text: text,
                url: url
            }).catch(err => {
                console.log('Error sharing:', err);
                fallbackShare(url, title);
            });
        } else {

            fallbackShare(url, title);
        }
    }

    function fallbackShare(url, title) {

        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Link berhasil disalin ke clipboard!\n\n' + url);
            }).catch(() => {
                promptShare(url, title);
            });
        } else {
            promptShare(url, title);
        }
    }

    function promptShare(url, title) {
        const shareText = 'Bagikan: ' + title + '\n\n' + url;
        if (prompt('Salin link berikut:', shareText)) {

        }
    }

    function openEmailContact() {
        const email = 'info@sawitdigital.id';
        const subject = encodeURIComponent('Pertanyaan dari ' + document.title);
        const body = encodeURIComponent('Halo,\n\nSaya ingin bertanya tentang:\n\n\n\nTerima kasih.');

        const mailtoLink = 'mailto:' + email + '?subject=' + subject + '&body=' + body;

        try {
            window.location.href = mailtoLink;

            setTimeout(() => {
                const choice = confirm('Tidak ada aplikasi email yang terdeteksi.\n\nPilih cara menghubungi kami:\n\nOK = Buka halaman Hubungi Kami\nCancel = Salin email ke clipboard');

                if (choice) {

                    window.location.href = baseUrl + 'index.php/bantuan/hubungi-kami';
                } else {

                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(email).then(() => {
                            alert('Email berhasil disalin ke clipboard!\n\nEmail: ' + email + '\n\nAnda bisa paste di aplikasi email Anda.');
                        }).catch(() => {
                            prompt('Salin email berikut:', email);
                        });
                    } else {
                        prompt('Salin email berikut:', email);
                    }
                }
            }, 1000);
        } catch (e) {

            window.location.href = baseUrl + 'index.php/bantuan/hubungi-kami';
        }
    }
</script>
<?php if (isset($page_js)): ?>
    <script src="<?= base_url('assets/js/' . $page_js) . '?v=' . time(); ?>" defer></script>
<?php endif; ?>
</body>
</html>