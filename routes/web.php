<?php

use App\Controllers\AdminDashboardController;
use App\Controllers\AnalyticsController;

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/dashboard') {
    require __DIR__ . '/../app/Controllers/admin_dashboard.php';
} elseif ($requestUri === '/analytics') {
    require __DIR__ . '/../app/Controllers/analytics.php';
} elseif ($requestUri === '/') {
    require __DIR__ . '/../public/index.php';
} else {
    http_response_code(404);
    echo "Page not found.";
}