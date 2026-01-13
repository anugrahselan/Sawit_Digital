<div class="container">
    <div class="page-header">
        <h1 class="page-title">Kalkulator Panen</h1>
        <p class="page-subtitle">Hitung estimasi hasil panen dan keuntungan sawit Anda</p>
    </div>

    <div class="calculator-container">
        <div class="calculator-form">
            <div class="form-header">
                <h2>Kalkulasi Hasil Panen</h2>
                <p class="form-description">Silakan isi data berikut untuk menghitung hasil panen dan keuntungan sawit Anda.<br>
                Sistem akan menghitung pendapatan kotor, total biaya, dan hasil bersih berdasarkan data yang Anda masukkan.</p>
            </div>
            <form id="harvestForm">
                
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
                    <label for="id_kabupaten">
                        <span class="label-text">Kabupaten</span>
                        <span class="label-required">*</span>
                    </label>
                    <select name="id_kabupaten" id="id_kabupaten" class="form-control" required>
                        <option value="">-- Pilih Kabupaten --</option>
                        <?php foreach ($kabupaten as $kab): ?>
                            <option value="<?= $kab->id_kabupaten ?>"><?= htmlspecialchars($kab->nama_kabupaten) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_perusahaan">
                        <span class="label-text">Perusahaan / Mitra</span>
                        <span class="label-hint">(Pilih PT untuk auto-fill harga, atau Mitra untuk input manual)</span>
                    </label>
                    <select name="id_perusahaan" id="id_perusahaan" class="form-control">
                        <option value="">-- Pilih Kabupaten terlebih dahulu --</option>
                    </select>
                    <small class="form-text text-muted" id="harga-info" style="display: none;"></small>
                </div>
                <div class="form-group">
                    <label for="harga_per_kg">
                        <span class="label-text">Harga per KG</span>
                        <span class="label-required">*</span>
                        <span class="label-hint">(Rp)</span>
                    </label>
                    <input type="number" name="harga_per_kg" id="harga_per_kg" class="form-control" required min="0"
                        step="0.01" placeholder="Contoh: 3400">
                </div>
                <div class="form-group">
                    <label for="berat_kotor">
                        <span class="label-text">Berat Kotor</span>
                        <span class="label-required">*</span>
                        <span class="label-hint">(KG)</span>
                    </label>
                    <input type="number" name="berat_kotor" id="berat_kotor" class="form-control" required min="0"
                        step="0.01" placeholder="Contoh: 1000">
                </div>
                <div class="form-group">
                    <label for="potongan">
                        <span class="label-text">Potongan</span>
                        <span class="label-required">*</span>
                        <span class="label-hint">(%)</span>
                    </label>
                    <input type="number" name="potongan" id="potongan" class="form-control" required min="0" max="100"
                        value="0" step="0.01" placeholder="Contoh: 5">
                </div>
                <div class="form-group">
                    <label for="upah_panen">
                        <span class="label-text">Upah Panen</span>
                        <span class="label-required">*</span>
                        <span class="label-hint">(Rp)</span>
                    </label>
                    <input type="number" name="upah_panen" id="upah_panen" class="form-control" required min="0"
                        value="0" step="0.01" placeholder="Contoh: 50000">
                </div>
                <div class="form-group">
                    <label for="biaya_transportasi">
                        <span class="label-text">Biaya Transportasi</span>
                        <span class="label-required">*</span>
                        <span class="label-hint">(Rp)</span>
                    </label>
                    <input type="number" name="biaya_transportasi" id="biaya_transportasi" class="form-control" required
                        min="0" value="0" step="0.01" placeholder="Contoh: 20000">
                </div>
                <div class="form-group">
                    <label for="potong_hutang">
                        <span class="label-text">Potong Hutang</span>
                        <span class="label-required">*</span>
                        <span class="label-hint">(Rp)</span>
                    </label>
                    <input type="number" name="potong_hutang" id="potong_hutang" class="form-control" required min="0"
                        value="0" step="0.01" placeholder="Contoh: 0">
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <span class="btn-text">Hitung Hasil</span>
                    <span class="btn-icon">→</span>
                </button>
            </form>
        </div>

        <div class="calculator-result" id="resultContainer">
            <h2>Hasil Perhitungan</h2>
            <div id="resultContent">
                <div class="result-placeholder">
                    <div class="placeholder-text">Hasil perhitungan akan muncul di sini setelah Anda mengisi form dan klik tombol "Hitung Hasil"</div>
                </div>
            </div>
        </div>
    </div>

    <div class="tips-box">
        <h3>Tips Panen Sawit</h3>
        <ul>
            <li>Lakukan panen pada waktu yang tepat untuk mendapatkan kualitas TBS terbaik</li>
            <li>Pastikan TBS yang dipanen sudah matang dengan ciri-ciri buah mudah lepas dari tandan</li>
            <li>Hindari panen saat hujan untuk menjaga kualitas TBS</li>
            <li>Segera angkut TBS ke pabrik setelah panen untuk menghindari penurunan kualitas</li>
        </ul>
    </div>
</div>

<script>

    var isLoggedIn = <?= isset($is_logged_in) && $is_logged_in ? 'true' : 'false' ?>;
</script>
