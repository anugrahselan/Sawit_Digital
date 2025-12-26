// Dropdown Menu Handler - Improved untuk mencegah dropdown hilang saat kursor berpindah
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(function(dropdown) {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        // Pastikan hanya dropdown yang memiliki toggle dan menu
        if (!toggle || !menu) return;
        
        // Pastikan dropdown ini benar-benar memiliki class dropdown
        if (!dropdown.classList.contains('dropdown')) return;
        
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
        
        // Show dropdown saat hover pada dropdown toggle
        toggle.addEventListener('mouseenter', function(e) {
            e.stopPropagation();
            showDropdown();
        });
        
        // Juga trigger saat hover pada container dropdown (tapi pastikan bukan dari item navbar lain)
        dropdown.addEventListener('mouseenter', function(e) {
            // Hanya trigger jika hover langsung pada dropdown container atau toggle, bukan dari item navbar lain
            if (e.target === dropdown || e.target === toggle || toggle.contains(e.target)) {
                showDropdown();
            }
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
        
        // Pastikan hanya dropdown yang memiliki toggle yang bisa di-trigger
        // Jangan trigger dropdown dari item navbar lain
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (menu.style.display === 'none' || menu.style.display === '') {
                showDropdown();
            } else {
                hideDropdown();
            }
        });
        
        // Tutup dropdown saat klik di luar atau pada link navbar biasa (bukan dropdown)
        document.addEventListener('click', function(e) {
            const clickedElement = e.target;
            // Jika klik di luar dropdown, tutup
            if (!dropdown.contains(clickedElement)) {
                hideDropdown();
            }
            // Jika klik pada link navbar biasa (bukan dropdown toggle), tutup dropdown
            const navbarItem = clickedElement.closest('.navbar-menu > li');
            if (navbarItem && !navbarItem.classList.contains('dropdown')) {
                hideDropdown();
            }
        });
    });
});
