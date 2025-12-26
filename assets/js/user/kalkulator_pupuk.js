// Kalkulator Pupuk JavaScript
$(document).ready(function() {
    $('#fertilizerForm').on('submit', function(e) {
        e.preventDefault();
        calculateDosis();
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
    html += '<div class="result-card-icon">📐</div>';
    html += '<div class="result-card-content">';
    html += '<div class="result-card-label">Perhitungan</div>';
    html += '<div class="result-card-value-small">' + formatNumber(dosisPerPohon.toFixed(2)) + ' kg × ' + formatNumber(jumlahPohon) + ' pohon</div>';
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
    html += '<span class="btn-icon-left">💾</span>';
    html += '<span class="btn-text">Simpan Data Dosis</span>';
    html += '</button>';
    html += '</div>';
    
    $('#resultContent').html(html);
    
    // Scroll to result
    $('html, body').animate({
        scrollTop: $('#resultContainer').offset().top - 100
    }, 500);
    
    // Save button handler
    $('#btnSaveDosis').on('click', function() {
        saveDosis(dosis, jumlahPohon);
    });
}

function saveDosis(dosis, jumlahPohon) {
    var formData = {
        id_pupuk: $('#id_pupuk').val(),
        id_tanah: $('#id_tanah').val(),
        usia_tanaman: $('#usia_tanaman').val(),
        dosis_per_pohon: dosis.dosis_per_pohon || 2.5,
        keterangan_aplikasi: dosis.keterangan_aplikasi || 'Aplikasikan pupuk secara merata di sekitar pangkal pohon. Pastikan tanah dalam kondisi lembab.'
    };
    
    $.ajax({
        url: baseUrl + 'index.php/pupuk/save_dosis',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Data dosis berhasil disimpan!');
                $('#btnSaveDosis').prop('disabled', true).text('Tersimpan');
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

