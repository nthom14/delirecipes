<?php
session_start();
$name = $email = $subject = $message = '';
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validation
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($subject)) $errors[] = "Subject is required.";
    if (empty($message)) $errors[] = "Message is required.";

    // If valid, simulate storing or sending
    if (empty($errors)) {
        // Here you can insert into DB or send email
        $success = "Your message has been sent successfully!";
        // Reset values
        $name = $email = $subject = $message = '';
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Contact Us</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post" action="contact.php" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" value="<?= htmlspecialchars($subject) ?>" class="form-control" id="subject" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" rows="5" class="form-control" id="message" required><?= htmlspecialchars($message) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>

<?php include 'footer.php'; ?>
