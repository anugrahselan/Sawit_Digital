// Riwayat Kalkulasi JavaScript - Hybrid Table + Card
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById('tab-' + targetTab).classList.add('active');
        });
    });
    
    // Expand/Collapse functionality
    const expandButtons = document.querySelectorAll('.expand-btn');
    
    expandButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent row click
            
            const targetId = this.getAttribute('data-target');
            const detailRow = document.getElementById(targetId);
            
            if (!detailRow) return;
            
            // Toggle expanded state
            const isExpanded = detailRow.classList.contains('expanded');
            
            if (isExpanded) {
                // Collapse
                detailRow.classList.remove('expanded');
                this.classList.remove('expanded');
            } else {
                // Expand
                detailRow.classList.add('expanded');
                this.classList.add('expanded');
            }
        });
    });
    
    // Row click to expand (optional - uncomment if needed)
    // const riwayatRows = document.querySelectorAll('.riwayat-row');
    // riwayatRows.forEach(row => {
    //     row.addEventListener('click', function(e) {
    //         // Don't trigger if clicking on button or link
    //         if (e.target.closest('button') || e.target.closest('a')) {
    //             return;
    //         }
    //         
    //         const expandBtn = this.querySelector('.expand-btn');
    //         if (expandBtn) {
    //             expandBtn.click();
    //         }
    //     });
    // });
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Search functionality for Panen tab
    const searchInputPanen = document.getElementById('searchInputPanen');
    const searchBtnPanen = document.getElementById('searchBtnPanen');
    
    function performSearchPanen() {
        const keyword = searchInputPanen ? searchInputPanen.value.toLowerCase().trim() : '';
        const rows = document.querySelectorAll('#tab-panen tbody tr.riwayat-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (keyword === '' || rowText.includes(keyword)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
                const rowId = row.getAttribute('data-id');
                if (rowId) {
                    const detailRow = document.getElementById('detail-panen-' + rowId);
                    if (detailRow) {
                        detailRow.style.display = 'none';
                        detailRow.classList.remove('expanded');
                        const expandBtn = row.querySelector('.expand-btn');
                        if (expandBtn) {
                            expandBtn.classList.remove('expanded');
                        }
                    }
                }
            }
        });
        
        // Show/hide no results message
        let noResults = document.getElementById('no-results-panen');
        if (keyword !== '' && visibleCount === 0) {
            if (!noResults) {
                const tbody = document.querySelector('#tab-panen tbody');
                if (tbody) {
                    const tr = document.createElement('tr');
                    tr.id = 'no-results-panen';
                    tr.innerHTML = '<td colspan="8" class="text-center py-4"><p class="text-muted mb-0">Tidak ada hasil ditemukan</p></td>';
                    tbody.appendChild(tr);
                }
            }
        } else {
            if (noResults) {
                noResults.remove();
            }
        }
    }
    
    if (searchBtnPanen) {
        searchBtnPanen.addEventListener('click', performSearchPanen);
    }
    
    if (searchInputPanen) {
        searchInputPanen.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearchPanen();
            }
        });
    }
    
    // Search functionality for Pupuk tab
    const searchInputPupuk = document.getElementById('searchInputPupuk');
    const searchBtnPupuk = document.getElementById('searchBtnPupuk');
    
    function performSearchPupuk() {
        const keyword = searchInputPupuk ? searchInputPupuk.value.toLowerCase().trim() : '';
        const rows = document.querySelectorAll('#tab-pupuk tbody tr.riwayat-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (keyword === '' || rowText.includes(keyword)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
                const rowId = row.getAttribute('data-id');
                if (rowId) {
                    const detailRow = document.getElementById('detail-pupuk-' + rowId);
                    if (detailRow) {
                        detailRow.style.display = 'none';
                        detailRow.classList.remove('expanded');
                        const expandBtn = row.querySelector('.expand-btn');
                        if (expandBtn) {
                            expandBtn.classList.remove('expanded');
                        }
                    }
                }
            }
        });
        
        // Show/hide no results message
        let noResults = document.getElementById('no-results-pupuk');
        if (keyword !== '' && visibleCount === 0) {
            if (!noResults) {
                const tbody = document.querySelector('#tab-pupuk tbody');
                if (tbody) {
                    const tr = document.createElement('tr');
                    tr.id = 'no-results-pupuk';
                    tr.innerHTML = '<td colspan="8" class="text-center py-4"><p class="text-muted mb-0">Tidak ada hasil ditemukan</p></td>';
                    tbody.appendChild(tr);
                }
            }
        } else {
            if (noResults) {
                noResults.remove();
            }
        }
    }
    
    if (searchBtnPupuk) {
        searchBtnPupuk.addEventListener('click', performSearchPupuk);
    }
    
    if (searchInputPupuk) {
        searchInputPupuk.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearchPupuk();
            }
        });
    }
});
