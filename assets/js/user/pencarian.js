(function() {
    'use strict';
    
    function initSearch() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initSearch, 100);
            return;
        }
        
        jQuery(document).ready(function($) {
            var searchResults = $('#searchResults');
            var searchResultsContent = $('#searchResultsContent');
            var highlightedElements = [];
            
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                
                var keyword = $('#searchInput').val().trim();
                
                if (!keyword) {
                    alert('Mohon masukkan kata kunci pencarian!');
                    return false;
                }
                
                searchInPage(keyword);
            });
            
            function searchInPage(keyword) {
                clearHighlights();
                
                $('html, body').scrollTop(0);
                
                var found = false;
                var results = [];
                var regex = new RegExp('(' + escapeRegExp(keyword) + ')', 'gi');
                
                var searchableSelectors = 'p, span, div, h1, h2, h3, h4, h5, h6, li, td, th, a, label, strong, em, b, i';
                
                $(searchableSelectors).not('script, style, noscript, .search-highlight, .search-section *').each(function() {
                    var $element = $(this);
                    
                    if ($element.closest('.search-highlight').length > 0 || $element.hasClass('search-highlight')) {
                        return;
                    }
                    
                    var text = $element.clone().children().remove().end().text();
                    
                    if (text && text.trim().length > 0 && regex.test(text)) {
                        found = true;
                        
                        var originalHtml = $element.html();
                        
                        var highlightedText = text.replace(regex, '<mark class="search-highlight">$1</mark>');
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
                        '<p style="color: var(--primary-color); font-weight: 600; margin-bottom: 0.5rem;">✓ Ditemukan ' + count + ' hasil untuk "' + escapeHtml(keyword) + '"</p>' +
                        '<p style="color: var(--text-light); font-size: 0.9rem; margin: 0;">Gulir ke bawah untuk melihat hasil yang di-highlight</p>'
                    );
                    searchResults.slideDown();
                    
                    if (results.length > 0) {
                        setTimeout(function() {
                            $('html, body').animate({
                                scrollTop: results[0].top - 150
                            }, 500);
                        }, 300);
                    }
                } else {
                    searchResultsContent.html(
                        '<p style="color: #e53935; font-weight: 600; margin-bottom: 0.5rem;">✗ Tidak ditemukan hasil untuk "' + escapeHtml(keyword) + '"</p>' +
                        '<p style="color: var(--text-light); font-size: 0.9rem; margin: 0;">Coba gunakan kata kunci lain</p>'
                    );
                    searchResults.slideDown();
                }
            }
            
            function clearHighlights() {
                highlightedElements.forEach(function(item) {
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
                return text.replace(/[&<>"']/g, function(m) { return map[m]; });
            }
            
            $('#searchInput').on('input', function() {
                if ($(this).val().trim() === '') {
                    clearHighlights();
                    searchResults.slideUp();
                }
            });
        });
    }
    
    initSearch();
})();

