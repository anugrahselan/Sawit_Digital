<div class="container">
    <div class="page-header">
        <h1 class="page-title">Riwayat Kalkulasi</h1>
        <p class="page-subtitle">Lihat dan kelola semua kalkulasi yang telah Anda simpan</p>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="riwayat-tabs">
        <button class="tab-btn active" data-tab="panen">Kalkulasi Panen</button>
        <button class="tab-btn" data-tab="pupuk">Kalkulasi Pupuk</button>
    </div>

    <div class="tab-content active" id="tab-panen">
        <div class="riwayat-section">
            <h2 class="section-title">Riwayat Kalkulasi Panen</h2>

            <?php if (!empty($kalkulasi_panen)): ?>
                
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" id="searchInputPanen" class="form-control" placeholder="Cari tanggal, kabupaten, perusahaan, harga, berat, atau hasil bersih...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success w-100" type="button" id="searchBtnPanen">
                                <i class="fa fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
                <div class="riwayat-table-wrapper">
                    <table class="riwayat-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">
                                <th>Tanggal</th>
                                <th>Kabupaten</th>
                                <th>Perusahaan</th>
                                <th>Harga/KG</th>
                                <th>Berat Kotor</th>
                                <th>Hasil Bersih</th>
                                <th style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kalkulasi_panen as $index => $kp): ?>
                                <?php

                                $berat_bersih = $kp->berat_kotor - ($kp->berat_kotor * $kp->potongan / 100);
                                $pendapatan_kotor = $berat_bersih * $kp->harga_per_kg;
                                $total_biaya = $kp->upah_panen + $kp->biaya_transportasi + $kp->potong_hutang;
                                $hasil_bersih = $pendapatan_kotor - $total_biaya;
                                ?>
                                <tr class="riwayat-row" data-id="<?= $kp->id_kalkulasi ?>">
                                    <td>
                                        <button class="expand-btn" data-target="detail-panen-<?= $kp->id_kalkulasi ?>">
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($kp->tanggal_kalkulasi) && !empty($kp->tanggal_kalkulasi)) {
                                            echo date('d M Y, H:i', strtotime($kp->tanggal_kalkulasi));
                                        } else {
                                            echo 'Tanggal tidak tersedia';
                                        }
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($kp->nama_kabupaten ?: '-') ?></td>
                                    <td><?= htmlspecialchars($kp->nama_perusahaan ?: 'Mitra') ?></td>
                                    <td>Rp <?= number_format($kp->harga_per_kg, 0, ',', '.') ?></td>
                                    <td><?= number_format($kp->berat_kotor, 2, ',', '.') ?> kg</td>
                                    <td><strong class="text-success">Rp
                                            <?= number_format($hasil_bersih, 0, ',', '.') ?></strong></td>
                                    <td>
                                        <a href="<?= site_url('riwayat/hapus_panen/' . $kp->id_kalkulasi) ?>"
                                            class="btn-delete-table"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kalkulasi ini?')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="detail-row" id="detail-panen-<?= $kp->id_kalkulasi ?>">
                                    <td colspan="8">
                                        <div class="detail-content">
                                            <div class="detail-grid">
                                                <div class="detail-item">
                                                    <span class="detail-label">Potongan:</span>
                                                    <span
                                                        class="detail-value"><?= number_format($kp->potongan, 2, ',', '.') ?>%</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Berat Bersih:</span>
                                                    <span class="detail-value"><?= number_format($berat_bersih, 2, ',', '.') ?>
                                                        kg</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Pendapatan Kotor:</span>
                                                    <span class="detail-value">Rp
                                                        <?= number_format($pendapatan_kotor, 0, ',', '.') ?></span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Upah Panen:</span>
                                                    <span class="detail-value">Rp
                                                        <?= number_format($kp->upah_panen, 0, ',', '.') ?></span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Biaya Transportasi:</span>
                                                    <span class="detail-value">Rp
                                                        <?= number_format($kp->biaya_transportasi, 0, ',', '.') ?></span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Potong Hutang:</span>
                                                    <span class="detail-value">Rp
                                                        <?= number_format($kp->potong_hutang, 0, ',', '.') ?></span>
                                                </div>
                                                <div class="detail-item highlight">
                                                    <span class="detail-label">Total Biaya:</span>
                                                    <span class="detail-value"><strong>Rp
                                                            <?= number_format($total_biaya, 0, ',', '.') ?></strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">📊</div>
                    <h3>Belum Ada Kalkulasi Panen</h3>
                    <p>Anda belum menyimpan kalkulasi panen. Gunakan kalkulator panen untuk menghitung dan menyimpan hasil
                        perhitungan Anda.</p>
                    <a href="<?= site_url('kalkulator-panen') ?>" class="btn btn-primary">Gunakan Kalkulator Panen</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="tab-content" id="tab-pupuk">
        <div class="riwayat-section">
            <h2 class="section-title">Riwayat Kalkulasi Pupuk</h2>

            <?php if (!empty($kalkulasi_pupuk)): ?>
                
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" id="searchInputPupuk" class="form-control" placeholder="Cari tanggal, jenis tanah, jenis pupuk, usia tanaman, jumlah pohon, atau dosis...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success w-100" type="button" id="searchBtnPupuk">
                                <i class="fa fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
                <div class="riwayat-table-wrapper">
                    <table class="riwayat-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">
                                <th>Tanggal</th>
                                <th>Jenis Tanah</th>
                                <th>Jenis Pupuk</th>
                                <th>Usia Tanaman</th>
                                <th>Jumlah Pohon</th>
                                <th>Total Dosis</th>
                                <th style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kalkulasi_pupuk as $index => $kdp): ?>
                                <tr class="riwayat-row" data-id="<?= $kdp->id_kalkulasi ?>">
                                    <td>
                                        <button class="expand-btn" data-target="detail-pupuk-<?= $kdp->id_kalkulasi ?>">
                                            <i class="bi bi-chevron-down"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($kdp->tanggal_kalkulasi) && !empty($kdp->tanggal_kalkulasi)) {
                                            echo date('d M Y, H:i', strtotime($kdp->tanggal_kalkulasi));
                                        } else {
                                            echo 'Tanggal tidak tersedia';
                                        }
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($kdp->nama_tanah ?: '-') ?></td>
                                    <td><?= htmlspecialchars($kdp->nama_pupuk ?: '-') ?></td>
                                    <td><?= $kdp->usia_tanaman ?> bulan</td>
                                    <td><?= number_format($kdp->jumlah_pohon, 0, ',', '.') ?> pohon</td>
                                    <td><strong class="text-success"><?= number_format($kdp->total_dosis, 2, ',', '.') ?>
                                            kg</strong></td>
                                    <td>
                                        <a href="<?= site_url('riwayat/hapus_pupuk/' . $kdp->id_kalkulasi) ?>"
                                            class="btn-delete-table"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kalkulasi ini?')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="detail-row" id="detail-pupuk-<?= $kdp->id_kalkulasi ?>">
                                    <td colspan="8">
                                        <div class="detail-content">
                                            
                                            <div class="dosis-cards-section">
                                                <div class="dosis-card">
                                                    <div class="dosis-card-content">
                                                        <span class="dosis-card-label">Dosis per Pohon</span>
                                                        <span
                                                            class="dosis-card-value"><?= number_format($kdp->dosis_per_pohon, 2, ',', '.') ?>
                                                            kg</span>
                                                    </div>
                                                </div>
                                                <?php if ($kdp->dosis_per_periode): ?>
                                                    <div class="dosis-card">
                                                        <div class="dosis-card-content">
                                                            <span class="dosis-card-label">Dosis per Periode</span>
                                                            <span
                                                                class="dosis-card-value"><?= number_format($kdp->dosis_per_periode, 2, ',', '.') ?>
                                                                kg</span>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="dosis-card">
                                                    <div class="dosis-card-content">
                                                        <span class="dosis-card-label">Periode per Tahun</span>
                                                        <span class="dosis-card-value"><?= $kdp->periode_per_tahun ?>
                                                            kali</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if ($kdp->rekomendasi_pupuk || $kdp->keterangan_aplikasi): ?>
                                                <div class="additional-info-section">
                                                    <?php if ($kdp->rekomendasi_pupuk): ?>
                                                        <div class="info-card">
                                                            <span class="info-card-label">Panduan Aplikasi:</span>
                                                            <span
                                                                class="info-card-value"><?= htmlspecialchars($kdp->rekomendasi_pupuk) ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($kdp->keterangan_aplikasi): ?>
                                                        <div class="info-card">
                                                            <span class="info-card-label">Keterangan:</span>
                                                            <span
                                                                class="info-card-value"><?= htmlspecialchars($kdp->keterangan_aplikasi) ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">🌱</div>
                    <h3>Belum Ada Kalkulasi Pupuk</h3>
                    <p>Anda belum menyimpan kalkulasi pupuk. Gunakan kalkulator pupuk untuk menghitung dan menyimpan hasil
                        perhitungan Anda.</p>
                    <a href="<?= site_url('kalkulator-pupuk') ?>" class="btn btn-primary">Gunakan Kalkulator Pupuk</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>