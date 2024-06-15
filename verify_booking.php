<?php
$booking_id = $_GET['booking_id'];
$stmt = $pdo->prepare("SELECT * FROM verification_questions WHERE company_id = ?");
$stmt->execute([$_SESSION['company_id']]);
$questions = $stmt->fetchAll();

foreach ($questions as $question) {
    echo "<div>{$question['question']}</div>";
    if ($question['type'] == 'text') {
        echo "<input type='text' name='answers[{$question['id']}]'>";
    } elseif ($question['type'] == 'number') {
        echo "<input type='number' name='answers[{$question['id']}]'>";
    } elseif ($question['type'] == 'date') {
        echo "<input type='date' name='answers[{$question['id']}]'>";
    } elseif ($question['type'] == 'choice') {
        $options = json_decode($question['options']);
        foreach ($options as $option) {
            echo "<input type='radio' name='answers[{$question['id']}]' value='{$option}'> {$option}";
        }
    }
}
?>
