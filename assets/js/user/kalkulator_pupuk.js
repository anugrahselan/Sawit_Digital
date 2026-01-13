$(document).ready(function () {
    $('#fertilizerForm').on('submit', function (e) {
        e.preventDefault();
        calculateDosis();
    });

    $('#id_tanah').on('change', function () {
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

    $('#id_pupuk').on('change', function () {
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

function getPhStatus(ph) {
    if (ph < 6.5) {
        return { status: 'Asam', class: 'status-asam' };
    } else if (ph >= 6.5 && ph <= 7.5) {
        return { status: 'Netral', class: 'status-netral' };
    } else {
        return { status: 'Basa', class: 'status-basa' };
    }
}

function getKandunganStatus(nilai) {
    if (!nilai || nilai === '') return { status: '-', class: '' };

    var num = parseFloat(nilai);
    if (num < 1.5) {
        return { status: 'Rendah', class: 'status-rendah' };
    } else if (num >= 1.5 && num <= 3.0) {
        return { status: 'Sedang', class: 'status-sedang' };
    } else {
        return { status: 'Tinggi', class: 'status-tinggi' };
    }
}

function calculateDosis() {
    var id_pupuk = $('#id_pupuk').val();
    var id_tanah = $('#id_tanah').val();
    var usia_tanaman = parseInt($('#usia_tanaman').val());
    var jumlah_pohon = parseInt($('#jumlah_pohon').val());
    var periode_per_tahun = parseInt($('#periode_per_tahun').val()) || 4;

    if (!id_pupuk || !id_tanah || !usia_tanaman || !jumlah_pohon) {
        alert('Mohon lengkapi semua field yang wajib!');
        return;
    }

    var selectedTanah = $('#id_tanah option:selected');
    var namaTanah = selectedTanah.text();
    var phMin = parseFloat(selectedTanah.data('ph-min')) || null;
    var phMax = parseFloat(selectedTanah.data('ph-max')) || null;
    var kandunganN = parseFloat(selectedTanah.data('kandungan-n')) || null;
    var kandunganP = parseFloat(selectedTanah.data('kandungan-p')) || null;
    var kandunganK = parseFloat(selectedTanah.data('kandungan-k')) || null;
    var rekomendasiTanah = selectedTanah.data('rekomendasi') || '';

    var phEstimate = null;
    var phDisplay = null;
    if (phMin && phMax) {
        phEstimate = ((phMin + phMax) / 2).toFixed(1);
        phDisplay = phEstimate;
    } else if (phMin) {
        phEstimate = phMin;
        phDisplay = phEstimate;
    } else if (phMax) {
        phEstimate = phMax;
        phDisplay = phEstimate;
    } else {
        phDisplay = 'Tidak tersedia';
    }

    var selectedPupuk = $('#id_pupuk option:selected');
    var namaPupuk = selectedPupuk.text();
    var kandunganPupuk = selectedPupuk.data('kandungan') || '';
    var fungsiPupuk = selectedPupuk.data('fungsi') || '';

    var dosisPerPohon = 2.5;
    $.ajax({
        url: baseUrl + 'index.php/pupuk/get_dosis',
        method: 'GET',
        data: {
            id_pupuk: id_pupuk,
            id_tanah: id_tanah,
            usia_tanaman: usia_tanaman
        },
        dataType: 'json',
        success: function (response) {
            if (response.success && response.data.length > 0) {
                dosisPerPohon = parseFloat(response.data[0].dosis_per_pohon) || dosisPerPohon;
            }
            displayResult({
                nama_tanah: namaTanah,
                ph_display: phDisplay,
                ph_estimate: phEstimate,
                kandungan_n: kandunganN,
                kandungan_p: kandunganP,
                kandungan_k: kandunganK,
                rekomendasi_tanah: rekomendasiTanah,
                nama_pupuk: namaPupuk,
                kandungan_pupuk: kandunganPupuk,
                fungsi_pupuk: fungsiPupuk,
                dosis_per_pohon: dosisPerPohon
            }, jumlah_pohon, periode_per_tahun);
        },
        error: function () {
            displayResult({
                nama_tanah: namaTanah,
                ph_display: phDisplay,
                ph_estimate: phEstimate,
                kandungan_n: kandunganN,
                kandungan_p: kandunganP,
                kandungan_k: kandunganK,
                rekomendasi_tanah: rekomendasiTanah,
                nama_pupuk: namaPupuk,
                kandungan_pupuk: kandunganPupuk,
                fungsi_pupuk: fungsiPupuk,
                dosis_per_pohon: dosisPerPohon
            }, jumlah_pohon, periode_per_tahun);
        }
    });
}

function displayResult(data, jumlahPohon, periodePerTahun) {
    var dosisPerPohon = parseFloat(data.dosis_per_pohon) || 2.5;
    var totalDosis = dosisPerPohon * jumlahPohon;
    var dosisPerPeriode = totalDosis / periodePerTahun;

    function formatNumber(num) {
        if (typeof num === 'string' && num === 'Tidak tersedia') return num;
        return parseFloat(num).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    var phValue = parseFloat(data.ph_display);
    var phStatus = null;
    if (!isNaN(phValue)) {
        phStatus = getPhStatus(phValue);
    }

    var statusN = getKandunganStatus(data.kandungan_n);
    var statusP = getKandunganStatus(data.kandungan_p);
    var statusK = getKandunganStatus(data.kandungan_k);

    var infoPupuk = '';
    if (data.nama_pupuk) {
        infoPupuk = data.nama_pupuk;
        if (data.kandungan_pupuk) {
            infoPupuk += ' - ' + data.kandungan_pupuk;
        }
        if (data.fungsi_pupuk) {
            infoPupuk += '. ' + data.fungsi_pupuk;
        }
    }
    if (!infoPupuk) {
        infoPupuk = 'Informasi pupuk tidak tersedia.';
    }


    var html = '<div class="result-section">';
    html += '<h3 class="result-section-title">Hasil Kalkulasi</h3>';

    html += '<div class="result-info-card">';
    html += '<div class="result-info-row">';
    html += '<span class="result-info-label">Jenis Tanah:</span>';
    html += '<span class="result-info-value">' + (data.nama_tanah || '-') + '</span>';
    html += '</div>';

    html += '<div class="result-info-row">';
    html += '<span class="result-info-label">pH Tanah:</span>';
    html += '<span class="result-info-value">' + data.ph_display;
    if (data.ph_estimate) {
        html += ' (estimasi)';
    }
    if (phStatus) {
        html += ' → Status: <span class="' + phStatus.class + '">' + phStatus.status + '</span>';
    }
    html += '</span>';
    html += '</div>';

    html += '<div class="result-info-row">';
    html += '<span class="result-info-label">Kandungan N:</span>';
    html += '<span class="result-info-value">' + (data.kandungan_n ? data.kandungan_n + '%' : '-');
    if (statusN.status !== '-') {
        html += ' → <span class="' + statusN.class + '">' + statusN.status + '</span>';
    }
    html += '</span>';
    html += '</div>';

    html += '<div class="result-info-row">';
    html += '<span class="result-info-label">Kandungan P:</span>';
    html += '<span class="result-info-value">' + (data.kandungan_p ? data.kandungan_p + '%' : '-');
    if (statusP.status !== '-') {
        html += ' → <span class="' + statusP.class + '">' + statusP.status + '</span>';
    }
    html += '</span>';
    html += '</div>';

    html += '<div class="result-info-row">';
    html += '<span class="result-info-label">Kandungan K:</span>';
    html += '<span class="result-info-value">' + (data.kandungan_k ? data.kandungan_k + '%' : '-');
    if (statusK.status !== '-') {
        html += ' → <span class="' + statusK.class + '">' + statusK.status + '</span>';
    }
    html += '</span>';
    html += '</div>';
    html += '</div>';

    html += '<div class="result-dosis-card">';
    html += '<h4 class="result-dosis-title">Hasil Perhitungan Dosis</h4>';

    html += '<div class="result-dosis-item">';
    html += '<span class="result-dosis-label">Dosis per Pohon:</span>';
    html += '<span class="result-dosis-value">' + formatNumber(dosisPerPohon) + ' kg</span>';
    html += '</div>';

    html += '<div class="result-dosis-item">';
    html += '<span class="result-dosis-label">Total Dosis:</span>';
    html += '<span class="result-dosis-value">' + formatNumber(totalDosis) + ' kg</span>';
    html += '</div>';

    html += '<div class="result-dosis-item">';
    html += '<span class="result-dosis-label">Dosis per Periode:</span>';
    html += '<span class="result-dosis-value">' + formatNumber(dosisPerPeriode) + ' kg</span>';
    html += '</div>';
    html += '</div>';

    html += '<div class="result-rekomendasi-card">';
    html += '<h4 class="result-rekomendasi-title">Informasi Pupuk</h4>';
    html += '<p class="result-rekomendasi-text">' + infoPupuk + '</p>';
    html += '</div>';

    html += '</div>';

    var userLoggedIn = typeof isLoggedIn !== 'undefined' ? isLoggedIn : false;

    if (!userLoggedIn) {
        html += '<div class="result-login-prompt">';
        html += '<h4 class="login-prompt-title">Ingin menyimpan hasil kalkulasi ini?</h4>';
        html += '<p class="login-prompt-text">Silakan <a href="' + baseUrl + 'index.php/login" class="login-link">Login</a> atau <a href="' + baseUrl + 'index.php/login" class="register-link">Daftar</a> terlebih dahulu.</p>';
        html += '<div class="login-prompt-benefits">';
        html += '<p>Dengan login, Anda bisa:</p>';
        html += '<ul>';
        html += '<li>Menyimpan hasil kalkulasi ke histori</li>';
        html += '<li>Melihat riwayat pemupukan Anda</li>';
        html += '<li>Mendapatkan rekomendasi lanjutan berdasarkan kondisi tanah</li>';
        html += '</ul>';
        html += '</div>';
        html += '</div>';
    } else {
        html += '<div class="result-actions">';
        html += '<button type="button" class="btn btn-success btn-block" id="btnSaveDosis">';
        html += '<span class="btn-text">Simpan Kalkulasi</span>';
        html += '</button>';
        html += '</div>';
    }

    $('#resultContent').html(html);

    $('html, body').animate({
        scrollTop: $('#resultContainer').offset().top - 100
    }, 500);

    if (userLoggedIn) {
        $('#btnSaveDosis').on('click', function () {
            saveDosis(data, jumlahPohon, totalDosis, dosisPerPeriode, periodePerTahun);
        });
    }
}

function saveDosis(data, jumlahPohon, totalDosis, dosisPerPeriode, periodePerTahun) {
    var keteranganAplikasi = $('#keterangan_aplikasi').val();
    if (!keteranganAplikasi) {
        keteranganAplikasi = 'Aplikasikan pupuk secara merata di sekitar pangkal pohon. Pastikan tanah dalam kondisi lembab.';
    }

    var formData = {
        id_pupuk: $('#id_pupuk').val(),
        id_tanah: $('#id_tanah').val(),
        usia_tanaman: $('#usia_tanaman').val(),
        jumlah_pohon: jumlahPohon,
        dosis_per_pohon: data.dosis_per_pohon || 2.5,
        total_dosis: totalDosis,
        dosis_per_periode: dosisPerPeriode,
        periode_per_tahun: periodePerTahun,
        rekomendasi_pupuk: data.nama_pupuk + ' - ' + (data.rekomendasi_tanah || ''),
        keterangan_aplikasi: keteranganAplikasi
    };

    $.ajax({
        url: baseUrl + 'index.php/pupuk/save_dosis',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                var successHtml = '<div class="result-success-message">';
                successHtml += '<div class="success-content">';
                successHtml += '<h4>Hasil kalkulasi berhasil disimpan ke histori Anda.</h4>';
                successHtml += '<p style="margin-top: 0.5rem; color: var(--text-light); font-size: 0.9rem;">Data kalkulasi Anda telah tersimpan dan dapat dilihat di halaman riwayat kalkulasi.</p>';
                successHtml += '</div>';
                successHtml += '</div>';

                $('#btnSaveDosis').replaceWith(successHtml);
            } else {
                showNotification('error', 'Gagal Menyimpan', response.message || 'Terjadi kesalahan saat menyimpan data');
            }
        },
        error: function (xhr) {
            var errorMessage = 'Terjadi kesalahan saat menyimpan data';

            if (xhr.status === 401 || (xhr.responseJSON && xhr.responseJSON.message && xhr.responseJSON.message.includes('login'))) {
                errorMessage = 'Anda harus login terlebih dahulu untuk menyimpan kalkulasi';
                showNotification('warning', 'Login Diperlukan', errorMessage, true);
            } else {
                showNotification('error', 'Gagal Menyimpan', errorMessage);
            }
        }
    });
}

function showNotification(type, title, message, showLoginButton) {
    $('.custom-notification').remove();

    var icon = '';
    var bgColor = '';
    var borderColor = '';

    switch (type) {
        case 'success':
            icon = '';
            bgColor = 'rgba(46, 125, 50, 0.1)';
            borderColor = 'rgba(46, 125, 50, 0.3)';
            break;
        case 'error':
            icon = '';
            bgColor = 'rgba(211, 47, 47, 0.1)';
            borderColor = 'rgba(211, 47, 47, 0.3)';
            break;
        case 'warning':
            icon = '';
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

    if (!showLoginButton) {
        setTimeout(function () {
            $('.custom-notification').fadeOut(300, function () {
                $(this).remove();
            });
        }, 5000);
    }
}

if (!$('#notification-styles').length) {
    $('head').append('<style id="notification-styles">' +
        '@keyframes slideInRight { ' +
        '  from { transform: translateX(100%); opacity: 0; } ' +
        '  to { transform: translateX(0); opacity: 1; } ' +
        '} ' +
        '.custom-notification:hover { transform: translateX(-5px); } ' +
        '</style>');
}
