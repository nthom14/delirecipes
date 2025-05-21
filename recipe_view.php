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

// OLD CODE
// Fetch the recipe
// $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ? AND user_id = ?");
// $stmt->execute([$recipe_id, $user_id]);
// $recipe = $stmt->fetch();
// if (!$recipe) {
//     die('Recipe not found or unauthorized.');
// }

// NEW CODE
$stmt = $pdo->prepare("SELECT r.*, u.username FROM recipes r
                       JOIN users u ON r.user_id = u.id
                       WHERE r.id = :id");
$stmt->execute(['id' => $recipe_id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "Recipe not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_critique'])) {
    if (!empty($_POST['comment'])) {
        $stmt = $pdo->prepare("INSERT INTO critiques (recipe_id, user_id, comment) VALUES (:recipe_id, :user_id, :comment)");
        $stmt->execute([
            'recipe_id' => $recipe['id'],
            'user_id' => $_SESSION['user']['id'],
            'comment' => $_POST['comment']
        ]);
        // Optional: redirect to avoid form resubmission
        header("Location: recipe_view.php?id=" . $recipe['id']);
        exit;
    }
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

    <h4 class="mt-5">Critiques</h4>

    <?php
    $critiqueStmt = $pdo->prepare("
        SELECT c.comment, c.created_at, u.username 
        FROM critiques c
        JOIN users u ON c.user_id = u.id
        WHERE c.recipe_id = :recipe_id
        ORDER BY c.created_at DESC
    ");
    $critiqueStmt->execute(['recipe_id' => $recipe['id']]);
    $critiques = $critiqueStmt->fetchAll();

    if ($critiques):
        foreach ($critiques as $critique):
    ?>
        <div class="border rounded p-2 mb-2">
            <strong><?= htmlspecialchars($critique['username']) ?></strong> 
            <small class="text-muted"><?= $critique['created_at'] ?></small>
            <p class="mb-0"><?= nl2br(htmlspecialchars($critique['comment'])) ?></p>
        </div>
    <?php
        endforeach;
    else:
        echo "<p class='text-muted'>No critiques yet.</p>";
    endif;
    ?>

    <?php if (isset($_SESSION['user']['id'])): ?>
        <form action="" method="post" class="mt-4">
            <div class="mb-3">
                <label for="comment" class="form-label">Leave a critique:</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" name="submit_critique" class="btn btn-primary">Submit</button>
        </form>
    <?php else: ?>
        <p class="mt-4"><a href="login.php">Log in</a> to leave a critique.</p>
    <?php endif; ?>

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
        } elseif ($from === 'all_recipes') {
            $backLink = 'all_recipes.php';
            $backLinkStr = 'Back to All Recipes';
        }
    ?>
    <a href="<?= $backLink ?>" class="btn btn-secondary mt-2"><?= $backLinkStr ?></a>
</div>

<?php include 'footer.php'; ?>
