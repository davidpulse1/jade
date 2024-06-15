<?php

session_start();
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM messages WHERE sender_id = ?");
$stmt->execute([$user_id]);
$messages = $stmt->fetchAll();

foreach ($messages as $message) {
    echo "<div class='message'>{$message['message']}</div>";
}
?>
