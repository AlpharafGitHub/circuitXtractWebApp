<?php
require __DIR__ . '/config/config.php';

// Check if the user is logged in
if (isset($_COOKIE['user'])) {
    // Redirect to the dashboard if logged in
    header('Location: /dashboard');
    exit;
}

// Serve the static landing page
$landingPagePath = __DIR__ . '/public/index.php';

if (file_exists($landingPagePath)) {
    readfile($landingPagePath);
} else {
    // Display an error if the landing page is missing
    http_response_code(404);
    echo "Landing page not found.";
}