<?php
require_once __DIR__ . '/init.php';

// save_dates.php: accepts JSON {start,end} from frontend and creates a pending booking
$data = json_decode(file_get_contents('php://input'), true);
if (empty($_SESSION['user_id']) || !$data) {
    http_response_code(400);
    echo json_encode(['error' => 'invalid_request']);
    exit;
}

$user_id = $_SESSION['user_id'];
$start_date = $data['start'] ?? null;
$end_date = $data['end'] ?? null;

if (!$start_date || !$end_date) {
    http_response_code(400);
    echo json_encode(['error' => 'missing_dates']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO bookings (user_id, start_date, end_date, status) VALUES (?, ?, ?, 'pending')");
$stmt->execute([$user_id, $start_date, $end_date]);

echo json_encode(['success' => true, 'booking_id' => $pdo->lastInsertId()]);
