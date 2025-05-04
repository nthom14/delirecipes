<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
setcookie("remember_token", "", time() - 3600, "/"); // expire the cookie
session_destroy();
header("Location: index.php");
exit();
