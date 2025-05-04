<?php
require 'config.php'; // This should start the session and connect to DB

if (isset($_SESSION['remember_expires']) && time() > $_SESSION['remember_expires']) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Check session
if (!isset($_SESSION['user'])) {
    // Check "remember me" cookie
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = $user['username'];
        } else {
            // Invalid token, redirect to login
            header("Location: login.php");
            exit();
        }
    } else {
        // No session and no cookie, redirect to login
        header("Location: login.php");
        exit();
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
    <p>This is your dashboard.</p>
</div>

<?php include 'footer.php'; ?>
