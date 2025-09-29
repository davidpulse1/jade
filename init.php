<?php
// init.php - include at top of every PHP page to initialize session and DB
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load DB connection
require_once __DIR__ . '/db.php';

// Simple helper to check login
function require_user() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function require_company() {
    if (empty($_SESSION['company_id'])) {
        header('Location: login.php');
        exit;
    }
}

// Basic input sanitize helper
function e($v) {
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

?>
