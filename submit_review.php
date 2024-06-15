<?php

// submit_review.php
$booking_id = $_POST['booking_id'];
$user_id = $_POST['user_id'];
$company_id = $_POST['company_id'];
$rating = $_POST['rating'];
$review = $_POST['review'];

// Insert review into the database
$stmt = $pdo->prepare("INSERT INTO reviews (booking_id, user_id, company_id, rating, review) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$booking_id, $user_id, $company_id, $rating, $review]);

echo "Review submitted successfully.";
