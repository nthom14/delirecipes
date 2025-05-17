<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $recipe_id = (int) $_POST['id'];
    $user_id = $_SESSION['user']['id'];

    // Check if user owns the recipe
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ? AND user_id = ?");
    $stmt->execute([$recipe_id, $user_id]);
    $recipe = $stmt->fetch();

    if ($recipe) {
        // Delete the recipe
        $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
        $stmt->execute([$recipe_id]);

        $_SESSION['message'] = "Recipe deleted successfully.";
    } else {
        $_SESSION['message'] = "Recipe not found or access denied.";
    }
}

header("Location: dashboard.php");
exit;
