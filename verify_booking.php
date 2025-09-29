<?php
require_once __DIR__ . '/init.php';

$booking_id = $_GET['booking_id'] ?? null;
if (empty($_SESSION['company_id']) || !$booking_id) {
    http_response_code(400);
    echo json_encode(['error' => 'invalid_request']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM verification_questions WHERE company_id = ?");
$stmt->execute([$_SESSION['company_id']]);
$questions = $stmt->fetchAll();

foreach ($questions as $question) {
    echo "<div>" . e($question['question']) . "</div>";
    if ($question['type'] == 'text') {
        echo "<input type='text' name='answers[{$question['id']}]'>";
    } elseif ($question['type'] == 'number') {
        echo "<input type='number' name='answers[{$question['id']}]'>";
    } elseif ($question['type'] == 'date') {
        echo "<input type='date' name='answers[{$question['id']}]'>";
    } elseif ($question['type'] == 'choice') {
        $options = json_decode($question['options']);
        if (is_array($options)) {
            foreach ($options as $option) {
                echo "<label><input type='radio' name='answers[{$question['id']}]' value='" . e($option) . "'> " . e($option) . "</label>";
            }
        }
    }
}

?>
