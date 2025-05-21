<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Get search/filter inputs
$q = $_GET['q'] ?? '';
$min_rating = $_GET['min_rating'] ?? '';
$healthy = isset($_GET['healthy']);
$favorite = isset($_GET['favorite']);

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count
$totalQuery = "SELECT COUNT(*) as total FROM recipes";
$totalResult = $pdo->query($totalQuery);
$total = $totalResult->fetch(PDO::FETCH_ASSOC)['total'];

$totalPages = ceil($total / $limit);

// Get paginated recipes with author
// $sql = "SELECT r.*, u.username 
//         FROM recipes r
//         JOIN users u ON r.user_id = u.id
//         ORDER BY r.title ASC
//         LIMIT $limit OFFSET $offset";

// $result = $pdo->query($sql);

// Build SQL with filters
$sql = "SELECT r.*, u.username FROM recipes r 
        JOIN users u ON r.user_id = u.id 
        WHERE 1=1";

$params = [];

if (!empty($q)) {
    $sql .= " AND r.title LIKE :query";
    $params[':query'] = "%$q%";
}

if (!empty($min_rating)) {
    $sql .= " AND r.rating >= :min_rating";
    $params[':min_rating'] = (int)$min_rating;
}

if ($healthy) {
    $sql .= " AND r.is_healthy = 1";
}

if ($favorite) {
    $sql .= " AND r.is_favorite = 1";
}

$sql .= " ORDER BY r.title ASC LIMIT :limit OFFSET :offset";

// Prepare and bind parameters
$stmt = $pdo->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . implode(" | ", $conn->errorInfo()));
}

// Bind params safely
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

if (!$stmt->execute()) {
    die("Execute failed: " . implode(" | ", $stmt->errorInfo()));
}

$recipes = $stmt->fetchAll();

?>

<?php include 'header.php'; ?>

<form method="GET" class="row g-3 mb-4">
  <div class="col-md-4">
    <input type="text" name="q" class="form-control" placeholder="Search recipes..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
  </div>
  <div class="col-md-2">
    <select name="min_rating" class="form-select">
      <option value="">Min Rating</option>
      <?php for ($i = 5; $i >= 1; $i--): ?>
        <option value="<?= $i ?>" <?= (($_GET['min_rating'] ?? '') == $i ? 'selected' : '') ?>><?= $i ?>+</option>
      <?php endfor; ?>
    </select>
  </div>
  <div class="col-md-2">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="healthy" id="healthy" <?= isset($_GET['healthy']) ? 'checked' : '' ?>>
      <label class="form-check-label" for="healthy">Healthy</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="favorite" id="favorite" <?= isset($_GET['favorite']) ? 'checked' : '' ?>>
      <label class="form-check-label" for="favorite">Favorite</label>
    </div>
  </div>
  <div class="col-md-2">
    <button type="submit" class="btn btn-primary">Search</button>
  </div>
</form>

<div class="container mt-4">
    <h2 class="text-center mb-4">All Recipes</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>User</th>
            <th>Rating</th>
            <th>Healthy</th>
            <th>Favorite</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($recipes as $recipe): ?>
            <tr onclick="window.location.href='recipe_view.php?id=<?= $recipe['id'] ?>&from=all_recipes'">
                <td><?= htmlspecialchars($recipe['title']) ?></td>
                <td><?= htmlspecialchars($recipe['username']) ?></td>
                <td>
                    <?php
                    $rating = (int)$recipe['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $rating ? '<span class="text-warning">&#9733;</span>' : '<span class="text-secondary">&#9733;</span>';
                    }
                    ?>
                </td>
                <td><?= $recipe['is_healthy'] ? '✔' : '✘' ?></td>
                <td><?= $recipe['is_favorite'] ? '✔' : '✘' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php include 'footer.php'; ?>
