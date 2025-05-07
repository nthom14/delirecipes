<?php
require 'config.php';
include 'header.php';
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">Contact Us</h2>
    
    <form action="send_contact.php" method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="col-12">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" id="subject" required>
        </div>

        <div class="col-12">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" name="message" id="message" rows="5" required></textarea>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
