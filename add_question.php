
<?php
require_once __DIR__ . '/init.php';

if (empty($_SESSION['company_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'not_authorized']);
    exit;
}

$company_id = $_SESSION['company_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question'] ?? '');
    $type = $_POST['type'] ?? 'text';
    $options_raw = $_POST['options'] ?? '';

    // options may be provided as JSON string or newline-separated values
    $options = null;
    $decoded = json_decode($options_raw, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $options = $decoded;
    } else {
        // try splitting lines
        $lines = array_filter(array_map('trim', explode("\n", $options_raw)));
        $options = array_values($lines);
    }

    $stmt = $pdo->prepare("INSERT INTO verification_questions (company_id, question, type, options) VALUES (?, ?, ?, ?)");
    $stmt->execute([$company_id, $question, $type, json_encode($options)]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    exit;
}

// GET: list questions for company
$stmt = $pdo->prepare("SELECT * FROM verification_questions WHERE company_id = ?");
$stmt->execute([$company_id]);
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
