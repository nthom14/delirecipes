<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Simple server-side validation
    if (strlen($username) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        header("Location: signup.php?error=invalid_input");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    try {
        $stmt->execute([$username, $email, $hashed_password]);
        header("Location: login.php?signup=success");
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header("Location: signup.php?error=exists");
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
