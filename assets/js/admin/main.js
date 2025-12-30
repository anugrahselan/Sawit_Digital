// Admin Dashboard Main JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    // Restore sidebar state first
    if (sidebar && localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }
    
    // Initialize toggle icon based on current state
    if (sidebarToggle && sidebar) {
        const icon = sidebarToggle.querySelector('i');
        
        function updateIcon() {
            if (icon) {
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'bi bi-list';
                } else {
                    icon.className = 'bi bi-x-lg';
                }
            }
        }
        
        // Set initial icon
        updateIcon();
        
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            
            // Update icon
            updateIcon();
        });
    }
    
    // Close sidebar on mobile when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && sidebar) {
            if (!sidebar.contains(e.target) && sidebarToggle && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
    
    // Auto-dismiss alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    
    // Confirm delete actions
    document.querySelectorAll('[data-confirm-delete]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
    
    // Admin Search - Pencarian di halaman yang sama
    initAdminSearch();
});

// Admin Search Functionality
function initAdminSearch() {
    if (typeof jQuery === 'undefined') {
        setTimeout(initAdminSearch, 100);
        return;
    }
    
    jQuery(document).ready(function($) {
        var searchResults = $('#adminSearchResults');
        var searchResultsContent = $('#adminSearchResultsContent');
        var highlightedElements = [];
        
        // Handle search form
        $('#adminSearchForm').on('submit', function(e) {
            e.preventDefault();
            
            var keyword = $('#adminSearchInput').val().trim();
            
            if (!keyword) {
                clearHighlights();
                searchResults.slideUp();
                return false;
            }
            
            // Cari di halaman yang sama (hanya di admin-content)
            searchInPage(keyword);
        });
        
        function searchInPage(keyword) {
            // Hapus highlight sebelumnya
            clearHighlights();
            
            var found = false;
            var results = [];
            var regex = new RegExp('(' + escapeRegExp(keyword) + ')', 'gi');
            
            // Cari hanya di dalam admin-content, hindari sidebar dan header
            var $contentArea = $('.admin-content');
            if ($contentArea.length === 0) {
                return;
            }
            
            // Cari di elemen yang bisa dicari (hindari script, style, dll)
            var searchableSelectors = 'p, span, div, h1, h2, h3, h4, h5, h6, li, td, th, a, label, strong, em, b, i, .card-title, .card-text';
            
            $contentArea.find(searchableSelectors).not('script, style, noscript, .search-highlight, #adminSearchResults, #adminSearchResults *').each(function() {
                var $element = $(this);
                
                // Skip jika sudah di-highlight atau di dalam elemen yang di-highlight
                if ($element.closest('.search-highlight').length > 0 || $element.hasClass('search-highlight')) {
                    return;
                }
                
                // Skip jika di dalam search results
                if ($element.closest('#adminSearchResults').length > 0) {
                    return;
                }
                
                // Ambil teks dari elemen ini saja (bukan dari child)
                var text = $element.clone().children().remove().end().text();
                
                if (text && text.trim().length > 0 && regex.test(text)) {
                    found = true;
                    
                    // Simpan HTML asli
                    var originalHtml = $element.html();
                    
                    // Highlight teks
                    var highlightedText = text.replace(regex, '<mark class="search-highlight" style="background-color: #ffeb3b; padding: 2px 4px; border-radius: 3px;">$1</mark>');
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
                    '<i class="bi bi-check-circle"></i> Ditemukan <strong>' + count + '</strong> hasil untuk "<strong>' + escapeHtml(keyword) + '</strong>"'
                );
                searchResults.removeClass('alert-danger').addClass('alert-info').slideDown();
                
                // Scroll ke hasil pertama
                if (results.length > 0) {
                    setTimeout(function() {
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
        $('#adminSearchInput').on('input', function() {
            if ($(this).val().trim() === '') {
                clearHighlights();
                searchResults.slideUp();
            }
        });
        
        // Clear search dengan ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#adminSearchInput').is(':focus')) {
                $('#adminSearchInput').val('');
                clearHighlights();
                searchResults.slideUp();
            }
        });
    });
}






