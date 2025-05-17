<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$sort = $_GET['sort'] ?? 'desc'; // default: highest rating first
$order = ($sort === 'asc') ? 'ASC' : 'DESC';
$toggleSort = ($sort === 'asc') ? 'desc' : 'asc'; // to toggle on click

// Join recipes with users to get author name
$stmt = $pdo->prepare("
    SELECT r.id, r.title, r.rating, r.is_healthy, u.username
    FROM recipes r
    JOIN users u ON r.user_id = u.id
    WHERE r.rating >= 4
    ORDER BY r.rating $order, r.title ASC
");
$stmt->execute();
$recipes = $stmt->fetchAll();
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Famous Recipes</h2>

    <?php if (count($recipes) === 0): ?>
        <div class="alert alert-info">No famous recipes yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Title</th>
                        <style>
                            th a {
                                cursor: pointer;
                                font-weight: bold;
                            }
                        </style>
                        <th>
                            <a href="?sort=<?= $toggleSort ?>" class="text-decoration-none text-dark">
                                Rating <?= $sort === 'asc' ? '↑' : '↓' ?>
                            </a>
                        </th>
                        <th>Healthy</th>
                        <th>Author</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipes as $recipe): ?>
                        <tr onclick="window.location='recipe_view.php?id=<?= $recipe['id'] ?>&from=famous'" style="cursor:pointer;">
                            <td><?= htmlspecialchars($recipe['title']) ?></td>
                            <td>
                                <span style="color: #f0ad4e; font-size: 1.2rem;">
                                    <?php
                                    $rating = (int)$recipe['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $rating ? "&#9733;" : "&#9734;";
                                    }
                                    ?>
                                </span>
                            </td>
                            <td><?= $recipe['is_healthy'] ? 'Yes' : 'No' ?></td>
                            <td><?= htmlspecialchars($recipe['username']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
