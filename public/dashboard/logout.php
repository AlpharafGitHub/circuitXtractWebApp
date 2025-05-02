<?php
// logout.php

// 1) Expire the cookie by setting its timestamp in the past
setcookie('user', '', [
    'expires' => time() - 3600,
    'path' => '/',
    'secure' => true, // Ensure the cookie is only sent over HTTPS
    'httponly' => true, // Prevent JavaScript access to the cookie
    'samesite' => 'Strict' // Prevent cross-site request forgery
]);

// 2) (Optional) Unset the cookie from PHP’s superglobal
unset($_COOKIE['user']);

// 3) Redirect back to the landing page (or login page)
header('Location: \CircuitXtract\public\index.php');
exit;