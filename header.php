<?php

if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
    require 'config.php';
    $token = $_COOKIE['remember_token'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user']['username'] = $user['username'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My PHP Website</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="page-wrapper">
        <header>
            <h1>Student Foods</h1>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <!-- <a class="navbar-brand" href="index.php">MyWebsite</a> -->

                    <!-- Mobile toggle -->
                    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button> -->

                    <!-- Navigation -->
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

                        <!-- Left-aligned links -->
                        <div class="me-auto d-flex gap-2">
                            <a href="index.php" class="btn btn-outline-secondary">Home</a>
                            <a href="about.php" class="btn btn-outline-secondary">About</a>
                            <a href="contact.php" class="btn btn-outline-secondary">Contact Us</a>
                        </div>

                        <!-- Right-aligned links -->
                        <div class="d-flex gap-2">
                            <?php if (isset($_SESSION['user'])): ?>
                            <!-- <a href="dashboard.php" class="btn btn-outline-primary">Dashboard</a> -->
                            <span class="text-black me-3">Logged in as <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></span>
                            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-secondary ms-2" href="profile.php">My Profile</a>
                            </li>
                            <?php else: ?>
                            <a href="signup.php" class="btn btn-primary">Sign Up</a>
                            <a href="login.php" class="btn btn-outline-primary">Login</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- <header class="bg-light border-bottom py-2">
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">My Website</h1>
                <div>
                    <?php if (!isset($_SESSION['user'])): ?>
                        <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                        <a href="signup.php" class="btn btn-primary">Sign Up</a>
                    <?php else: ?>
                        <span class="me-3">Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </header> -->
        <main>
