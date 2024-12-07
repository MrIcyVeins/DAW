<form method="POST" action="../controllers/auth.php">
    <input type="hidden" name="action" value="login">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
