// db.php
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'studentfoods';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

