<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Sign Up</h2>
    <?php
    if (isset($_GET['error'])) {
        $msg = match ($_GET['error']) {
            'invalid_input' => "Invalid form input.",
            'exists' => "Username or email already exists.",
            default => "An unknown error occurred."
        };
        echo "<div class='alert alert-danger'>$msg</div>";
    } elseif (isset($_GET['signup']) && $_GET['signup'] == 'success') {
        echo "<div class='alert alert-success'>Signup successful! You can now log in.</div>";
    }
    ?>
    <form method="post" action="signup_handler.php" class="needs-validation mt-3" novalidate>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
            <div class="invalid-feedback">Please enter a username.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
            <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" minlength="6" required>
            <div class="invalid-feedback">Password must be at least 6 characters long.</div>
        </div>
        <button type="submit" class="btn btn-success">Register</button>
    </form>

</div>

<?php include 'footer.php'; ?>