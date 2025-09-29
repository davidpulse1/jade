<?php
require_once __DIR__ . '/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo json_encode(['error' => 'method_not_allowed']);
	exit;
}

$booking_id = $_POST['booking_id'] ?? null;
$details = $_POST['details'] ?? null;

if (!$booking_id) {
	http_response_code(400);
	echo json_encode(['error' => 'missing_booking_id']);
	exit;
}

$details_json = json_encode($details);
$stmt = $pdo->prepare("UPDATE bookings SET details = ? WHERE id = ?");
$stmt->execute([$details_json, $booking_id]);

echo json_encode(['success' => true]);
