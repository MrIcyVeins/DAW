<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Creare conexiune
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>