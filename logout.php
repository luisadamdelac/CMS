<?php
// Universal logout endpoint at project root - logs out any user regardless of where the request comes from
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Unset all of the session variables
$_SESSION = [];

// If there's a session cookie, delete it
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'], $params['secure'], $params['httponly']
    );
}

// Destroy the session
session_destroy();

// Redirect to public login or home page
$redirect = 'public/login.php';
if (file_exists(__DIR__ . '/public/index.php')) {
    // prefer index if login not present
    if (!file_exists(__DIR__ . '/public/login.php')) {
        $redirect = 'public/index.php';
    }
}

header('Location: ' . $redirect);
exit();
