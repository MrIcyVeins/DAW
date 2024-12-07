<form method="POST" action="../controllers/auth.php" id="registerForm">
    <input type="hidden" name="action" value="register">

    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <p id="password-strength" style="color: red;"></p>

    <label for="role">Role:</label>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit">Register</button>
</form>

<script>
    const passwordInput = document.getElementById('password');
    const strengthIndicator = document.getElementById('password-strength');

    passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;

        let strengthMessage = "";
        let strengthColor = "red";

        if (password.length < 8) {
            strengthMessage = "Password must be at least 8 characters.";
        } else if (!/[A-Z]/.test(password)) {
            strengthMessage = "Password must include an uppercase letter.";
            strengthColor = "orange";
        } else if (!/[0-9]/.test(password)) {
            strengthMessage = "Password must include a number.";
            strengthColor = "orange";
        } else if (!/[\W_]/.test(password)) {
            strengthMessage = "Password must include a special character.";
            strengthColor = "orange";
        } else {
            strengthMessage = "Strong password.";
            strengthColor = "green";
        }

        strengthIndicator.textContent = strengthMessage;
        strengthIndicator.style.color = strengthColor;
    });

    document.getElementById('registerForm').addEventListener('submit', function (e) {
        if (strengthIndicator.style.color !== "green") {
            e.preventDefault();
            alert("Please use a stronger password.");
        }
    });
</script>
