<div class="container">
    <h1 class="page-title">Kalkulator Pupuk</h1>
    <p class="page-subtitle">Hitung dosis pupuk yang tepat untuk tanaman sawit Anda</p>

    <div class="calculator-container">
        <div class="calculator-form">
            <h2>Input Data</h2>
            <form id="fertilizerForm">
                <div class="form-group">
                    <label for="id_pupuk">Jenis Pupuk</label>
                    <select name="id_pupuk" id="id_pupuk" class="form-control" required>
                        <option value="">Pilih Pupuk</option>
                        <?php foreach($fertilizers as $fertilizer): ?>
                            <option value="<?= $fertilizer->id_pupuk ?>"><?= $fertilizer->nama_pupuk ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_tanah">Jenis Tanah</label>
                    <select name="id_tanah" id="id_tanah" class="form-control" required>
                        <option value="">Pilih Tanah</option>
                        <?php foreach($tanah as $t): ?>
                            <option value="<?= $t->id_tanah ?>"><?= $t->nama_tanah ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="usia_tanaman">Usia Tanaman (bulan)</label>
                    <input type="number" name="usia_tanaman" id="usia_tanaman" class="form-control" required min="0" placeholder="Masukkan usia tanaman dalam bulan">
                </div>
                <div class="form-group">
                    <label for="jumlah_pohon">Jumlah Pohon</label>
                    <input type="number" name="jumlah_pohon" id="jumlah_pohon" class="form-control" required min="1" value="1" placeholder="Masukkan jumlah pohon">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Hitung Dosis</button>
            </form>
        </div>

        <div class="calculator-result" id="resultContainer" style="display: none;">
            <h2>Hasil Perhitungan</h2>
            <div id="resultContent"></div>
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

