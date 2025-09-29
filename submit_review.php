<?php
require_once __DIR__ . '/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo json_encode(['error' => 'method_not_allowed']);
	exit;
}

$booking_id = $_POST['booking_id'] ?? null;
$user_id = $_POST['user_id'] ?? $_SESSION['user_id'] ?? null;
$company_id = $_POST['company_id'] ?? null;
$rating = intval($_POST['rating'] ?? 0);
$review = $_POST['review'] ?? '';

if (!$booking_id || !$user_id || !$company_id || $rating < 1 || $rating > 5) {
	http_response_code(400);
	echo json_encode(['error' => 'invalid_input']);
	exit;
}

$stmt = $pdo->prepare("INSERT INTO reviews (booking_id, user_id, company_id, rating, review) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$booking_id, $user_id, $company_id, $rating, $review]);

echo json_encode(['success' => true]);
