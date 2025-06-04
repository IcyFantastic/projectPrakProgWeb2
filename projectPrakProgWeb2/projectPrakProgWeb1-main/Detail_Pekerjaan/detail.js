document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Apply button loading state
    const applyBtn = document.querySelector('.apply-btn');
    if (applyBtn) {
        applyBtn.addEventListener('click', function(e) {
            const btn = e.target;
            btn.disabled = true;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="loading"></span>Processing...';
            
            setTimeout(() => {
                const url = btn.getAttribute('data-href') || btn.getAttribute('onclick').replace("window.location.href='", "").replace("'", "");
                window.location.href = url;
            }, 500);
        });
    }

    // Back button handling
    const backBtn = document.querySelector('.back-btn');
    if (backBtn) {
        backBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.history.back();
        });
    }

    // Error handling
    window.addEventListener('error', function(e) {
        console.error('Page Error:', e.error);
        alert('Terjadi kesalahan. Silakan coba lagi nanti.');
    });
});