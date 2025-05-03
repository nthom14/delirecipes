<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
session_start();
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        echo "✅ Καλωσήρθες " . $user['email'];
    } else {
        echo "❌ Λάθος κωδικός!";
    }
} else {
    echo "❌ Ο χρήστης δεν υπάρχει!";
}

$stmt->close();
$conn->close();
?>


