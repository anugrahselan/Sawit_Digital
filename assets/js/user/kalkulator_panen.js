// Kalkulator Panen JavaScript
$(document).ready(function() {
    $('#harvestForm').on('submit', function(e) {
        e.preventDefault();
        calculateHarvest();
    });

    // Handle perubahan kabupaten
    $('#id_kabupaten').on('change', function() {
        var id_kabupaten = $(this).val();
        loadPerusahaan(id_kabupaten);
    });

    // Handle perubahan perusahaan
    $('#id_perusahaan').on('change', function() {
        var id_perusahaan = $(this).val();
        var id_kabupaten = $('#id_kabupaten').val();
        
        // Jika value kosong (Mitra) atau tidak ada, enable input harga manual
        if (!id_perusahaan || id_perusahaan === '') {
            // Jika pilih Mitra (value kosong), enable input harga manual
            $('#harga_per_kg').prop('readonly', false).val('').focus();
            $('#harga-info').hide();
        } else if (id_perusahaan && id_kabupaten) {
            // Jika pilih PT (ada ID), ambil harga TBS terbaru
            loadHargaTBS(id_kabupaten, id_perusahaan);
        } else {
            $('#harga_per_kg').prop('readonly', false).val('');
            $('#harga-info').hide();
        }
    });
});

// Fungsi untuk load perusahaan berdasarkan kabupaten
function loadPerusahaan(id_kabupaten) {
    var $perusahaanSelect = $('#id_perusahaan');
    
    if (!id_kabupaten) {
        $perusahaanSelect.html('<option value="">-- Pilih Kabupaten terlebih dahulu --</option>');
        return;
    }
    
    // Show loading
    $perusahaanSelect.html('<option value="">Memuat...</option>').prop('disabled', true);
    
    var url = baseUrl + 'index.php/panen/get_perusahaan?id_kabupaten=' + id_kabupaten;
    console.log('Loading perusahaan from:', url);
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Response perusahaan:', response);
            $perusahaanSelect.prop('disabled', false);
            
            if (response.success && response.data) {
                var html = '<option value="">-- Mitra (Input Manual) --</option>';
                
                if (response.data.length > 0) {
                    $.each(response.data, function(index, pt) {
                        html += '<option value="' + pt.id_perusahaan + '">' + 
                               escapeHtml(pt.nama_perusahaan) + '</option>';
                    });
                    console.log('Loaded ' + response.data.length + ' perusahaan');
                } else {
                    html += '<option value="">Tidak ada perusahaan di kabupaten ini</option>';
                    console.log('No perusahaan found for kabupaten:', id_kabupaten);
                }
                
                $perusahaanSelect.html(html);
            } else {
                var html = '<option value="">-- Mitra (Input Manual) --</option>';
                if (response.message) {
                    html += '<option value="">' + escapeHtml(response.message) + '</option>';
                }
                $perusahaanSelect.html(html);
                console.log('Response tidak sukses:', response);
            }
            
            // Reset harga
            $('#harga_per_kg').prop('readonly', false).val('');
            $('#harga-info').hide();
        },
        error: function(xhr, status, error) {
            console.error('Error loading perusahaan:', status, error);
            console.error('Status Code:', xhr.status);
            console.error('Response Text:', xhr.responseText);
            console.error('URL:', url);
            
            $perusahaanSelect.prop('disabled', false);
            
            var html = '<option value="">-- Mitra (Input Manual) --</option>';
            html += '<option value="">Error memuat data perusahaan</option>';
            $perusahaanSelect.html(html);
            
            $('#harga_per_kg').prop('readonly', false).val('');
            $('#harga-info').hide();
            
            // Tampilkan error jika ada
            if (xhr.responseJSON && xhr.responseJSON.message) {
                showNotification('error', 'Error', xhr.responseJSON.message);
            } else {
                showNotification('error', 'Error', 'Gagal memuat data perusahaan. Status: ' + xhr.status);
            }
        }
    });
}

// Fungsi untuk load harga TBS berdasarkan perusahaan dan kabupaten
function loadHargaTBS(id_kabupaten, id_perusahaan) {
    $('#harga_per_kg').prop('readonly', true).val('Memuat...');
    $('#harga-info').hide();
    
    $.ajax({
        url: baseUrl + 'index.php/panen/get_harga_tbs',
        type: 'GET',
        data: { 
            id_kabupaten: id_kabupaten,
            id_perusahaan: id_perusahaan
        },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.harga_per_kg) {
                $('#harga_per_kg').val(response.harga_per_kg);
                var tanggal = response.tanggal ? new Date(response.tanggal).toLocaleDateString('id-ID') : '';
                $('#harga-info').html('Harga TBS terbaru: Rp ' + formatNumber(response.harga_per_kg) + 
                    (tanggal ? ' (Tanggal: ' + tanggal + ')' : '')).show();
            } else {
                // Jika tidak ada data, enable input manual
                $('#harga_per_kg').prop('readonly', false).val('').focus();
                $('#harga-info').html('Tidak ada data harga TBS untuk perusahaan ini. Silakan input manual.').show();
            }
        },
        error: function() {
            // Jika error, enable input manual
            $('#harga_per_kg').prop('readonly', false).val('').focus();
            $('#harga-info').html('Gagal memuat harga TBS. Silakan input manual.').show();
        }
    });
}

