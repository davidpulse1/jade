<?php

// save_dates.php
session_start();
$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$start_date = $data['start'];
$end_date = $data['end'];

// Save dates to database
$stmt = $pdo->prepare("INSERT INTO bookings (user_id, start_date, end_date, status) VALUES (?, ?, ?, 'pending')");
$stmt->execute([$user_id, $start_date, $end_date]);

// company_dashboard.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status']; // 'accepted' or 'rejected'

    // Update booking status
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->execute([$status, $booking_id]);

    // Notify user
    $booking = $stmt->fetch();
    $message = $status == 'accepted' ? "Your booking has been accepted." : "Your booking has been rejected.";
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['company_id'], $booking['user_id'], $message]);
}
