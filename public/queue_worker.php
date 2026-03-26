<?php

// queue_worker.php - Web-accessible script for processing queues on shared hosting
// Place this file in your public_html or web root directory

require_once __DIR__ . '/../application/bootstrap/app.php';

$app = require_once __DIR__ . '/../application/bootstrap/app.php';

// Check for a simple authentication token (optional but recommended)
$authToken = $_GET['token'] ?? '';
$expectedToken = env('QUEUE_WEB_TOKEN', 'your-secret-token-change-this');

if ($authToken !== $expectedToken) {
    http_response_code(403);
    echo "Access denied";
    exit;
}

try {
    // Process up to 5 queue jobs
    $exitCode = \Illuminate\Support\Facades\Artisan::call('queue:run-worker', [
        '--max-jobs' => 5,
        '--sleep' => 10,
    ]);

    echo "Queue processing completed. Exit code: " . $exitCode;
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}