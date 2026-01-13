$(document).ready(function() {
    $('#btnShowMoreArticles').on('click', function() {
        const hiddenArticles = $('.hidden-article');
        const btn = $(this);
        const btnText = btn.find('.btn-text');
        
        if (hiddenArticles.is(':visible')) {
            hiddenArticles.slideUp(300, function() {
                btn.removeClass('active');
                btnText.text('Lihat Lainnya');
            });
        } else {
            hiddenArticles.slideDown(300, function() {
                btn.addClass('active');
                btnText.text('Sembunyikan');
            });
        }
    });
});

