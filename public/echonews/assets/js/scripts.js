document.addEventListener('DOMContentLoaded', () => {
    console.log("JavaScript Loaded!");
});

document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.querySelector('input[name="password"]');
    const strengthIndicator = document.getElementById('password-strength');

    if (passwordInput && strengthIndicator) {
        passwordInput.addEventListener('input', function () {
            const password = passwordInput.value;

            if (password.length < 8) {
                strengthIndicator.textContent = "Password must be at least 8 characters.";
                strengthIndicator.style.color = "red";
            } else if (!/[A-Z]/.test(password)) {
                strengthIndicator.textContent = "Password must include an uppercase letter.";
                strengthIndicator.style.color = "orange";
            } else if (!/[0-9]/.test(password)) {
                strengthIndicator.textContent = "Password must include a number.";
                strengthIndicator.style.color = "orange";
            } else if (!/[\W_]/.test(password)) {
                strengthIndicator.textContent = "Password must include a special character.";
                strengthIndicator.style.color = "orange";
            } else {
                strengthIndicator.textContent = "Strong password.";
                strengthIndicator.style.color = "green";
            }
        });
    }
});
