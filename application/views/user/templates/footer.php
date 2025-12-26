<!-- Footer -->
<footer class="footer">
    <!-- CTA Section (Dark Gray) -->
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

                <!-- Brand Section Below Button -->
                <div class="footer-brand-section">
                    <div class="footer-logo">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 3V21" stroke="#6ba83a" stroke-width="2" stroke-linecap="round" />
                            <path d="M12 3C12 3 9 5 9 8C9 10 11 12 12 12C13 12 15 10 15 8C15 5 12 3 12 3Z"
                                fill="#6ba83a" opacity="0.3" />
                            <path d="M10 7C10 7 7 9 7 12C7 13.5 8.5 15 10 15" stroke="#6ba83a" stroke-width="2"
                                stroke-linecap="round" fill="none" />
                            <path d="M14 7C14 7 17 9 17 12C17 13.5 15.5 15 14 15" stroke="#6ba83a" stroke-width="2"
                                stroke-linecap="round" fill="none" />
                        </svg>
                        <span class="footer-logo-text">SawitDigital</span>
                    </div>
                    <p class="footer-description">
                        Platform penyuluhan digital terpercaya untuk petani sawit Indonesia. Bersama membangun pertanian
                        yang berkelanjutan dan sejahtera.
                    </p>
                    <div class="footer-social-icons">
                        <a href="#" class="social-icon-circle" aria-label="Website">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                                <path d="M2 12H22M12 2C15 6 15 18 12 22C9 18 9 6 12 2" stroke="currentColor"
                                    stroke-width="2" />
                            </svg>
                        </a>
                        <a href="#" class="social-icon-circle" aria-label="Share">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="18" cy="5" r="3" stroke="currentColor" stroke-width="2" />
                                <circle cx="6" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                                <circle cx="18" cy="19" r="3" stroke="currentColor" stroke-width="2" />
                                <path d="M8.59 13.51L15.42 17.49M15.41 6.51L8.59 10.49" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </a>
                        <a href="#" class="social-icon-circle" aria-label="Email">
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

    <!-- Footer Content (Dark Gray) -->
    <div class="footer-content">
        <div class="container">
            <div class="footer-links">
                <!-- Column 1: Layanan Kami -->
                <div class="footer-column">
                    <h3>Layanan Kami</h3>
                    <ul>
                        <li><a href="<?= site_url('kalkulator-pupuk') ?>">Kalkulator Pupuk</a></li>
                        <li><a href="<?= site_url('kalkulator-panen') ?>">Kalkulator Panen</a></li>
                        <li><a href="<?= site_url('penyakit') ?>">Identifikasi Penyakit</a></li>
                        <li><a href="<?= site_url('beranda') ?>">Info Harga TBS</a></li>
                    </ul>
                </div>

                <!-- Column 2: Perusahaan -->
                <div class="footer-column">
                    <h3>Perusahaan</h3>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Mitra Kerjasama</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Berita Terkini</a></li>
                    </ul>
                </div>

                <!-- Column 3: Bantuan -->
                <div class="footer-column">
                    <h3>Bantuan</h3>
                    <ul>
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer Bar (Dark Gray) -->
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
    // Set base URL untuk JavaScript
    var baseUrl = '<?= base_url() ?>';
    
    // Pastikan tombol Daftar Gratis di hero banner bisa diklik
    document.addEventListener('DOMContentLoaded', function() {
        var heroBtn = document.querySelector('.hero-register-btn');
        if (heroBtn) {
            // Hapus semua event listener yang mungkin menghalangi
            heroBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                var href = this.getAttribute('href');
                if (href) {
                    // Pastikan navigasi berjalan
                    window.location.href = href;
                    return false;
                }
            }, true); // Use capture phase
            
            // Juga pastikan mousedown dan mouseup tidak dihalangi
            heroBtn.addEventListener('mousedown', function(e) {
                e.stopPropagation();
            }, true);
            
            heroBtn.addEventListener('mouseup', function(e) {
                e.stopPropagation();
            }, true);
        }
    });
</script>
<?php if (isset($page_js)): ?>
    <script src="<?= base_url('assets/js/' . $page_js); ?>" defer></script>
<?php endif; ?>
</body>
</html>