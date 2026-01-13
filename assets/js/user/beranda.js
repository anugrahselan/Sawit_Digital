$(document).ready(function () {
    $('#btnShowMore').on('click', function () {
        const hiddenCards = $('.hidden-card');
        const btn = $(this);
        const btnText = btn.find('.btn-text');

        if (hiddenCards.is(':visible')) {
            hiddenCards.slideUp(300, function () {
                btn.removeClass('active');
                btnText.text('Lihat Lainnya');
            });
        } else {
            hiddenCards.slideDown(300, function () {
                btn.addClass('active');
                btnText.text('Sembunyikan');
            });
        }
    });

    $('#btnShowMoreArticlesBeranda').on('click', function () {
        const hiddenArticles = $('#articles-grid-beranda .hidden-article');
        const btn = $(this);
        const btnText = btn.find('.btn-text');

        if (hiddenArticles.is(':visible')) {
            hiddenArticles.slideUp(300, function () {
                btn.removeClass('active');
                btnText.text('Lihat Lainnya');
            });
        } else {
            hiddenArticles.slideDown(300, function () {
                btn.addClass('active');
                btnText.text('Sembunyikan');
            });
        }
    });
});
