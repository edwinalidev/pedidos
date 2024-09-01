<?php
$serverName = 'localhost';
$dbname     = 'pedidos';
$username   = 'root';
$password   = '';
try {
 $pdo = new PDO("mysql:host=$serverName;dbname=$dbname", $username, $password);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
 die("Database connection failed: " . $e->getMessage());
}
?>
