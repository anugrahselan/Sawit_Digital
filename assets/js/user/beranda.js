// Beranda JavaScript
$(document).ready(function() {
    // Load TBS Prices via AJAX
    loadTbsPrices();

    // Show More Features Toggle
    $('#btnShowMore').on('click', function() {
        const hiddenCards = $('.hidden-card');
        const btn = $(this);
        const btnText = btn.find('.btn-text');
        
        if (hiddenCards.is(':visible')) {
            // Hide cards
            hiddenCards.slideUp(300, function() {
                btn.removeClass('active');
                btnText.text('Lihat Lainnya');
            });
        } else {
            // Show cards
            hiddenCards.slideDown(300, function() {
                btn.addClass('active');
                btnText.text('Sembunyikan');
            });
        }
    });

    // Show More Articles Toggle (Beranda)
    $('#btnShowMoreArticlesBeranda').on('click', function() {
        const hiddenArticles = $('#articles-grid-beranda .hidden-article');
        const btn = $(this);
        const btnText = btn.find('.btn-text');
        
        if (hiddenArticles.is(':visible')) {
            // Hide articles
            hiddenArticles.slideUp(300, function() {
                btn.removeClass('active');
                btnText.text('Lihat Lainnya');
            });
        } else {
            // Show articles
            hiddenArticles.slideDown(300, function() {
                btn.addClass('active');
                btnText.text('Sembunyikan');
            });
        }
    });
});

function loadTbsPrices() {
    $.ajax({
        url: baseUrl + 'index.php/api/tbs_prices',
        method: 'GET',
        success: function(response) {
            $('#tbs-table-container').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error loading TBS prices:', error);
        }
    });
}
