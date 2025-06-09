document.addEventListener('DOMContentLoaded', function() {
    // Role selection functionality
    const roleButtons = document.querySelectorAll('.role-btn');
    const loginForm = document.querySelector('.login-form');
    const selectedRoleInput = document.getElementById('selectedRole');

    roleButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            roleButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedRoleInput.value = btn.getAttribute('data-role');
            btn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btn.style.transform = 'scale(1)';
            }, 100);
        });
    });

    // Form submission with loading animation
    loginForm.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('.login-btn');
        const btnText = submitBtn.querySelector('.btn-text');
        const loading = submitBtn.querySelector('.loading');
        
        btnText.style.opacity = '0';
        loading.style.display = 'block';
        submitBtn.style.pointerEvents = 'none';
        
        setTimeout(() => {
            btnText.style.opacity = '1';
            loading.style.display = 'none';
            submitBtn.style.pointerEvents = 'auto';
        }, 2000);
    });

    // Input field animations
    const inputFields = document.querySelectorAll('.input-field');
    inputFields.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });

    // Add floating animation to login container
    const loginContainer = document.querySelector('.login-container');
    setInterval(() => {
        loginContainer.style.transform = 'translateY(-2px)';
        setTimeout(() => {
            loginContainer.style.transform = 'translateY(0)';
        }, 2000);
    }, 4000);

    // Smooth scroll for navigation links
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                    inline: 'nearest'
                });
                this.style.transform = 'translateY(-3px) scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-3px) scale(1.05)';
                }, 150);
            } else {
                showNotification(`Navigasi ke ${this.textContent}`, 'info');
            }
        });
    });

    // Notification system for navigation
    function showNotification(message, type = 'info') {
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class='bx ${type === 'info' ? 'bx-info-circle' : 'bx-check-circle'}'></i>
                <span>${message}</span>
            </div>
        `;
        Object.assign(notification.style, {
            position: 'fixed',
            top: '100px',
            right: '20px',
            background: 'rgba(255, 255, 255, 0.95)',
            backdropFilter: 'blur(20px)',
            padding: '1rem 1.5rem',
            borderRadius: '12px',
            boxShadow: '0 8px 32px rgba(0, 0, 0, 0.1)',
            color: '#1e293b',
            fontWeight: '500',
            fontSize: '0.9rem',
            zIndex: '1000',
            transform: 'translateX(100%)',
            transition: 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)',
            border: '1px solid rgba(255, 255, 255, 0.2)'
        });
        const content = notification.querySelector('.notification-content');
        Object.assign(content.style, {
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem'
        });
        const icon = notification.querySelector('i');
        Object.assign(icon.style, {
            color: type === 'info' ? '#6366f1' : '#22c55e',
            fontSize: '1.2rem'
        });
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 400);
        }, 3000);
    }

    // Add scroll spy functionality (highlight active nav link)
    function addScrollSpy() {
        const sections = ['home', 'about', 'vision', 'contact'];
        const navLinks = document.querySelectorAll('.nav-links a');
        function updateActiveLink() {
            let current = '';
            sections.forEach(sectionId => {
                const section = document.getElementById(sectionId);
                if (section) {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    if (window.scrollY >= sectionTop - 100) {
                        current = sectionId;
                    }
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('active-nav');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active-nav');
                }
            });
        }
        window.addEventListener('scroll', updateActiveLink);
    }
    addScrollSpy();
});