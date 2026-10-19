<?php
declare(strict_types=1);
define('ROOT', dirname(__DIR__));
ini_set('display_errors', '0');
error_reporting(E_ALL);
date_default_timezone_set('UTC');
require ROOT.'/config/app.php';
$https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
session_name('tripora_session');
session_set_cookie_params(['httponly' => true, 'secure' => $https, 'samesite' => 'Lax', 'path' => '/']);
session_start();
require ROOT.'/includes/i18n.php';
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self'; script-src 'self'; form-action 'self'; frame-ancestors 'none'; base-uri 'self'");
require ROOT . '/includes/functions.php';
require ROOT . '/includes/booking.php';
require ROOT.'/includes/mailer.php';
require ROOT.'/includes/chat.php';
require ROOT.'/includes/account.php';
require ROOT.'/includes/otp.php';
require ROOT.'/includes/gallery.php';
try {
    require ROOT.'/config/database.php';
} catch (Throwable $e) {
    http_response_code(503);
    echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title>Set up Tripora</title><link rel="stylesheet" href="' . e(asset('public/style.css')) . '"><body><main class="wrap section"><a class="brand" href="' . e(url()) . '">◎ tripora.</a><h1>Let’s get Tripora ready.</h1><p>Create the <strong>tripora</strong> database, import <strong>database/tripora.sql</strong>, then copy <strong>.env.example</strong> to <strong>.env</strong> and set your database connection.</p><p>Follow README_MM.md in the project folder. Then reload this page.</p></main></body></html>';
    exit;
}
$user = !empty($_SESSION['user_id']) ? one('SELECT * FROM users WHERE id=? AND active=1', [$_SESSION['user_id']]) : null;
if ($user && (int)($_SESSION['auth_version'] ?? -1) !== (int)$user['auth_version']) $user = null;
if (!$user) unset($_SESSION['user_id']);
