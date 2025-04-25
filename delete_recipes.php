<!-- delete_recipe.php -->
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "cookbook");
$id = $_POST['id'];
$sql = "DELETE FROM recipes WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: recipes.php");
?>
