<?php
require_once __DIR__ . '/init.php';

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(400);
	echo json_encode(['error' => 'invalid_request']);
	exit;
}

$user_id = $_SESSION['user_id'];
$profile = $_POST['profile'] ?? '';

$stmt = $pdo->prepare("UPDATE users SET profile = ? WHERE id = ?");
$stmt->execute([$profile, $user_id]);

echo json_encode(['success' => true]);
