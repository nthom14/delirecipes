<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'header.php';
?>

<div class="container mt-5">
    <!-- <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2> -->
    <p>You are now logged in.</p>
    <!-- <a href="logout.php" class="btn btn-danger mt-3">Logout</a> -->
</div>

<?php include 'footer.php'; ?>
