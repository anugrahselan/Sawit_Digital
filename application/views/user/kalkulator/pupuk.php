<div class="container">
    <div class="page-header">
        <h1 class="page-title">Kalkulator Pupuk</h1>
        <p class="page-subtitle">Hitung dosis pupuk yang tepat untuk tanaman sawit Anda</p>
    </div>

    <div class="calculator-container">
        <div class="calculator-form">
            <div class="form-header">
                <h2>Input Data</h2>
                <p class="form-description">Isi form di bawah ini untuk menghitung dosis pupuk yang tepat</p>
            </div>
            <form id="fertilizerForm">
                <div class="form-group">
                    <label for="id_pupuk">
                        <span class="label-text">Jenis Pupuk</span>
                        <span class="label-required">*</span>
                    </label>
                    <select name="id_pupuk" id="id_pupuk" class="form-control" required>
                        <option value="">-- Pilih Pupuk --</option>
                        <?php foreach($fertilizers as $fertilizer): ?>
                            <option value="<?= $fertilizer->id_pupuk ?>"><?= htmlspecialchars($fertilizer->nama_pupuk) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_tanah">
                        <span class="label-text">Jenis Tanah</span>
                        <span class="label-required">*</span>
                    </label>
                    <select name="id_tanah" id="id_tanah" class="form-control" required>
                        <option value="">-- Pilih Tanah --</option>
                        <?php foreach($tanah as $t): ?>
                            <option value="<?= $t->id_tanah ?>"><?= htmlspecialchars($t->nama_tanah) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="usia_tanaman">
                        <span class="label-text">Usia Tanaman</span>
                        <span class="label-required">*</span>
                        <span class="label-hint">(dalam bulan)</span>
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
                    <div class="placeholder-icon">📊</div>
                    <div class="placeholder-text">Hasil perhitungan akan muncul di sini setelah Anda mengisi form dan klik tombol "Hitung Dosis"</div>
                </div>
            </div>
        </div>
    </div>

    <div class="tips-box">
        <h3>💡 Tips Aplikasi Pupuk</h3>
        <ul>
            <li>Aplikasikan pupuk pada pagi atau sore hari untuk menghindari penguapan</li>
            <li>Pastikan tanah dalam kondisi lembab sebelum aplikasi</li>
            <li>Gunakan dosis sesuai rekomendasi untuk hasil optimal</li>
            <li>Lakukan pemupukan secara berkala sesuai jadwal</li>
        </ul>
    </div>
</div>
