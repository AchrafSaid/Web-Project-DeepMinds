document.getElementById('signinForm').addEventListener('submit', function (event) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!validateEmail(email)) {
        alert('Please enter a valid email address.');
        event.preventDefault(); 
        return;
    }

    if (password === '') {
        alert('Please enter your password.');
        event.preventDefault(); 
        return;
    }
});

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

// Password visibility toggle
const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('password');

togglePassword.addEventListener('click', function () {
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    this.textContent = type === 'password' ? '👁️' : '🙈';
});
