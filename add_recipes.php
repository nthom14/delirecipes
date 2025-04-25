<!-- add_recipe.php -->
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('db.php');

// Λήψη των δεδομένων από το αίτημα
$data = json_decode(file_get_contents("php://input"), true);

// Εξαγωγή των δεδομένων από το JSON
$title = $data['title'];
$category = $data['category'];
$ingredients = $data['ingredients'];
$instructions = $data['instructions'];

// Ερώτημα για εισαγωγή νέας συνταγής
$query = "INSERT INTO recipes (title, category, ingredients, instructions) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$title, $category, $ingredients, $instructions]);

// Επιστροφή επιτυχίας
echo json_encode(['message' => 'Recipe added successfully']);
?>
