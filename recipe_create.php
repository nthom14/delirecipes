<?php
session_start();
require 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    $is_healthy = isset($_POST['is_healthy']) ? 1 : 0;
    $is_favorite = isset($_POST['is_favorite']) ? 1 : 0;

    // Simple validation
    if (empty($title)) {
        $error = "Title is required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO recipes (user_id, title, description, rating, is_healthy, is_favorite)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $description, $rating, $is_healthy, $is_favorite]);
        header('Location: recipes.php');
        exit;
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Create New Recipe</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="recipe_create.php">
        <div class="mb-3">
            <label for="title" class="form-label">Recipe Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Recipe Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>

        <!-- <div class="mb-3">
            <label for="rating" class="form-label">Rating (0 to 5)</label>
            <input type="number" class="form-control" id="rating" name="rating" min="0" max="5" step="1" value="0">
        </div> -->
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
                <input type="radio" name="rating" id="rating-5" value="5"><label for="rating-5">&#9733;</label>
                <input type="radio" name="rating" id="rating-4" value="4"><label for="rating-4">&#9733;</label>
                <input type="radio" name="rating" id="rating-3" value="3"><label for="rating-3">&#9733;</label>
                <input type="radio" name="rating" id="rating-2" value="2"><label for="rating-2">&#9733;</label>
                <input type="radio" name="rating" id="rating-1" value="1"><label for="rating-1">&#9733;</label>
                <input type="radio" name="rating" id="rating-0" value="0" checked style="display:none;">
            </div>
        </div>


        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="is_healthy" id="is_healthy" value="1">
            <label class="form-check-label" for="is_healthy">
                Mark as Healthy
            </label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_favorite" id="is_favorite" value="1">
            <label class="form-check-label" for="is_favorite">
                Mark as Favorite
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Save Recipe</button>
        <a href="recipes.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
