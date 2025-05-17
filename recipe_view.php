<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$recipe_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user']['id'];

if (!$recipe_id) {
    die('Recipe ID missing.');
}

// Fetch the recipe
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ? AND user_id = ?");
$stmt->execute([$recipe_id, $user_id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    die('Recipe not found or unauthorized.');
}
$from = $_GET['from'] ?? null;
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2><?= htmlspecialchars($recipe['title']) ?></h2>

    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>

    <p><strong>Rating:</strong>
        <span style="color: #f0ad4e; font-size: 1.5rem;">
            <?php
            $rating = (int)$recipe['rating'];
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $rating ? "★" : "☆";
            }
            ?>
        </span>
    </p>
    <p><strong>Healthy:</strong> <?= $recipe['is_healthy'] ? 'Yes' : 'No' ?></p>
    <p><strong>Favorite:</strong> <?= $recipe['is_favorite'] ? 'Yes' : 'No' ?></p>

    <?php
        $backLink = 'dashboard.php';
        if ($from === 'healthy') {
            $backLink = 'healthy_recipes.php';
            $backLinkStr = 'Back to Healthy';
        } elseif ($from === 'favorite') {
            $backLink = 'favorite_recipes.php';
            $backLinkStr = 'Back to Favorite';
        } elseif ($from === 'famous') {
            $backLink = 'famous_recipes.php';
            $backLinkStr = 'Back to Famous';
        }
    ?>
    <a href="<?= $backLink ?>" class="btn btn-secondary"><?= $backLinkStr ?></a>
</div>

<?php include 'footer.php'; ?>
