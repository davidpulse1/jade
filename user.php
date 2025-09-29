<?php
require_once __DIR__ . '/init.php';

// Simple endpoint to get current user info (returns JSON)
if (empty($_SESSION['user_id'])) {
	http_response_code(401);
	echo json_encode(['error' => 'not_logged_in']);
	exit;
}

$stmt = $pdo->prepare('SELECT id, username, email, profile FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
	http_response_code(404);
	echo json_encode(['error' => 'user_not_found']);
	exit;
}

header('Content-Type: application/json');
echo json_encode($user);

?>
