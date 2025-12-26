// Informasi JavaScript
$(document).ready(function() {
    // Show More Articles Toggle
    $('#btnShowMoreArticles').on('click', function() {
        const hiddenArticles = $('.hidden-article');
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

