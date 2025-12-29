<div class="container">
    <div class="page-header">
        <h1 class="page-title">Kalkulator Panen</h1>
        <p class="page-subtitle">Hitung estimasi hasil panen dan keuntungan sawit Anda</p>
    </div>

    <div class="calculator-container">
        <div class="calculator-form">
            <div class="form-header">
                <h2>Input Data</h2>
                <p class="form-description">Isi form di bawah ini untuk menghitung hasil panen dan keuntungan</p>
            </div>
            <form id="harvestForm">
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
                        <span class="label-text">Perusahaan</span>
                        <span class="label-hint">(Opsional)</span>
                    </label>
                    <select name="id_perusahaan" id="id_perusahaan" class="form-control">
                        <option value="">-- Pilih Perusahaan --</option>
                        <?php foreach ($perusahaan as $pt): ?>
                            <option value="<?= $pt->id_perusahaan ?>"><?= htmlspecialchars($pt->nama_perusahaan) ?></option>
                        <?php endforeach; ?>
                    </select>
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
                    <div class="placeholder-icon">📊</div>
                    <div class="placeholder-text">Hasil perhitungan akan muncul di sini setelah Anda mengisi form dan
                        klik tombol "Hitung Hasil"</div>
                </div>
            </div>
            <div class="chart-container" style="display: none;">
                <canvas id="harvestChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>


