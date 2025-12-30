// Search JavaScript - Pencarian di halaman yang sama
(function() {
    'use strict';
    
    function initSearch() {
        // Tunggu jQuery ready
        if (typeof jQuery === 'undefined') {
            setTimeout(initSearch, 100);
            return;
        }
        
        jQuery(document).ready(function($) {
            var searchResults = $('#searchResults');
            var searchResultsContent = $('#searchResultsContent');
            var highlightedElements = [];
            
            // Handle search form
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                
                var keyword = $('#searchInput').val().trim();
                
                if (!keyword) {
                    alert('Mohon masukkan kata kunci pencarian!');
                    return false;
                }
                
                // Cari di halaman yang sama
                searchInPage(keyword);
            });
            
            function searchInPage(keyword) {
                // Hapus highlight sebelumnya
                clearHighlights();
                
                // Reset scroll
                $('html, body').scrollTop(0);
                
                var found = false;
                var results = [];
                var regex = new RegExp('(' + escapeRegExp(keyword) + ')', 'gi');
                
                // Cari di elemen yang bisa dicari (hindari script, style, dll)
                var searchableSelectors = 'p, span, div, h1, h2, h3, h4, h5, h6, li, td, th, a, label, strong, em, b, i';
                
                $(searchableSelectors).not('script, style, noscript, .search-highlight, .search-section *').each(function() {
                    var $element = $(this);
                    
                    // Skip jika sudah di-highlight atau di dalam elemen yang di-highlight
                    if ($element.closest('.search-highlight').length > 0 || $element.hasClass('search-highlight')) {
                        return;
                    }
                    
                    // Ambil teks dari elemen ini saja (bukan dari child)
                    var text = $element.clone().children().remove().end().text();
                    
                    if (text && text.trim().length > 0 && regex.test(text)) {
                        found = true;
                        
                        // Simpan HTML asli
                        var originalHtml = $element.html();
                        
                        // Highlight teks
                        var highlightedText = text.replace(regex, '<mark class="search-highlight">$1</mark>');
                        $element.html(highlightedText);
                        
                        // Simpan untuk bisa di-restore
                        highlightedElements.push({
                            element: $element,
                            originalHtml: originalHtml
                        });
                        
                        // Simpan posisi untuk scroll
                        var offset = $element.offset();
                        if (offset && results.length === 0) {
                            results.push({
                                top: offset.top
                            });
                        }
                    }
                });
                
                // Tampilkan hasil
                if (found) {
                    var count = highlightedElements.length;
                    searchResultsContent.html(
                        '<p style="color: var(--primary-color); font-weight: 600; margin-bottom: 0.5rem;">✓ Ditemukan ' + count + ' hasil untuk "' + escapeHtml(keyword) + '"</p>' +
                        '<p style="color: var(--text-light); font-size: 0.9rem; margin: 0;">Gulir ke bawah untuk melihat hasil yang di-highlight</p>'
                    );
                    searchResults.slideDown();
                    
                    // Scroll ke hasil pertama
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
                // Restore HTML asli
                highlightedElements.forEach(function(item) {
                    if (item.element && item.element.length) {
                        item.element.html(item.originalHtml);
                    }
                });
                highlightedElements = [];
            }
            
            // Fungsi untuk escape regex
            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
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
            
            // Clear search saat input dikosongkan
            $('#searchInput').on('input', function() {
                if ($(this).val().trim() === '') {
                    clearHighlights();
                    searchResults.slideUp();
                }
            });
        });
    }
    
    // Start initialization
    initSearch();
})();

