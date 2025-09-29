<?php
require_once __DIR__ . '/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($email === '' || $password === '') {
    header('Location: login.php?error=missing');
    exit;
}

// Try users table first
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = 'user';
    header('Location: user_dashboard.php');
    exit;
}

// Try companies table
$stmt = $pdo->prepare('SELECT * FROM companies WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$company = $stmt->fetch();

if ($company && password_verify($password, $company['password'])) {
    $_SESSION['company_id'] = $company['id'];
    $_SESSION['role'] = 'company';
    header('Location: company_dashboard.php');
    exit;
}

header('Location: login.php?error=invalid');
exit;
