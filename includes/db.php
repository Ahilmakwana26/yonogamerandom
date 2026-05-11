<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password
$db   = 'yonogame_random';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    if ($e->getCode() == 2054 || strpos($e->getMessage(), 'authentication method unknown') !== false) {
        die("Database Connection Error: Your MySQL server is using a newer authentication method. Please run this command in your SQL console: <br><code>ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';</code>");
    }
    die("Connection failed: " . $e->getMessage());
}
?>
