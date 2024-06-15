<?php

// update_profile.php
session_start();
$user_id = $_SESSION['user_id'];
$profile = $_POST['profile'];

// Update the profile in the database
$stmt = $pdo->prepare("UPDATE users SET profile = ? WHERE id = ?");
$stmt->execute([$profile, $user_id]);

echo "Profile updated successfully.";
