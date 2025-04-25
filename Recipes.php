<!-- recipes.php -->
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "cookbook");
$recipes = $conn->query("SELECT * FROM recipes");
?>
<ul>
<?php while ($r = $recipes->fetch_assoc()): ?>
  <li>
    <h3><?= $r['title'] ?></h3>
    <p><?= $r['ingredients'] ?></p>
    <a href="edit_recipe.php?id=<?= $r['id'] ?>">Επεξεργασία</a>
    <form action="delete_recipe.php" method="post" style="display:inline;">
      <input type="hidden" name="id" value="<?= $r['id'] ?>">
      <input type="submit" value="Διαγραφή" onclick="return confirm('Θέλεις σίγουρα;');">
    </form>
  </li>
<?php endwhile; ?>
</ul>