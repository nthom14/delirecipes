<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('db.php');

// Ερώτημα για απόκτηση όλων των συνταγών
$query = 'SELECT * FROM recipes';
$stmt = $pdo->prepare($query);
$stmt->execute();

// Επιστροφή των συνταγών σε μορφή JSON
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($recipes);
?>