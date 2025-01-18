document.addEventListener('DOMContentLoaded', () => {
    // Sign Up Form Submission
    const signupForm = document.getElementById('signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('../api/signup.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, password })
            });

            const result = await response.json();
            if (result.success) {
                alert('Sign up successful! Redirecting to login...');
                window.location.href = 'login.php';
            } else {
                alert(result.message || 'Sign up failed!');
            }
        });
    }

    // Login Form Submission
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('../api/login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            const result = await response.json();
            if (result.success) {
                alert('Login successful! Redirecting to dashboard...');
                window.location.href = 'dashboard.php'; // Redirect to dashboard
            } else {
                alert(result.message || 'Login failed!');
            }
        });
    }
});
