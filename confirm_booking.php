<?php

// confirm_booking.php
session_start();
$booking_id = $_POST['booking_id'];
$details = json_encode($_POST['details']);

$stmt = $pdo->prepare("UPDATE bookings SET details = ? WHERE id = ?");
$stmt->execute([$details, $booking_id]);
