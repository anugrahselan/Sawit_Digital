<div class="container">
    <h1 class="page-title">Penyakit Sawit</h1>
    <p class="page-subtitle">Kenali berbagai penyakit yang dapat menyerang tanaman sawit</p>

    <div class="disease-grid">
        <?php if(!empty($penyakit)): ?>
            <?php foreach($penyakit as $p): ?>
                <div class="disease-card">
                    <div class="disease-header">
                        <?php if(!empty($p->gambar_ilustrasi)): 
                            // Bersihkan path dari prefix yang mungkin ada
                            $gambar_penyakit = trim($p->gambar_ilustrasi);
                            
                            // Jika path sudah lengkap (sudah ada assets/img/penyakit/), ambil hanya nama file
                            if (strpos($gambar_penyakit, 'assets/img/penyakit/') !== false) {
                                $gambar_penyakit = basename($gambar_penyakit);
                            }
                            
                            // Buat URL lengkap
                            $gambar_url = base_url('assets/img/penyakit/' . $gambar_penyakit);
                        ?>
                            <div class="disease-image">
                                <img src="<?= $gambar_url ?>" alt="<?= htmlspecialchars($p->nama_penyakit) ?>" 
                                    style="max-width: 100%; height: auto; display: block;"
                                    onerror="this.onerror=null; this.style.display='none'; console.error('Gambar gagal dimuat: <?= $gambar_url ?>');">
                            </div>
                        <?php endif; ?>
                        <h3><?= $p->nama_penyakit ?></h3>
                    </div>
                    <div class="disease-body">
                        <?php if(!empty($p->penyebab)): ?>
                            <div class="disease-section">
                                <h4>Penyebab</h4>
                                <p><?= $p->penyebab ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($p->gejala)): ?>
                            <div class="disease-section">
                                <h4>Gejala</h4>
                                <p><?= $p->gejala ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($p->cara_pengendalian)): ?>
                            <div class="disease-section">
                                <h4>Cara Pengendalian</h4>
                                <p><?= $p->cara_pengendalian ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada data penyakit tersedia.</p>
        <?php endif; ?>
    </div>
</div>

