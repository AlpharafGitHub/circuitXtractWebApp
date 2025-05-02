<?php
// config.php
$dsn     = "pgsql:host=localhost;port=5432;dbname=CircuitXtract;";
$db_user = "postgres";
$db_pass = "alpha@123";  // ← replace with your Postgres password

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
