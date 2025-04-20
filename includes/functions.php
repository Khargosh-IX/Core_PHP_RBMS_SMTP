<?php
// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

// Handle profile photo upload
function uploadPhoto($file) {
    $target_dir = "assets/uploads/";
    $filename = time() . '_' . basename($file["name"]);
    $target_file = $target_dir . $filename;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }

    // Allowed extensions
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        return false;
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $filename;
    } else {
        return false;
    }
}

// Delete photo from server
function deletePhoto($filename) {
    $path = "assets/uploads/" . $filename;
    if (file_exists($path)) {
        unlink($path);
    }
}
