<?php
// index.php
require __DIR__ . '/config.php';

// If logged in, go to the dashboard
if (isset($_COOKIE['user'])) {
    header('Location: Dashboard/index.php');
    exit;
}

// Otherwise serve the static landing page
readfile(__DIR__ . '/landing_page.html');
