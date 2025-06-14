<?php include 'header.php'; ?>

<?php
require 'config.php';

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<div class="container mt-5 text-center">
    <h2 class="mb-3">Welcome!</h2>
    <p class="mb-4">Please sign up or log in to continue.</p>
    <!-- <a href="signup.php" class="btn btn-primary me-2">Sign Up</a>
    <a href="login.php" class="btn btn-outline-primary">Login</a> -->
</div>

<?php include 'footer.php'; ?>
