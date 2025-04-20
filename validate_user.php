<?php
session_start();
require_once 'config/db.php';
require_once 'config/mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $name = $_POST['name'];

    // Update the database
    $stmt = $conn->prepare("UPDATE users SET is_validated = 1 WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Send confirmation email to user
        $subject = "Your RBMS Account has been Validated";
        $body = "Hello $name,<br><br>Your account has been successfully validated. You may now log in.<br><br>Thank you!";
        sendMail($email, $subject, $body);

        $_SESSION['success'] = "User validated successfully!";
    } else {
        $_SESSION['error'] = "Error validating user.";
    }

    header("Location: dashboard_admin.php");
    exit();
}
?>
