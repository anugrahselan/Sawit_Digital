// Dropdown Menu Handler - Improved untuk mencegah dropdown hilang saat kursor berpindah
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(function(dropdown) {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        if (!toggle || !menu) return;
        
        let timeout;
        let isHovering = false;
        
        // Fungsi untuk menampilkan dropdown
        function showDropdown() {
            clearTimeout(timeout);
            isHovering = true;
            menu.style.display = 'block';
            menu.style.opacity = '1';
            menu.style.visibility = 'visible';
        }
        
        // Fungsi untuk menyembunyikan dropdown dengan delay
        function hideDropdown() {
            isHovering = false;
            timeout = setTimeout(function() {
                // Double check apakah masih hovering
                if (!isHovering) {
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                    setTimeout(function() {
                        if (!isHovering) {
                            menu.style.display = 'none';
                        }
                    }, 200);
                }
            }, 800); // Delay lebih lama (800ms) untuk memberikan waktu kursor berpindah
        }
        
        // Show dropdown saat hover pada dropdown container
        dropdown.addEventListener('mouseenter', function() {
            showDropdown();
        });
        
        // Hide dropdown saat mouse meninggalkan dropdown container
        dropdown.addEventListener('mouseleave', function(e) {
            // Cek apakah mouse masih di dalam dropdown atau menu
            const relatedTarget = e.relatedTarget;
            if (relatedTarget) {
                // Cek apakah masih di dalam area dropdown (termasuk area gap dan menu)
                if (dropdown.contains(relatedTarget) || menu.contains(relatedTarget)) {
                    return; // Masih di dalam area dropdown, jangan hide
                }
            }
            hideDropdown();
        });
        
        // Keep dropdown open saat hovering over menu
        menu.addEventListener('mouseenter', function() {
            showDropdown();
        });
        
        // Hide dropdown saat mouse meninggalkan menu
        menu.addEventListener('mouseleave', function(e) {
            const relatedTarget = e.relatedTarget;
            if (relatedTarget) {
                // Cek apakah masih di dalam area dropdown
                if (dropdown.contains(relatedTarget) || menu.contains(relatedTarget)) {
                    return; // Masih di dalam area dropdown, jangan hide
                }
            }
            hideDropdown();
        });
        
        // Tambahkan event listener untuk menangkap semua mouse movement di area dropdown
        // Ini membantu menangkap area gap
        dropdown.addEventListener('mousemove', function() {
            if (!isHovering) {
                showDropdown();
            }
        });
        
        menu.addEventListener('mousemove', function() {
            showDropdown();
        });
    });
});

