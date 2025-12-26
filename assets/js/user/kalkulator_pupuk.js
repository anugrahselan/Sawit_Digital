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
    
    var html = '<div class="result-item">';
    html += '<div class="result-label">Dosis per Pohon</div>';
    html += '<div class="result-value">' + dosisPerPohon.toFixed(2) + ' kg</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Jumlah Pohon</div>';
    html += '<div class="result-value">' + jumlahPohon + ' pohon</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Total Dosis Dibutuhkan</div>';
    html += '<div class="result-value" style="font-size: 1.5rem; color: var(--primary-color); font-weight: bold;">' + totalDosis.toFixed(2) + ' kg</div>';
    html += '</div>';
    
    if (dosis.keterangan_aplikasi) {
        html += '<div class="result-item">';
        html += '<div class="result-label">Cara Aplikasi</div>';
        html += '<div class="result-value">' + dosis.keterangan_aplikasi + '</div>';
        html += '</div>';
    }
    
    html += '<div class="mt-3">';
    html += '<button type="button" class="btn btn-success btn-block" id="btnSaveDosis">Simpan Data Dosis</button>';
    html += '</div>';
    
    $('#resultContent').html(html);
    $('#resultContainer').show();
    
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

