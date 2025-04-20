<?php
session_start();
require_once 'config/db.php';
require_once 'config/mailer.php';

// Only allow logged-in admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get all users except admins
$users = $conn->query("SELECT * FROM users WHERE role = 'user'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <span class="navbar-brand">Admin Dashboard</span>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">RBMS Admin</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block"><?= $_SESSION['user']['name']; ?></a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-4">
        <h3>Registered Users</h3>
        <table class="table table-bordered table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Validation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td>
                            <?php if ($user['is_validated']): ?>
                                <span class="badge badge-success">Validated</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$user['is_validated']): ?>
                                <form method="POST" action="validate_user.php" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                    <input type="hidden" name="email" value="<?= $user['email']; ?>">
                                    <input type="hidden" name="name" value="<?= $user['name']; ?>">
                                    <button class="btn btn-sm btn-success">Validate</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled>Already Validated</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="adminlte/plugins/jquery/jquery.min.js"></script>
<script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
