// Kalkulator Panen JavaScript
$(document).ready(function() {
    $('#harvestForm').on('submit', function(e) {
        e.preventDefault();
        calculateHarvest();
    });
});

function calculateHarvest() {
    var hargaPerKg = parseFloat($('#harga_per_kg').val()) || 0;
    var beratKotor = parseFloat($('#berat_kotor').val()) || 0;
    var potongan = parseFloat($('#potongan').val()) || 0;
    var upahPanen = parseFloat($('#upah_panen').val()) || 0;
    var biayaTransportasi = parseFloat($('#biaya_transportasi').val()) || 0;
    var potongHutang = parseFloat($('#potong_hutang').val()) || 0;
    
    if (!hargaPerKg || !beratKotor) {
        alert('Mohon isi harga per KG dan berat kotor!');
        return;
    }
    
    // Calculate
    var beratBersih = beratKotor - (beratKotor * potongan / 100);
    var pendapatanKotor = beratBersih * hargaPerKg;
    var totalBiaya = upahPanen + biayaTransportasi + potongHutang;
    var hasilBersih = pendapatanKotor - totalBiaya;
    
    displayResult({
        beratKotor: beratKotor,
        potongan: potongan,
        beratBersih: beratBersih,
        hargaPerKg: hargaPerKg,
        pendapatanKotor: pendapatanKotor,
        upahPanen: upahPanen,
        biayaTransportasi: biayaTransportasi,
        potongHutang: potongHutang,
        totalBiaya: totalBiaya,
        hasilBersih: hasilBersih
    });
}

function displayResult(data) {
    var html = '<div class="result-summary">';
    html += '<h3>Hasil Bersih</h3>';
    html += '<div class="amount">Rp ' + formatNumber(data.hasilBersih) + '</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Berat Kotor</div>';
    html += '<div class="result-value">' + formatNumber(data.beratKotor) + ' kg</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Potongan (' + data.potongan + '%)</div>';
    html += '<div class="result-value">' + formatNumber(data.beratKotor - data.beratBersih) + ' kg</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Berat Bersih</div>';
    html += '<div class="result-value">' + formatNumber(data.beratBersih) + ' kg</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Harga per KG</div>';
    html += '<div class="result-value">Rp ' + formatNumber(data.hargaPerKg) + '</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Pendapatan Kotor</div>';
    html += '<div class="result-value">Rp ' + formatNumber(data.pendapatanKotor) + '</div>';
    html += '</div>';
    
    html += '<hr style="margin: 1rem 0; border: none; border-top: 1px solid var(--border-color);">';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Upah Panen</div>';
    html += '<div class="result-value">Rp ' + formatNumber(data.upahPanen) + '</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Biaya Transportasi</div>';
    html += '<div class="result-value">Rp ' + formatNumber(data.biayaTransportasi) + '</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Potong Hutang</div>';
    html += '<div class="result-value">Rp ' + formatNumber(data.potongHutang) + '</div>';
    html += '</div>';
    
    html += '<div class="result-item">';
    html += '<div class="result-label">Total Biaya</div>';
    html += '<div class="result-value">Rp ' + formatNumber(data.totalBiaya) + '</div>';
    html += '</div>';
    
    html += '<div class="mt-3">';
    html += '<button type="button" class="btn btn-success btn-block" id="btnSave">Simpan Hasil Perhitungan</button>';
    html += '</div>';
    
    $('#resultContent').html(html);
    $('#resultContainer').show();
    
    // Draw simple chart
    drawChart(data);
    
    // Save button handler
    $('#btnSave').on('click', function() {
        saveCalculation(data);
    });
}

function saveCalculation(data) {
    var formData = {
        id_kabupaten: $('#id_kabupaten').val(),
        id_perusahaan: $('#id_perusahaan').val() || '',
        harga_per_kg: data.hargaPerKg,
        berat_kotor: data.beratKotor,
        potongan: data.potongan,
        upah_panen: data.upahPanen,
        biaya_transportasi: data.biayaTransportasi,
        potong_hutang: data.potongHutang,
        hasil_bersih: data.hasilBersih
    };
    
    $.ajax({
        url: baseUrl + 'index.php/panen/save',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Data berhasil disimpan!');
                $('#btnSave').prop('disabled', true).text('Tersimpan');
            } else {
                alert('Gagal menyimpan: ' + response.message);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan data');
        }
    });
}

function formatNumber(num) {
    return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function drawChart(data) {
    var canvas = document.getElementById('harvestChart');
    if (!canvas) return;
    
    var ctx = canvas.getContext('2d');
    var width = canvas.width;
    var height = canvas.height;
    
    // Clear canvas
    ctx.clearRect(0, 0, width, height);
    
    // Simple bar chart
    var maxValue = Math.max(data.pendapatanKotor, data.totalBiaya, data.hasilBersih);
    var barWidth = 80;
    var spacing = 30;
    var startX = 50;
    var chartHeight = height - 60;
    
    // Draw bars
    drawBar(ctx, startX, chartHeight, barWidth, (data.pendapatanKotor / maxValue) * chartHeight, '#4a7c2a', 'Pendapatan');
    drawBar(ctx, startX + barWidth + spacing, chartHeight, barWidth, (data.totalBiaya / maxValue) * chartHeight, '#c0392b', 'Biaya');
    drawBar(ctx, startX + (barWidth + spacing) * 2, chartHeight, barWidth, (data.hasilBersih / maxValue) * chartHeight, '#2d5016', 'Bersih');
}

function drawBar(ctx, x, baseY, width, height, color, label) {
    ctx.fillStyle = color;
    ctx.fillRect(x, baseY - height, width, height);
    
    // Label
    ctx.fillStyle = '#333';
    ctx.font = '12px Arial';
    ctx.textAlign = 'center';
    ctx.fillText(label, x + width / 2, baseY + 15);
}

// baseUrl sudah diset di footer.php

