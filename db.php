<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new PDO("mysql:host=localhost;dbname=ecommerce;charset=utf8", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
