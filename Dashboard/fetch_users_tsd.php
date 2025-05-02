<?php
// Dashboard/fetch_users.php
require __DIR__ . '/../config.php';
header('Content-Type: application/json');

// Adjust the table & column names here to match your schema.
// I’m assuming your users table is named `users` and has columns `id` and `name`.
$stmt = $pdo->query("SELECT id, name FROM users_tsd ORDER BY name");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
