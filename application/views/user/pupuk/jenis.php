<div class="container">
    <h1 class="page-title">Jenis Pupuk</h1>
    <p class="page-subtitle">Pelajari berbagai jenis pupuk untuk tanaman sawit</p>

    <div class="fertilizer-grid">
        <?php if(!empty($fertilizers)): ?>
            <?php foreach($fertilizers as $fertilizer): ?>
                <div class="fertilizer-card">
                    <div class="fertilizer-header">
                        <?php if(!empty($fertilizer->gambar_pupuk)): 
                            // Bersihkan path dari prefix yang mungkin ada
                            $gambar_pupuk = trim($fertilizer->gambar_pupuk);
                            
                            // Jika path sudah lengkap (sudah ada assets/img/pupuk/), ambil hanya nama file
                            if (strpos($gambar_pupuk, 'assets/img/pupuk/') !== false) {
                                $gambar_pupuk = basename($gambar_pupuk);
                            }
                            
                            // Buat URL lengkap
                            $gambar_url = base_url('assets/img/pupuk/' . $gambar_pupuk);
                        ?>
                            <div class="fertilizer-image">
                                <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($fertilizer->nama_pupuk) ?>" 
                                    style="max-width: 100%; height: auto; display: block;"
                                    onerror="this.onerror=null; this.style.display='none'; console.error('Gambar gagal dimuat: <?= $gambar_url ?>');">
                            </div>
                        <?php endif; ?>
                        <h3><?= $fertilizer->nama_pupuk ?></h3>
                    </div>
                    <div class="fertilizer-body">
                        <?php if(!empty($fertilizer->kandungan)): ?>
                            <div class="fertilizer-section">
                                <h4>Kandungan</h4>
                                <p><?= $fertilizer->kandungan ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($fertilizer->fungsi)): ?>
                            <div class="fertilizer-section">
                                <h4>Fungsi</h4>
                                <p><?= $fertilizer->fungsi ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($fertilizer->waktu_aplikasi)): ?>
                            <div class="fertilizer-section">
                                <h4>Waktu Aplikasi</h4>
                                <p><?= $fertilizer->waktu_aplikasi ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($fertilizer->catatan_khusus)): ?>
                            <div class="fertilizer-section">
                                <h4>Catatan Khusus</h4>
                                <p><?= $fertilizer->catatan_khusus ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada data pupuk tersedia.</p>
        <?php endif; ?>
    </div>
</div>

