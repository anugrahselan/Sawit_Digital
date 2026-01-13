document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function (e) {
            e.preventDefault();
            sidebar.classList.toggle('collapsed');

            if (typeof localStorage !== 'undefined') {
                if (sidebar.classList.contains('collapsed')) {
                    localStorage.setItem('sidebarCollapsed', 'true');
                } else {
                    localStorage.removeItem('sidebarCollapsed');
                }
            }
        });

        if (typeof localStorage !== 'undefined') {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
            }
        }
    }

    document.addEventListener('click', function (e) {
        if (window.innerWidth <= 768 && sidebar) {
            if (!sidebar.contains(e.target) && sidebarToggle && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });

    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    document.querySelectorAll('[data-confirm-delete]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    initAdminSearch();

    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover',
                delay: { show: 300, hide: 100 }
            });
        });

        if (sidebarToggle && sidebar) {
            const updateTooltips = function () {
                const isCollapsed = sidebar.classList.contains('collapsed');
                tooltipTriggerList.forEach(function (tooltipEl) {
                    const tooltip = bootstrap.Tooltip.getInstance(tooltipEl);
                    if (tooltip) {
                        if (isCollapsed) {
                            tooltip.enable();
                        } else {
                            tooltip.disable();
                        }
                    }
                });
            };

            const observer = new MutationObserver(updateTooltips);
            observer.observe(sidebar, {
                attributes: true,
                attributeFilter: ['class']
            });

            updateTooltips();
        }
    }
});

function initAdminSearch() {
    if (typeof jQuery === 'undefined') {
        setTimeout(initAdminSearch, 100);
        return;
    }

    jQuery(document).ready(function ($) {
        var searchResults = $('#adminSearchResults');
        var searchResultsContent = $('#adminSearchResultsContent');
        var highlightedElements = [];

        $('#adminSearchForm').on('submit', function (e) {
            e.preventDefault();

            var keyword = $('#adminSearchInput').val().trim();

            if (!keyword) {
                clearHighlights();
                searchResults.slideUp();
                return false;
            }

            searchInPage(keyword);
        });

        function searchInPage(keyword) {
            clearHighlights();

            var found = false;
            var results = [];
            var regex = new RegExp('(' + escapeRegExp(keyword) + ')', 'gi');

            var $contentArea = $('.admin-content');
            if ($contentArea.length === 0) {
                return;
            }

            var searchableSelectors = 'p, span, div, h1, h2, h3, h4, h5, h6, li, td, th, a, label, strong, em, b, i, .card-title, .card-text';

            $contentArea.find(searchableSelectors).not('script, style, noscript, .search-highlight, #adminSearchResults, #adminSearchResults *').each(function () {
                var $element = $(this);

                if ($element.closest('.search-highlight').length > 0 || $element.hasClass('search-highlight')) {
                    return;
                }

                if ($element.closest('#adminSearchResults').length > 0) {
                    return;
                }

                var text = $element.clone().children().remove().end().text();

                if (text && text.trim().length > 0 && regex.test(text)) {
                    found = true;

                    var originalHtml = $element.html();

                    var highlightedText = text.replace(regex, '<mark class="search-highlight" style="background-color: #ffeb3b; padding: 2px 4px; border-radius: 3px;">$1</mark>');
                    $element.html(highlightedText);

                    highlightedElements.push({
                        element: $element,
                        originalHtml: originalHtml
                    });

                    var offset = $element.offset();
                    if (offset && results.length === 0) {
                        results.push({
                            top: offset.top
                        });
                    }
                }
            });

            if (found) {
                var count = highlightedElements.length;
                searchResultsContent.html(
                    '<i class="bi bi-check-circle"></i> Ditemukan <strong>' + count + '</strong> hasil untuk "<strong>' + escapeHtml(keyword) + '</strong>"'
                );
                searchResults.removeClass('alert-danger').addClass('alert-info').slideDown();

                if (results.length > 0) {
                    setTimeout(function () {
                        $('html, body').animate({
                            scrollTop: results[0].top - 100
                        }, 500);
                    }, 300);
                }
            } else {
                searchResultsContent.html(
                    '<i class="bi bi-x-circle"></i> Tidak ditemukan hasil untuk "<strong>' + escapeHtml(keyword) + '</strong>"'
                );
                searchResults.removeClass('alert-info').addClass('alert-danger').slideDown();
            }
        }

        function clearHighlights() {
            highlightedElements.forEach(function (item) {
                if (item.element && item.element.length) {
                    item.element.html(item.originalHtml);
                }
            });
            highlightedElements = [];
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function (m) { return map[m]; });
        }

        $('#adminSearchInput').on('input', function () {
            if ($(this).val().trim() === '') {
                clearHighlights();
                searchResults.slideUp();
            }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && $('#adminSearchInput').is(':focus')) {
                $('#adminSearchInput').val('');
                clearHighlights();
                searchResults.slideUp();
            }
        });
    });
}






