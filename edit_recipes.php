<!-- edit_recipe.php -->
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "cookbook");
$id = $_GET['id'] ?? 0;

// Χρήση prepared statement
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$recipe = $stmt->get_result()->fetch_assoc();

if (!$recipe) {
    echo "Η συνταγή δεν βρέθηκε.";
    exit;
}

$categories = $conn->query("SELECT * FROM categories");
?>

<form action="update_recipe.php" method="post">
  <input type="hidden" name="id" value="<?= htmlspecialchars($recipe['id']) ?>">
  <input type="text" name="title" value="<?= htmlspecialchars($recipe['title']) ?>">
  <textarea name="ingredients"><?= htmlspecialchars($recipe['ingredients']) ?></textarea>
  <textarea name="instructions"><?= htmlspecialchars($recipe['instructions']) ?></textarea>
  <select name="category_id">
    <?php while($cat = $categories->fetch_assoc()): ?>
      <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $recipe['category_id'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($cat['name']) ?>
      </option>
    <?php endwhile; ?>
  </select>
  <input type="submit" value="Αποθήκευση Αλλαγών">
</form>

