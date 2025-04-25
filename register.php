<?php
include 'db.php'; // περιλαμβάνει $conn με MySQLi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password_raw = $_POST['password'];

    // 1. Επικύρωση email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Μη έγκυρη διεύθυνση email!";
        exit;
    }

    // 2. Επικύρωση password
    if (strlen($password_raw) < 6) {
        echo "❌ Ο κωδικός πρέπει να έχει τουλάχιστον 6 χαρακτήρες!";
        exit;
    }

    // 3. Έλεγχος αν υπάρχει ήδη το email
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "❌ Το email υπάρχει ήδη!";
        exit;
    }

    // 4. Κρυπτογράφηση του κωδικού
    $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

    // 5. Εισαγωγή χρήστη
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password_hashed);

    if ($stmt->execute()) {
        echo "✅ Εγγραφή επιτυχής!";
    } else {
        echo "❌ Σφάλμα κατά την εγγραφή.";
    }

    $stmt->close();
    $check->close();
}

$conn->close();
?>
