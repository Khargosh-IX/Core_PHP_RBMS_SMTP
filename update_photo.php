<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    $filename = time() . '_' . basename($file['name']);
    $target = 'uploads/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        $stmt = $conn->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
        $stmt->bind_param("si", $filename, $user_id);
        $stmt->execute();

        $_SESSION['success'] = "Profile photo updated!";
    } else {
        $_SESSION['error'] = "Failed to upload photo.";
    }

    header("Location: dashboard_user.php");
    exit();
}
?>