// Fungsi untuk escape HTML
function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function calculateHarvest() {
    var hargaPerKg = parseFloat($('#harga_per_kg').val()) || 0;
    var beratKotor = parseFloat($('#berat_kotor').val()) || 0;
    var potongan = parseFloat($('#potongan').val()) || 0;
    var upahPanen = parseFloat($('#upah_panen').val()) || 0;
    var biayaTransportasi = parseFloat($('#biaya_transportasi').val()) || 0;
    var potongHutang = parseFloat($('#potong_hutang').val()) || 0;
    
    if (!hargaPerKg || !beratKotor) {
        showNotification('warning', 'Data Tidak Lengkap', 'Mohon isi harga per KG dan berat kotor!');
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
    
    // Cek apakah user sudah login
    var userLoggedIn = typeof isLoggedIn !== 'undefined' ? isLoggedIn : false;
    
    if (!userLoggedIn) {
        // Pesan untuk user yang belum login
        html += '<div class="result-login-prompt">';
        html += '<h4 class="login-prompt-title">🔒 Ingin menyimpan hasil kalkulasi ini?</h4>';
        html += '<p class="login-prompt-text">Silakan <a href="' + baseUrl + 'index.php/login" class="login-link">🔑 Login</a> atau <a href="' + baseUrl + 'index.php/login" class="register-link">📝 Daftar</a> terlebih dahulu.</p>';
        html += '<div class="login-prompt-benefits">';
        html += '<p>Dengan login, Anda bisa:</p>';
        html += '<ul>';
        html += '<li>Menyimpan hasil kalkulasi ke histori</li>';
        html += '<li>Melihat riwayat panen Anda</li>';
        html += '<li>Mengakses data kalkulasi kapan saja</li>';
        html += '</ul>';
        html += '</div>';
        html += '</div>';
    } else {
        // Button untuk menyimpan (jika sudah login)
        html += '<div class="mt-3">';
        html += '<button type="button" class="btn btn-success btn-block" id="btnSave">Simpan Hasil Perhitungan</button>';
        html += '</div>';
    }
    
    $('#resultContent').html(html);
    
    // Show chart container and draw chart
    $('.chart-container').show();
    drawChart(data);
    
    // Save button handler (jika ada)
    if (userLoggedIn) {
        $('#btnSave').on('click', function() {
            saveCalculation(data);
        });
    }
}

function saveCalculation(data) {
    var id_perusahaan = $('#id_perusahaan').val();
    
    // Jika pilih "Mitra" (value kosong), kirim string kosong
    // Backend akan handle untuk mengubahnya menjadi NULL
    // Jika ada ID perusahaan, kirim ID tersebut
    var formData = {
        id_kabupaten: $('#id_kabupaten').val(),
        id_perusahaan: id_perusahaan || '', // Kosong untuk Mitra, atau ID untuk PT
        harga_per_kg: data.hargaPerKg,
        berat_kotor: data.beratKotor,
        potongan: data.potongan,
        upah_panen: data.upahPanen,
        biaya_transportasi: data.biayaTransportasi,
        potong_hutang: data.potongHutang,
        hasil_bersih: data.hasilBersih
    };
    
    console.log('Data yang akan dikirim:', formData);
    
    // Disable button saat proses save
    var $btnSave = $('#btnSave');
    $btnSave.prop('disabled', true).html('<span class="btn-text">Menyimpan...</span>');
    
    $.ajax({
        url: baseUrl + 'index.php/panen/save',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Tampilkan pesan sukses yang bagus
                var successHtml = '<div class="result-success-message">';
                successHtml += '<div class="success-icon">✅</div>';
                successHtml += '<div class="success-content">';
                successHtml += '<h4>Hasil kalkulasi berhasil disimpan!</h4>';
                successHtml += '<p style="margin-top: 0.5rem; color: var(--text-light); font-size: 0.9rem;">Data kalkulasi Anda telah tersimpan ke histori dan dapat dilihat kapan saja.</p>';
                successHtml += '</div>';
                successHtml += '</div>';
                
                $btnSave.replaceWith(successHtml);
            } else {
                // Tampilkan pesan error yang bagus
                showNotification('error', 'Gagal Menyimpan', response.message || 'Terjadi kesalahan saat menyimpan data');
                $btnSave.prop('disabled', false).html('Simpan Hasil Perhitungan');
            }
        },
        error: function(xhr) {
            var errorMessage = 'Terjadi kesalahan saat menyimpan data';
            
            // Cek jika error karena belum login
            if (xhr.status === 401 || (xhr.responseJSON && xhr.responseJSON.message && xhr.responseJSON.message.includes('login'))) {
                errorMessage = 'Anda harus login terlebih dahulu untuk menyimpan kalkulasi';
                showNotification('warning', 'Login Diperlukan', errorMessage, true);
            } else {
                showNotification('error', 'Gagal Menyimpan', errorMessage);
            }
            
            $btnSave.prop('disabled', false).html('Simpan Hasil Perhitungan');
        }
    });
}

