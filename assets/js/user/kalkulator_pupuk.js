// Kalkulator Pupuk JavaScript
$(document).ready(function() {
    $('#fertilizerForm').on('submit', function(e) {
        e.preventDefault();
        calculateDosis();
    });
    
    // Tampilkan info tanah saat dipilih
    $('#id_tanah').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var phMin = selectedOption.data('ph-min');
        var phMax = selectedOption.data('ph-max');
        var kandunganN = selectedOption.data('kandungan-n');
        var kandunganP = selectedOption.data('kandungan-p');
        var kandunganK = selectedOption.data('kandungan-k');
        var rekomendasi = selectedOption.data('rekomendasi');
        
        var infoHtml = '';
        if (phMin || phMax) {
            infoHtml += '<div><strong>pH:</strong> ' + (phMin ? phMin : '?') + ' - ' + (phMax ? phMax : '?') + '</div>';
        }
        if (kandunganN || kandunganP || kandunganK) {
            infoHtml += '<div><strong>Kandungan:</strong> ';
            var kandungan = [];
            if (kandunganN) kandungan.push('N: ' + kandunganN + '%');
            if (kandunganP) kandungan.push('P: ' + kandunganP + '%');
            if (kandunganK) kandungan.push('K: ' + kandunganK + '%');
            infoHtml += kandungan.join(', ') + '</div>';
        }
        if (rekomendasi) {
            infoHtml += '<div><strong>Rekomendasi:</strong> ' + rekomendasi + '</div>';
        }
        
        if (infoHtml) {
            $('#tanah-details').html(infoHtml);
            $('#tanah-info').show();
        } else {
            $('#tanah-info').hide();
        }
    });
    
    // Tampilkan info pupuk saat dipilih
    $('#id_pupuk').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var kandungan = selectedOption.data('kandungan');
        var fungsi = selectedOption.data('fungsi');
        
        var infoHtml = '';
        if (kandungan) {
            infoHtml += '<div><strong>Kandungan:</strong> ' + kandungan + '</div>';
        }
        if (fungsi) {
            infoHtml += '<div><strong>Fungsi:</strong> ' + fungsi + '</div>';
        }
        
        if (infoHtml) {
            $('#pupuk-details').html(infoHtml);
            $('#pupuk-info').show();
        } else {
            $('#pupuk-info').hide();
        }
    });
});

function calculateDosis() {
    var id_pupuk = $('#id_pupuk').val();
    var id_tanah = $('#id_tanah').val();
    var usia_tanaman = parseInt($('#usia_tanaman').val());
    var jumlah_pohon = parseInt($('#jumlah_pohon').val());
    
    if (!id_pupuk || !id_tanah || !usia_tanaman || !jumlah_pohon) {
        alert('Mohon lengkapi semua field!');
        return;
    }
    
    // AJAX call to get dosis data
    $.ajax({
        url: baseUrl + 'index.php/api/get_dosis',
        method: 'GET',
        data: {
            id_pupuk: id_pupuk,
            id_tanah: id_tanah,
            usia_tanaman: usia_tanaman
        },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data.length > 0) {
                var dosis = response.data[0];
                displayResult(dosis, jumlah_pohon);
            } else {
                alert('Data dosis tidak ditemukan untuk kombinasi yang dipilih.');
            }
        },
        error: function() {
            // Fallback calculation if API not available
            // This is a simple calculation example
            var dosisPerPohon = 2.5; // Default value in kg
            var totalDosis = dosisPerPohon * jumlah_pohon;
            
            var result = {
                dosis_per_pohon: dosisPerPohon,
                keterangan_aplikasi: 'Aplikasikan pupuk secara merata di sekitar pangkal pohon. Pastikan tanah dalam kondisi lembab.'
            };
            
            displayResult(result, jumlah_pohon);
        }
    });
}

