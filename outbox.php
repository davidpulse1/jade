<?php
require_once __DIR__ . '/init.php';

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM messages WHERE sender_id = ? ORDER BY sent_at DESC");
$stmt->execute([$user_id]);
$messages = $stmt->fetchAll();

foreach ($messages as $message) {
    echo "<div class='message'>" . e($message['message']) . "</div>";
}
?>
