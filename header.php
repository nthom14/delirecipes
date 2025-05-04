<?php

if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
    require 'config.php';
    $token = $_COOKIE['remember_token'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user['username'];
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
            <h1>My Website</h1>
            <nav>
                <a href="index.php">Home</a>
            </nav>
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">My Website</h1>
                <div>
                    <?php if (!isset($_SESSION['user'])): ?>
                        <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                        <a href="signup.php" class="btn btn-primary">Sign Up</a>
                    <?php else: ?>
                        <span class="me-3">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <!-- <header class="bg-light border-bottom py-2">
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">My Website</h1>
                <div>
                    <?php if (!isset($_SESSION['user'])): ?>
                        <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                        <a href="signup.php" class="btn btn-primary">Sign Up</a>
                    <?php else: ?>
                        <span class="me-3">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </header> -->
        <main>
