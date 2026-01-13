<div class="container">
    <div class="page-header">
        <h1 class="page-title">Kalkulator Pupuk</h1>
        <p class="page-subtitle">Hitung dosis pupuk yang tepat untuk tanaman sawit Anda</p>
    </div>

    <div class="calculator-container">
        <div class="calculator-form">
            <div class="form-header">
                <h2>Kalkulasi Dosis Pupuk</h2>
                <p class="form-description">Silakan isi data berikut untuk menghitung dosis pupuk sesuai kondisi tanah dan tanaman Anda.<br>
                Sistem akan otomatis menyesuaikan rekomendasi pupuk berdasarkan pH dan kandungan N, P, K tanah.</p>
            </div>
            <form id="fertilizerForm">
                
                <?php if ($this->session->userdata('id_user')): ?>
                <div class="form-group user-info-display">
                    <div class="user-info-value">
                        <strong><?= htmlspecialchars($this->session->userdata('username')) ?></strong>
                        <?php if ($this->session->userdata('nama_lengkap')): ?>
                            <span class="user-name">(<?= htmlspecialchars($this->session->userdata('nama_lengkap')) ?>)</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="id_tanah">
                        <span class="label-text">Pilih Jenis Tanah</span>
                        <span class="label-required">*</span>
                    </label>
                    <select name="id_tanah" id="id_tanah" class="form-control" required>
                        <option value="">-- Pilih Tanah --</option>
                        <?php foreach($tanah as $t): ?>
                            <option value="<?= $t['id_tanah'] ?>" 
                                data-ph-min="<?= $t['ph_min'] ?? '' ?>"
                                data-ph-max="<?= $t['ph_max'] ?? '' ?>"
                                data-kandungan-n="<?= $t['kandungan_n'] ?? '' ?>"
                                data-kandungan-p="<?= $t['kandungan_p'] ?? '' ?>"
                                data-kandungan-k="<?= $t['kandungan_k'] ?? '' ?>"
                                data-rekomendasi="<?= htmlspecialchars($t['rekomendasi'] ?? '') ?>">
                                <?= htmlspecialchars($t['nama_tanah']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="tanah-info" class="tanah-info-box" style="display: none;">
                        <div id="tanah-details"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="id_pupuk">
                        <span class="label-text">Pilih Jenis Pupuk</span>
                        <span class="label-required">*</span>
                    </label>
                    <select name="id_pupuk" id="id_pupuk" class="form-control" required>
                        <option value="">-- Pilih Pupuk --</option>
                        <?php foreach($fertilizers as $fertilizer): ?>
                            <option value="<?= $fertilizer['id_pupuk'] ?>" 
                                data-kandungan="<?= htmlspecialchars($fertilizer['kandungan'] ?? '') ?>"
                                data-fungsi="<?= htmlspecialchars($fertilizer['fungsi'] ?? '') ?>">
                                <?= htmlspecialchars($fertilizer['nama_pupuk']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="pupuk-info" class="pupuk-info-box" style="display: none;">
                        <div id="pupuk-details"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="usia_tanaman">
                        <span class="label-text">Usia Tanaman</span>
                        <span class="label-required">*</span>
                        <span class="label-hint">(bulan)</span>
                    </label>
                    <input type="number" name="usia_tanaman" id="usia_tanaman" class="form-control" required min="0" step="1" placeholder="Contoh: 12">
                </div>
                
                <div class="form-group">
                    <label for="jumlah_pohon">
                        <span class="label-text">Jumlah Pohon</span>
                        <span class="label-required">*</span>
                    </label>
                    <input type="number" name="jumlah_pohon" id="jumlah_pohon" class="form-control" required min="1" step="1" value="1" placeholder="Contoh: 100">
                </div>
                
                <div class="form-group">
                    <label for="periode_per_tahun">
                        <span class="label-text">Periode Pemupukan per Tahun</span>
                        <span class="label-required">*</span>
                    </label>
                    <input type="number" name="periode_per_tahun" id="periode_per_tahun" class="form-control" required min="1" step="1" value="4" placeholder="Contoh: 4">
                </div>
                
                <div class="form-group">
                    <label for="keterangan_aplikasi">
                        <span class="label-text">Keterangan Aplikasi</span>
                        <span class="label-hint">(opsional)</span>
                    </label>
                    <textarea name="keterangan_aplikasi" id="keterangan_aplikasi" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan untuk aplikasi pupuk (opsional)"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    <span class="btn-text">Hitung Dosis</span>
                    <span class="btn-icon">→</span>
                </button>
            </form>
        </div>

        <div class="calculator-result" id="resultContainer">
            <h2>Hasil Perhitungan</h2>
            <div id="resultContent">
                <div class="result-placeholder">
                    <div class="placeholder-text">Hasil perhitungan akan muncul di sini setelah Anda mengisi form dan klik tombol "Hitung Dosis"</div>
                </div>
            </div>
        </div>
    </div>

    <div class="tips-box">
        <h3>Tips Aplikasi Pupuk</h3>
        <ul>
            <li>Aplikasikan pupuk pada pagi atau sore hari untuk menghindari penguapan</li>
            <li>Pastikan tanah dalam kondisi lembab sebelum aplikasi</li>
            <li>Gunakan dosis sesuai rekomendasi untuk hasil optimal</li>
            <li>Lakukan pemupukan secara berkala sesuai jadwal</li>
        </ul>
    </div>
</div>

<script>

    var isLoggedIn = <?= isset($is_logged_in) && $is_logged_in ? 'true' : 'false' ?>;
</script>
