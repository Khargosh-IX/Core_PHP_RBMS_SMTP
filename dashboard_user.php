<?php
session_start();
require_once 'config/db.php';

// Redirect if not logged in or not user
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

// Fetch updated profile from DB
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

if (!$profile['is_validated']) {
    die("<h2 style='text-align:center;'>Your account is not validated yet. Please wait for admin approval.</h2>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">RBMS User</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 d-flex">
                <div class="image">
                    <?php if ($profile['profile_photo']): ?>
                        <img src="uploads/<?= $profile['profile_photo']; ?>" class="img-circle elevation-2" alt="User Image" style="width:40px; height:40px;">
                    <?php else: ?>
                        <img src="adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="Default">
                    <?php endif; ?>
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?= $profile['name']; ?></a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-4">
        <h3>Welcome, <?= $profile['name']; ?>!</h3>
        <hr>
        <h4>Update Your Profile Photo</h4>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="update_photo.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="photo" class="form-control" required accept="image/*">
            </div>
            <button class="btn btn-primary" type="submit">Upload Photo</button>
            <?php if ($profile['profile_photo']): ?>
                <a href="delete_photo.php" class="btn btn-danger ml-2">Delete Current Photo</a>
            <?php endif; ?>
        </form>
    </div>

</div>

<script src="adminlte/plugins/jquery/jquery.min.js"></script>
<script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