// Fungsi untuk menampilkan notifikasi yang bagus
function showNotification(type, title, message, showLoginButton) {
    // Hapus notifikasi sebelumnya jika ada
    $('.custom-notification').remove();
    
    var icon = '';
    var bgColor = '';
    var borderColor = '';
    
    switch(type) {
        case 'success':
            icon = '✅';
            bgColor = 'rgba(46, 125, 50, 0.1)';
            borderColor = 'rgba(46, 125, 50, 0.3)';
            break;
        case 'error':
            icon = '❌';
            bgColor = 'rgba(211, 47, 47, 0.1)';
            borderColor = 'rgba(211, 47, 47, 0.3)';
            break;
        case 'warning':
            icon = '⚠️';
            bgColor = 'rgba(255, 193, 7, 0.1)';
            borderColor = 'rgba(255, 193, 7, 0.3)';
            break;
        default:
            icon = 'ℹ️';
            bgColor = 'rgba(33, 150, 243, 0.1)';
            borderColor = 'rgba(33, 150, 243, 0.3)';
    }
    
    var notificationHtml = '<div class="custom-notification" style="';
    notificationHtml += 'position: fixed; top: 20px; right: 20px; z-index: 10000; ';
    notificationHtml += 'background: linear-gradient(135deg, ' + bgColor + ' 0%, rgba(255,255,255,0.95) 100%); ';
    notificationHtml += 'border: 2px solid ' + borderColor + '; ';
    notificationHtml += 'padding: 1.5rem; border-radius: 16px; ';
    notificationHtml += 'box-shadow: 0 8px 24px rgba(0,0,0,0.15); ';
    notificationHtml += 'max-width: 400px; animation: slideInRight 0.4s ease-out;';
    notificationHtml += '">';
    notificationHtml += '<div style="display: flex; align-items: flex-start; gap: 1rem;">';
    notificationHtml += '<div style="font-size: 2rem; flex-shrink: 0;">' + icon + '</div>';
    notificationHtml += '<div style="flex: 1;">';
    notificationHtml += '<h4 style="margin: 0 0 0.5rem 0; color: var(--primary-color); font-size: 1.1rem; font-weight: 700;">' + title + '</h4>';
    notificationHtml += '<p style="margin: 0; color: var(--text-color); font-size: 0.95rem; line-height: 1.5;">' + message + '</p>';
    
    if (showLoginButton) {
        notificationHtml += '<div style="margin-top: 1rem; display: flex; gap: 0.75rem;">';
        notificationHtml += '<a href="' + baseUrl + 'index.php/login" style="';
        notificationHtml += 'background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); ';
        notificationHtml += 'color: white; padding: 0.625rem 1.25rem; border-radius: 8px; ';
        notificationHtml += 'text-decoration: none; font-weight: 600; font-size: 0.9rem; ';
        notificationHtml += 'display: inline-block; transition: all 0.3s ease;';
        notificationHtml += '">🔑 Login Sekarang</a>';
        notificationHtml += '<button onclick="$(this).closest(\'.custom-notification\').fadeOut(300, function(){$(this).remove()})" style="';
        notificationHtml += 'background: transparent; border: 2px solid var(--border-color); ';
        notificationHtml += 'color: var(--text-color); padding: 0.625rem 1.25rem; border-radius: 8px; ';
        notificationHtml += 'font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;';
        notificationHtml += '">Tutup</button>';
        notificationHtml += '</div>';
    } else {
        notificationHtml += '<button onclick="$(this).closest(\'.custom-notification\').fadeOut(300, function(){$(this).remove()})" style="';
        notificationHtml += 'margin-top: 1rem; background: var(--primary-color); color: white; ';
        notificationHtml += 'border: none; padding: 0.625rem 1.25rem; border-radius: 8px; ';
        notificationHtml += 'font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;';
        notificationHtml += '">Tutup</button>';
    }
    
    notificationHtml += '</div></div></div>';
    
    $('body').append(notificationHtml);
    
    // Auto hide setelah 5 detik (kecuali ada tombol login)
    if (!showLoginButton) {
        setTimeout(function() {
            $('.custom-notification').fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
}

// CSS untuk animasi
if (!$('#notification-styles').length) {
    $('head').append('<style id="notification-styles">' +
        '@keyframes slideInRight { ' +
        '  from { transform: translateX(100%); opacity: 0; } ' +
        '  to { transform: translateX(0); opacity: 1; } ' +
        '} ' +
        '.custom-notification:hover { transform: translateX(-5px); } ' +
        '</style>');
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

