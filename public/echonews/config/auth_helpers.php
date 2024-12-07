<?php
function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: /views/login.php");
    }
}

function redirectIfNotAdmin() {
    if (!isAdmin()) {
        header("Location: /views/user_dashboard.php");
    }
}
?>
