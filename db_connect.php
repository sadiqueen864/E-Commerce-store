<?php
$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "ecommerce_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("<div style='color:red; font-family:sans-serif;'>Database connection failed: " . $conn->connect_error . "</div>");
}
?>