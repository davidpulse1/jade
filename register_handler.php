<?php
require_once __DIR__ . '/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$role = isset($_POST['role']) ? $_POST['role'] : 'user';

if ($username === '' || $email === '' || $password === '') {
    header('Location: register.php?error=missing');
    exit;
}

$hashed = password_hash($password, PASSWORD_BCRYPT);

if ($role === 'company') {
    $stmt = $pdo->prepare('INSERT INTO companies (name, email, password) VALUES (?, ?, ?)');
    $stmt->execute([$username, $email, $hashed]);
    $_SESSION['company_id'] = $pdo->lastInsertId();
    $_SESSION['role'] = 'company';
    header('Location: company_dashboard.php');
    exit;
} else {
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->execute([$username, $email, $hashed]);
    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['role'] = 'user';
    header('Location: user_dashboard.php');
    exit;
}
