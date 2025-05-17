<?php
require 'config.php';
include 'header.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Logged-in user
$user_id = $_SESSION['user']['id'];

// Get total recipe count
$total = $pdo->query("SELECT COUNT(*) FROM recipes WHERE user_id = $user_id")->fetchColumn();
$total_pages = ceil($total / $limit);

// Fetch recipes
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY title ASC LIMIT $limit OFFSET $offset");
$stmt->execute([$user_id]);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>My Recipes</h2>
    <a href="recipe_create.php" class="btn btn-success mb-3">+ Add New Recipe</a>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?= htmlspecialchars($recipe['title']) ?></td>
                    <td><?= htmlspecialchars($recipe['description']) ?></td>
                    <td><?= $recipe['created_at'] ?></td>
                    <td>
                        <a href="recipe_edit.php?id=<?= $recipe['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="recipe_delete.php?id=<?= $recipe['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this recipe?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                    <a class="page-link" href="recipes.php?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<?php include 'footer.php'; ?>