function displayResult(dosis, jumlahPohon) {
    var dosisPerPohon = parseFloat(dosis.dosis_per_pohon) || 2.5;
    var totalDosis = dosisPerPohon * jumlahPohon;
    var periodePerTahun = parseInt($('#periode_per_tahun').val()) || 2;
    var dosisPerPeriode = totalDosis / periodePerTahun;
    
    // Format number with thousand separator
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    var html = '<div class="result-summary-card">';
    html += '<div class="result-summary-icon">⚖️</div>';
    html += '<div class="result-summary-content">';
    html += '<div class="result-summary-label">Total Dosis Dibutuhkan</div>';
    html += '<div class="result-summary-value">' + formatNumber(totalDosis.toFixed(2)) + ' <span class="unit">kg</span></div>';
    html += '</div>';
    html += '</div>';
    
    html += '<div class="result-details">';
    
    html += '<div class="result-card">';
    html += '<div class="result-card-icon">🌱</div>';
    html += '<div class="result-card-content">';
    html += '<div class="result-card-label">Dosis per Pohon</div>';
    html += '<div class="result-card-value">' + formatNumber(dosisPerPohon.toFixed(2)) + ' <span class="unit">kg</span></div>';
    html += '</div>';
    html += '</div>';
    
    html += '<div class="result-card">';
    html += '<div class="result-card-icon">🌳</div>';
    html += '<div class="result-card-content">';
    html += '<div class="result-card-label">Jumlah Pohon</div>';
    html += '<div class="result-card-value">' + formatNumber(jumlahPohon) + ' <span class="unit">pohon</span></div>';
    html += '</div>';
    html += '</div>';
    
    html += '<div class="result-card">';
    html += '<div class="result-card-icon">📅</div>';
    html += '<div class="result-card-content">';
    html += '<div class="result-card-label">Periode per Tahun</div>';
    html += '<div class="result-card-value">' + periodePerTahun + ' <span class="unit">kali</span></div>';
    html += '</div>';
    html += '</div>';
    
    html += '<div class="result-card">';
    html += '<div class="result-card-icon">📐</div>';
    html += '<div class="result-card-content">';
    html += '<div class="result-card-label">Dosis per Periode</div>';
    html += '<div class="result-card-value">' + formatNumber(dosisPerPeriode.toFixed(2)) + ' <span class="unit">kg</span></div>';
    html += '</div>';
    html += '</div>';
    
    html += '</div>';
    
    if (dosis.keterangan_aplikasi) {
        html += '<div class="result-info-box">';
        html += '<div class="result-info-header">';
        html += '<span class="result-info-icon">💡</span>';
        html += '<span class="result-info-title">Cara Aplikasi</span>';
        html += '</div>';
        html += '<div class="result-info-content">' + dosis.keterangan_aplikasi + '</div>';
        html += '</div>';
    }
    
    html += '<div class="result-actions">';
    html += '<button type="button" class="btn btn-success btn-block" id="btnSaveDosis">';
    html += '<span class="btn-icon-left">📤</span>';
    html += '<span class="btn-text">Simpan Kalkulasi</span>';
    html += '</button>';
    html += '</div>';
    
    $('#resultContent').html(html);
    
    // Scroll to result
    $('html, body').animate({
        scrollTop: $('#resultContainer').offset().top - 100
    }, 500);
    
    // Save button handler
    $('#btnSaveDosis').on('click', function() {
        saveDosis(dosis, jumlahPohon, totalDosis, dosisPerPeriode, periodePerTahun);
    });
}

function saveDosis(dosis, jumlahPohon, totalDosis, dosisPerPeriode, periodePerTahun) {
    var keteranganAplikasi = $('#keterangan_aplikasi').val();
    if (!keteranganAplikasi && dosis.keterangan_aplikasi) {
        keteranganAplikasi = dosis.keterangan_aplikasi;
    }
    if (!keteranganAplikasi) {
        keteranganAplikasi = 'Aplikasikan pupuk secara merata di sekitar pangkal pohon. Pastikan tanah dalam kondisi lembab.';
    }
    
    var formData = {
        id_pupuk: $('#id_pupuk').val(),
        id_tanah: $('#id_tanah').val(),
        usia_tanaman: $('#usia_tanaman').val(),
        jumlah_pohon: jumlahPohon,
        dosis_per_pohon: dosis.dosis_per_pohon || 2.5,
        total_dosis: totalDosis,
        dosis_per_periode: dosisPerPeriode,
        periode_per_tahun: periodePerTahun,
        rekomendasi_pupuk: $('#id_pupuk option:selected').text(),
        keterangan_aplikasi: keteranganAplikasi
    };
    
    $.ajax({
        url: baseUrl + 'index.php/pupuk/save_dosis',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Data dosis berhasil disimpan!');
                $('#btnSaveDosis').prop('disabled', true).html('<span class="btn-icon-left">✓</span><span class="btn-text">Tersimpan</span>');
            } else {
                alert('Gagal menyimpan: ' + response.message);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan data');
        }
    });
}

// baseUrl sudah diset di footer.php

