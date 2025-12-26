<div class="container">
    <h1 class="page-title">Kalkulator Panen</h1>
    <p class="page-subtitle">Hitung estimasi hasil panen dan keuntungan sawit Anda</p>

    <div class="calculator-container">
        <div class="calculator-form">
            <h2>Input Data</h2>
            <form id="harvestForm">
                <div class="form-group">
                    <label for="id_kabupaten">Kabupaten</label>
                    <select name="id_kabupaten" id="id_kabupaten" class="form-control" required>
                        <option value="">Pilih Kabupaten</option>
                        <?php foreach ($kabupaten as $kab): ?>
                            <option value="<?= $kab->id_kabupaten ?>"><?= $kab->nama_kabupaten ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_perusahaan">Perusahaan (Opsional)</label>
                    <select name="id_perusahaan" id="id_perusahaan" class="form-control">
                        <option value="">Pilih Perusahaan</option>
                        <?php foreach ($perusahaan as $pt): ?>
                            <option value="<?= $pt->id_perusahaan ?>"><?= $pt->nama_perusahaan ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga_per_kg">Harga per KG (Rp)</label>
                    <input type="number" name="harga_per_kg" id="harga_per_kg" class="form-control" required min="0"
                        step="0.01" placeholder="Masukkan harga per kilogram">
                </div>
                <div class="form-group">
                    <label for="berat_kotor">Berat Kotor (KG)</label>
                    <input type="number" name="berat_kotor" id="berat_kotor" class="form-control" required min="0" placeholder="Masukkan berat kotor">
                </div>
                <div class="form-group">
                    <label for="potongan">Potongan (%)</label>
                    <input type="number" name="potongan" id="potongan" class="form-control" required min="0" max="100"
                        value="0" placeholder="Masukkan persentase potongan">
                </div>
                <div class="form-group">
                    <label for="upah_panen">Upah Panen (Rp)</label>
                    <input type="number" name="upah_panen" id="upah_panen" class="form-control" required min="0"
                        value="0" placeholder="Masukkan upah panen">
                </div>
                <div class="form-group">
                    <label for="biaya_transportasi">Biaya Transportasi (Rp)</label>
                    <input type="number" name="biaya_transportasi" id="biaya_transportasi" class="form-control" required
                        min="0" value="0" placeholder="Masukkan biaya transportasi">
                </div>
                <div class="form-group">
                    <label for="potong_hutang">Potong Hutang (Rp)</label>
                    <input type="number" name="potong_hutang" id="potong_hutang" class="form-control" required min="0"
                        value="0" placeholder="Masukkan potong hutang">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Hitung Hasil</button>
            </form>
        </div>

        <div class="calculator-result" id="resultContainer" style="display: none;">
            <h2>Hasil Perhitungan</h2>
            <div id="resultContent"></div>
            <div class="chart-container">
                <canvas id="harvestChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>