<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Get current photo
$stmt = $conn->prepare("SELECT profile_photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data['profile_photo']) {
    $file = 'uploads/' . $data['profile_photo'];
    if (file_exists($file)) {
        unlink($file);
    }

    // Remove from DB
    $update = $conn->prepare("UPDATE users SET profile_photo = NULL WHERE id = ?");
    $update->bind_param("i", $user_id);
    $update->execute();

    $_SESSION['success'] = "Profile photo deleted!";
}

header("Location: dashboard_user.php");
exit();
?>
