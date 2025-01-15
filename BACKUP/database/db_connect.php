<?php
$servername = "sql311.iceiy.com";
$username = "icei_37863787";
$password = "caKDl8ugbPr0";
$dbname = "icei_37863787_prod";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>