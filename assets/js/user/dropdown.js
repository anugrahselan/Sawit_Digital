document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(function(dropdown) {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        if (!toggle || !menu) return;
        
        if (!dropdown.classList.contains('dropdown')) return;
        
        let timeout;
        let isHovering = false;
        
        function showDropdown() {
            clearTimeout(timeout);
            isHovering = true;
            menu.style.display = 'block';
            menu.style.opacity = '1';
            menu.style.visibility = 'visible';
        }
        
        function hideDropdown() {
            isHovering = false;
            timeout = setTimeout(function() {
                if (!isHovering) {
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                    setTimeout(function() {
                        if (!isHovering) {
                            menu.style.display = 'none';
                        }
                    }, 200);
                }
            }, 800);
        }
        
        toggle.addEventListener('mouseenter', function(e) {
            e.stopPropagation();
            showDropdown();
        });
        
        dropdown.addEventListener('mouseenter', function(e) {
            if (e.target === dropdown || e.target === toggle || toggle.contains(e.target)) {
                showDropdown();
            }
        });
        
        dropdown.addEventListener('mouseleave', function(e) {
            const relatedTarget = e.relatedTarget;
            if (relatedTarget) {
                if (dropdown.contains(relatedTarget) || menu.contains(relatedTarget)) {
                    return;
                }
            }
            hideDropdown();
        });
        
        menu.addEventListener('mouseenter', function() {
            showDropdown();
        });
        
        menu.addEventListener('mouseleave', function(e) {
            const relatedTarget = e.relatedTarget;
            if (relatedTarget) {
                if (dropdown.contains(relatedTarget) || menu.contains(relatedTarget)) {
                    return;
                }
            }
            hideDropdown();
        });
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (menu.style.display === 'none' || menu.style.display === '') {
                showDropdown();
            } else {
                hideDropdown();
            }
        });
        
        document.addEventListener('click', function(e) {
            const clickedElement = e.target;
            if (!dropdown.contains(clickedElement)) {
                hideDropdown();
            }
            const navbarItem = clickedElement.closest('.navbar-menu > li');
            if (navbarItem && !navbarItem.classList.contains('dropdown')) {
                hideDropdown();
            }
        });
    });
});
