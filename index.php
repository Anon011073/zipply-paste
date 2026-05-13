<?php

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die("<h1>Swiffy Code: Dependencies Missing</h1><p>Please ensure the <code>vendor/</code> directory is present in the root directory.</p>");
}

require_once __DIR__ . '/vendor/autoload.php';

// Session management
session_start();

// Security headers
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https://www.gravatar.com https://secure.gravatar.com; worker-src 'self' blob:;");

// Basic CSRF Protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !\App\Helpers\Security::verifyCsrf($_POST['csrf_token'])) {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = \App\Core\Router::getBase();
        $path = ($base !== '' && strpos($uri, $base) === 0) ? substr($uri, strlen($base)) : $uri;

        if ($path !== '/install') {
             die("CSRF token validation failed.");
        }
    }
}
\App\Helpers\Security::csrfToken();

$router = new \App\Core\Router();

// Define routes
$router->add('GET', '/', [\App\Controllers\HomeController::class, 'index']);
$router->add('GET', '/install', [\App\Controllers\InstallController::class, 'index']);
$router->add('POST', '/install', [\App\Controllers\InstallController::class, 'run']);

// Auth routes
$router->add('GET', '/login', [\App\Controllers\AuthController::class, 'login']);
$router->add('POST', '/login', [\App\Controllers\AuthController::class, 'postLogin']);
$router->add('GET', '/register', [\App\Controllers\AuthController::class, 'register']);
$router->add('POST', '/register', [\App\Controllers\AuthController::class, 'postRegister']);
$router->add('GET', '/logout', [\App\Controllers\AuthController::class, 'logout']);
$router->add('GET', '/forgot-password', [\App\Controllers\AuthController::class, 'forgotPassword']);
$router->add('POST', '/forgot-password', [\App\Controllers\AuthController::class, 'postForgotPassword']);
$router->add('GET', '/reset-password', [\App\Controllers\AuthController::class, 'resetPassword']);
$router->add('POST', '/reset-password', [\App\Controllers\AuthController::class, 'postResetPassword']);

// User routes
$router->add('GET', '/dashboard', [\App\Controllers\DashboardController::class, 'index']);
$router->add('POST', '/api/keys', [\App\Controllers\DashboardController::class, 'createApiKey']);
$router->add('GET', '/profile/edit', [\App\Controllers\UserController::class, 'edit']);
$router->add('POST', '/profile/edit', [\App\Controllers\UserController::class, 'update']);
$router->add('POST', '/profile/password', [\App\Controllers\UserController::class, 'updatePassword']);
$router->add('POST', '/profile/delete', [\App\Controllers\UserController::class, 'deleteAccount']);
$router->add('GET', '/user/pastes', [\App\Controllers\UserController::class, 'pastes']);

// Paste routes
$router->add('GET', '/paste/new', [\App\Controllers\PasteController::class, 'create']);
$router->add('POST', '/paste/new', [\App\Controllers\PasteController::class, 'store']);
$router->add('GET', '/v/{slug}', [\App\Controllers\PasteController::class, 'show']);
$router->add('POST', '/v/{slug}/unlock', [\App\Controllers\PasteController::class, 'unlock']);
$router->add('GET', '/v/{slug}/edit', [\App\Controllers\PasteController::class, 'edit']);
$router->add('POST', '/v/{slug}/edit', [\App\Controllers\PasteController::class, 'update']);
$router->add('POST', '/v/{slug}/delete', [\App\Controllers\PasteController::class, 'delete']);
$router->add('GET', '/raw/{slug}', [\App\Controllers\PasteController::class, 'raw']);
$router->add('GET', '/download/{slug}', [\App\Controllers\PasteController::class, 'download']);
$router->add('GET', '/clone/{slug}', [\App\Controllers\PasteController::class, 'clone']);

// User Profile routes
$router->add('GET', '/u/{username}', [\App\Controllers\UserController::class, 'profile']);

// Search routes
$router->add('GET', '/search', [\App\Controllers\SearchController::class, 'index']);

// Admin routes
$router->add('GET', '/admin', [\App\Controllers\AdminController::class, 'index']);
$router->add('GET', '/admin/users', [\App\Controllers\AdminController::class, 'users']);
$router->add('POST', '/admin/users/delete/{id}', [\App\Controllers\AdminController::class, 'deleteUser']);
$router->add('GET', '/admin/settings', [\App\Controllers\AdminController::class, 'settings']);
$router->add('POST', '/admin/settings', [\App\Controllers\AdminController::class, 'saveSettings']);

// Dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
