<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Fetch only healthy recipes
$stmt = $pdo->prepare("SELECT id, title, rating, is_favorite FROM recipes WHERE user_id = ? AND is_healthy = 1 ORDER BY title ASC");
$stmt->execute([$user_id]);
$recipes = $stmt->fetchAll();
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Your Healthy Recipes</h2>

    <?php if (count($recipes) === 0): ?>
        <div class="alert alert-info">You have no healthy recipes yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Title</th>
                        <th>Rating</th>
                        <th>Favorite</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipes as $recipe): ?>
                        <tr onclick="window.location='recipe_view.php?id=<?= $recipe['id'] ?>&from=healthy'" style="cursor:pointer;">
                            <td><?= htmlspecialchars($recipe['title']) ?></td>
                            <td>
                                <span style="color: #f0ad4e; font-size: 1.2rem;">
                                    <?php
                                    $rating = (int)$recipe['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $rating ? "&#9733;" : "&#9734;"; // ★ or ☆
                                    }
                                    ?>
                                </span>
                            </td>
                            <td><?= $recipe['is_favorite'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
