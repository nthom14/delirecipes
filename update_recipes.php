<!-- update_recipe.php -->
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "cookbook");

$id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? '';
$ingredients = $_POST['ingredients'] ?? '';
$instructions = $_POST['instructions'] ?? '';
$category_id = $_POST['category_id'] ?? null;

if (!$id || !$title || !$ingredients || !$instructions || !$category_id) {
    echo "Σφάλμα: Όλα τα πεδία είναι υποχρεωτικά.";
    exit;
}

$sql = "UPDATE recipes SET title=?, ingredients=?, instructions=?, category_id=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssii", $title, $ingredients, $instructions, $category_id, $id);
$stmt->execute();

header("Location: recipes.php");
exit;
?>

