document.addEventListener('DOMContentLoaded', function() {
    // Role selection functionality
    const roleButtons = document.querySelectorAll('.role-btn');
    const loginForm = document.querySelector('.login-form');
    const selectedRoleInput = document.getElementById('selectedRole');

    roleButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            // Prevent default button behavior
            e.preventDefault();
            
            // Remove active class from all buttons
            roleButtons.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            btn.classList.add('active');
            
            // Update hidden input value with selected role
            selectedRoleInput.value = btn.getAttribute('data-role');
            
            // Add animation effect
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

    // Header active link
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-links a').forEach(link => {
        if(link.getAttribute('href') === currentPath.split('/').pop()) {
            link.classList.add('active');
        }
    });
});