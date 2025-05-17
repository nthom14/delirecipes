<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$recipe_id = $_GET['id'] ?? null;

if (!$recipe_id) {
    die('Recipe ID missing.');
}

// Fetch recipe
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ? AND user_id = ?");
$stmt->execute([$recipe_id, $user_id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    die('Recipe not found or unauthorized.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    $is_healthy = isset($_POST['is_healthy']) ? 1 : 0;
    $is_favorite = isset($_POST['is_favorite']) ? 1 : 0;

    if (empty($title)) {
        $error = "Title is required.";
    } else {
        $stmt = $pdo->prepare("UPDATE recipes SET title = ?, description = ?, rating = ?, is_healthy = ?, is_favorite = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $description, $rating, $is_healthy, $is_favorite, $recipe_id, $user_id]);
        header('Location: recipes.php');
        exit;
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Edit Recipe</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Recipe Title</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="<?= htmlspecialchars($recipe['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Recipe Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($recipe['description']) ?></textarea>
        </div>

        <!-- Star Rating -->
        <style>
            .star-rating {
                direction: rtl;
                font-size: 2rem;
                unicode-bidi: bidi-override;
                display: inline-flex;
            }
            .star-rating input[type="radio"] {
                display: none;
            }
            .star-rating label {
                color: #ccc;
                cursor: pointer;
            }
            .star-rating input[type="radio"]:checked ~ label,
            .star-rating label:hover,
            .star-rating label:hover ~ label {
                color: #f0ad4e;
            }
        </style>

        <div class="mb-3">
            <label class="form-label">Rating</label>
            <div class="star-rating">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                    <input type="radio" name="rating" id="rating-<?= $i ?>" value="<?= $i ?>"
                        <?= ($recipe['rating'] == $i) ? 'checked' : '' ?>>
                    <label for="rating-<?= $i ?>">&#9733;</label>
                <?php endfor; ?>
                <input type="radio" name="rating" id="rating-0" value="0" <?= ($recipe['rating'] == 0) ? 'checked' : '' ?> style="display:none;">
            </div>
        </div>

        <!-- Healthy Checkbox -->
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="is_healthy" id="is_healthy" value="1"
                <?= $recipe['is_healthy'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_healthy">
                Mark as Healthy
            </label>
        </div>

        <!-- Favorite Checkbox -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_favorite" id="is_favorite" value="1"
                <?= $recipe['is_favorite'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_favorite">
                Mark as Favorite
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Update Recipe</button>
        <a href="recipes.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
