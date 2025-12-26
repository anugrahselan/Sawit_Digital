// Search JavaScript
$(document).ready(function() {
    // Handle search form with AJAX
    $('#searchForm').on('submit', function(e) {
        var keyword = $('#searchInput').val().trim();
        
        if (!keyword) {
            e.preventDefault();
            alert('Mohon masukkan kata kunci pencarian!');
            return false;
        }
        
        // For now, use normal form submission
        // Can be enhanced with AJAX modal display
    });
    
    // Auto-complete or suggestions can be added here
});

// baseUrl sudah diset di footer.php

