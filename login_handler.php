<?php
require 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=empty");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        // If "Remember Me" is checked
        if (isset($_POST['remember'])) {
            $token = bin2hex(random_bytes(16)); // 32-character token
            $expiry = time() + (24 * 60 * 60);  // cookie expiration perion 1 day
            setcookie("remember_token", $token, $expiry, "/", "", false, true);

            // Save token in database (new column needed)
            $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
            $stmt->execute([$token, $user['id']]);

            // Store expiry in session
            $_SESSION['remember_expires'] = $expiry;
        }
        header("Location: dashboard.php");
    } else {
        header("Location: login.php?error=invalid");
        exit();
    }
}
?>
